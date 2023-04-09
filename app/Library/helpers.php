<?php

use App\Models\Configuration;
use App\Models\User;
use App\Repositories\RedisRepository;
use App\Repositories\SystemInfoRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;


if (! function_exists('isDemo'))
{
    /**
     * Check if app is in demo
     */
    function isDemo() : bool
    {
        return app()->environment() == "demo";
    }
}


if (! function_exists('debugOn'))
{
    /**
     * Check if app debug is enabled
     */
    function debugOn() : bool
    {
        return env('APP_DEBUG');
    }
}

if (! function_exists('ddOnError'))
{
    /**
     * dd on error
     */
    function ddOnError(Exception $e) : void
    {
        if(debugOn() && env('DD_ON_ERROR', true))
            dde($e->getMessage());
    }
}


if(! function_exists('doe'))
{
    /**
     * Returns the logged in user w.r.t. the request
     */
    function doe()
    {
        return auth()->user() ?? auth()->guard('api')->user();
    }
}


if (! function_exists('deny'))
{
    /**
     * custom abort code for non-authorized persons
     *
     * @param string|null $message
     */
    function deny(string $message = null)
    {
        $handler = config("system.abort");

        $defaultMessage = trans('crud.unauthorised');
        return App::abort($handler['code'], $message ?? $handler['message'] ?? $defaultMessage);
    }
}


if (! function_exists('redis'))
{
    /*
     * Return an instance of our custom redis repository
     */
    function redis()
    {
        return resolve(RedisRepository::class);
    }
}


if (! function_exists('resetRedis'))
{
    /**
     * reset redis after setting update
     *
     * @param string $target
     */
    function resetRedis($target = 'redis')
    {
        // refresh redis
        $repo = resolve(SystemInfoRepository::class);
        $repo->reset($target);
    }
}

if (!function_exists('setting'))
{
    /**
     * Retrieve a setting configuration value.
     *
     * @param string $setting
     * @param string|null $default
     *
     * @return mixed
     */
    function setting(string $setting, $default = null)
    {
        $val = redis()->get('configurations')->where('name', $setting)->first();
        if(! $val)
            return $default;

        $val = (object) $val;
        return $val->type == Configuration::TYPE_BOOL ? (bool) $val->value : $val->value;
    }
}


if (! function_exists('sizeForHumans'))
{
    /**
     * get file sizes that are human readable
     * @param $size // pass in kilobytes (like Laravel storage does)
     */
    function sizeForHumans($size) : string
    {
        $kiloBytes = $size;

        if($kiloBytes < 1000)
            return $kiloBytes . ' KB';
        else if($kiloBytes < (1000 * 1000))
            return number_format(($kiloBytes / 1000), 2) . ' MB';

        return number_format(($kiloBytes / (1000 * 1000)), 2) . ' GB';
    }
}

if(!function_exists('instanceOfResource'))
{
    /**
     * Check if data is an instance of resource, jsonResource, or resourceCollection
     */
    function instanceOfResource($data)
    {
        return $data instanceof ResourceCollection
            || $data instanceof JsonResource;
    }
}

if(! function_exists("eclair"))
{
    /**
     * Prepares a date for a more user ready format
     */
    function eclair($date, $time = true, $toW3cString = false)
    {
        if(!$date)
            return null;

        if($toW3cString)
            return Carbon::parse($date)->toW3cString();

        if($time) {
            return Carbon::parse($date)->format("M d, Y h:i:s a");
        }

        return Carbon::parse($date)->format("M d, Y");
    }
}


if (!function_exists('dde'))
{

    /**
     * add to the default dd()
     * to return 500 response code for ajax error detection
     */
    function dde(...$vars)
    {
        http_response_code(500);

        foreach ($vars as $v) {
            \Symfony\Component\VarDumper\VarDumper::dump($v);
        }

        die(1);
    }
}


if (!function_exists('filenameSanitizer')) {

    /**
    * filename sanitizer
    *
    * @var mixed Request
    */
    function filenameSanitizer($str) {
        $nicename = str_replace(' ', '-', strtolower($str));
        // Remove anything which isn't a word, whitespace, number,
        // or any of the following characters -_~,;[]().
        // if you don't need to handle multi-byte characters
        // you can use preg_replace rather than mb_ereg_replace
        $nicename = preg_replace('([^\w\s\d\-_~,;\[\]\(\).])', '', $nicename);
        // remove any runs of periods
        $nicename = preg_replace('([\.]{2,})', '', $nicename);
        // remove any non-alpha-numeric characters
        $nicename = preg_replace("/[^a-zA-Z0-9]+/", "", $nicename);
        // ensure the length is more than ten characters
        if(strlen($nicename) < 10)
            $nicename .= "-" . Str::random(10);

        return $nicename;
    }
}

if(! function_exists('command_exists'))
{
    /**
     * Check if an artisan command exists
     *
     * @param $name
     *
     * @return bool
     */
    function command_exists($name)
    {
        return Arr::has(Artisan::all(), $name);
    }
}


if (! function_exists('localizeDate'))
{
    /**
     * Convert the given date to the $timezone or logged in users timezone.
     *
     * @param mixed $date A Carbon date or a parsable date format.
     * @param string $timezone A PHP timezone. If null it will use the logged in users timezone.
     * @return string The localized date.
     */
    function localizeDate($date, $timezone = null)
    {
        if (!($date instanceof Carbon)) {
            $date = is_numeric($date) ? Carbon::createFromTimestamp($date) : Carbon::parse($date);
        }

        return $date->setTimezone($timezone ?? (doe() ? doe()->timezone : 'UTC'));
    }
}

if (! function_exists('localizeDateFormat'))
{
    /**
     * Convert the given date to the $timezone or logged in users timezone.
     * Then format it to the given format.
     *
     * @param mixed $date A Carbon date, array of parameters or a parsable date format.
     * @param string $format A PHP date time format.
     * @param string $timezone A PHP timezone. If null it will use the logged in users timezone.
     * @return string The formatted date.
     */
    function localizeDateFormat($date, $format = 'jS M Y, g:ia', $timezone = null)
    {
        // Support array input as primary arg
        if (is_array($date) && !empty($date)) {

            // If format exists
            if (count($date) >= 2) {
                $format = $date[1];
            }

            // If timezone exists
            if (count($date) >= 3) {
                $timezone = $date[2];
            }

            $date = $date[0];
        }

        return Carbon::parse(localizeDate($date, $timezone))->format($format);
    }
}


if(! function_exists('is_serialized'))
{
    /**
     * check if is serialized or not.
     * Borrowed from WordPress
     */
    function is_serialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (! is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (! preg_match('/^([adObis]):/', $data, $badions))
            return false;
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                    return true;
                break;
        }

        return false;
    }
}

if (! function_exists('adminUsers'))
{
    /**
     * Get the admin users in the system
     * Userfule when one requires to alert admins of an activity
     */
    function adminUsers()
    {
        return User::admins()->get();
    }
}


if(! function_exists('sanitizeDomainUrl'))
{
    /**
     * Sanitize URL
     *
     * @var string $str
     * @return string
     */
    function sanitizeDomainUrl($str = "") : string
    {
        empty($str) ? $str = request()->root() : null;

        // $input = 'www.google.co.uk/';
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $str = trim($str, '/');

        // If scheme not included, prepend it
        if (! preg_match('#^http(s)?://#', $str)) {
            $str = 'http://' . $str;
        }

        $urlParts = parse_url($str);

        // remove www
        $domain = preg_replace('/^www\./', '', $urlParts['host']);

        // output: google.co.uk
        return $domain;
    }
}
