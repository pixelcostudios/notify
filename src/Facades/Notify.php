<?php

/*
 * This file is part of the yoeunes/notify package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Yoeunes\Notify\Facades;

use Illuminate\Support\Facades\Facade;

class Notify extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'notify';
    }
}
