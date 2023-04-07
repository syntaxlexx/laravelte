<?php

namespace App\Traits;

use App\Library\SiteConstants;

trait QueueMailConstants
{
    /**
     * Get no-reply email for mailing
     *
     * @return array
     */
    public function noReplyEmail($domain = null) : array
    {
        if($domain) {
            $domains = redis()->get('domains');
            $theDomain = $domains->where('url', $domain)->first();

            if($theDomain) {
                $orgs = redis()->get('organisations');
                $theOrg = $orgs->where('domain_id', $theDomain->id)->first();

                if($theOrg) {
                    $theOrg = (Array)$theOrg;
                    $email = $theOrg['no_reply_email'] ?? $theOrg['support_email'];
                    if(! $email)
                        $email = $theOrg['email'];
                    if(! $email)
                        $email = env('MAIL_FROM_ADDRESS');

                    return [
                        'email' => $email,
                        'name' => $theOrg['name'],
                    ];
                }
            }
        }

        $data = (new SiteConstants())->data();

        $email = $data['site_no_reply_email'] ?? $data['site_support_email'];
        if(! $email)
            $email = $data['site_email'];
        if(! $email)
            $email = env('MAIL_FROM_ADDRESS');

        $name = $data['site_name'];
        if(! $name) {
            $name = env('MAIL_FROM_NAME') . ' - ' . env('APP_NAME');
        }

        return [
            'email' => $email,
            'name' => $name,
        ];
    }

    /**
     * Get Company Email
     *
     * @return string
     */
    public function organizationEmail()
    {
        $data = (new SiteConstants())->data();

        $email = $data['site_support_email'] ?? $data['site_email'];
        if(! $email)
            $email = env('MAIL_FROM_ADDRESS');

        return $email;
    }

    /**
     * Get Company Name
     *
     * @return string
     */
    public function organizationName()
    {
        $data = (new SiteConstants())->data();

        $name = $data['site_name'];
        if(! $name)
            $name = env('APP_NAME');

        return $name;
    }
}
