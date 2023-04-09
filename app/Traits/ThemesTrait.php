<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * trait ThemesTrait
 * To be used with laravel inertia
 */
trait ThemesTrait
{
    /**
     * generate page data and return the page
     * $blade can be 'about', 'about.our-services'
     *
     * @param string $page
     * @param string $component
     * @param array $params
     * @param bool $bypassSeo
     * @param null $bypassedSeoTitle
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generatePage(string $page, string $component, array $params = [], bool $bypassSeo = false, $bypassedSeoTitle = null)
    {
        $title = $bypassSeo ? $bypassedSeoTitle : "";

        if(empty($title))
        {
            $title = $this->generateTitleFromComponentName($component);
        }

        return inertia($component, array_merge([

            'title' => $title,
            'page' => ucwords($page),

        ], $params));
    }

    /**
     * generate backend page data and return the page
     * $blade can be 'Admin/Settings/Index'
     *
     * @param string $component
     * @param array $params
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generateBackendPage(string $component, array $params = [])
    {
        if(! isset($params['title']))
        {
            $params['title'] = $this->generateTitleFromComponentName($component);
        }

        $prefix = doe()->isAdmin || doe()->isSudo ? 'Admin/' : 'User/';

        return inertia($prefix . $component, $params);
    }

    /**
     * generate title from component name
     * @param string $component
     * @return string
     */
    public function generateTitleFromComponentName(string $component)  : string
    {
        $collection = collect(explode('/', $component));
        $title = (string) $collection->last();

        $excludes = collect(['index', 'create', 'edit', 'show', 'refresh', 'delete', 'update', 'store', 'destroy']);

        if($excludes->contains(strtolower($title)))
        {
            $collection->pop();
            $title = $collection->last();
        }

        // split pascal case to individual letters
        $pieces = preg_split('/(?=[A-Z])/', $title);
        $title = trim(implode(' ', $pieces));

        return Str::title($title);
    }

}
