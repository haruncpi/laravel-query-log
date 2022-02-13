<?php namespace Haruncpi\QueryLog;

use Illuminate\Support\ServiceProvider;

class QueryLogServiceProvider extends ServiceProvider
{

    /**
     * @throws \Exception
     */
    public function boot()
    {
        if (env('QUERY_LOG', false)) {
            new QueryLog;
        }
    }

    public function register()
    {
    }

}