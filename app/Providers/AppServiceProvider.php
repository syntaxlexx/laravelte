<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->registerFacades();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        if(env('DEBUGBAR_ENABLED', false)) {
            \Debugbar::enable();
        }

        $this->loadMacros();
    }


    /**
     * register app macros
     * convert to collection this way:
     * $collection = collect($data)->recursive(); // $data is multidimensional array
     */
    public function loadMacros()
    {
        \Illuminate\Support\Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });

        \Illuminate\Support\Collection::macro('sortByDate', function (string $column = 'created_at', bool $descending = true) {
            return $this->sortBy(function ($datum) use ($column) {
                return strtotime(((object)$datum)->$column);
            }, SORT_REGULAR, $descending);
        });
    }
}
