<?php
namespace App\Contracts;
use Illuminate\Support\Facades\Facade;

class CustomLog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'customlog';
    }
}