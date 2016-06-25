<?php

namespace Buzzylab\Aip\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class AipFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'arabic';
    }
}
