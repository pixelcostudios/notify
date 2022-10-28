<?php

/*
 * This file is part of the yoeunes/notify package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Yoeunes\Notify\Notify;

if (!function_exists('notify')) {
    /**
     * @param string $message
     */
    function notify(string $message = null, string $type = 'success', string $title = '', array $options = []): Notify
    {
        if (null === $message) {
            return app('notify');
        }

        return app('notify')->addNotification($type, $message, $title, $options);
    }
}

if (!function_exists('notify_js')) {
    function notify_js(): string
    {
        $driver = config('notify.default');
        $scripts = config('notify.'.$driver.'.notify_js');

        return '<script type="text/javascript" src="'.implode('"></script><script type="text/javascript" src="', $scripts).'"></script>';
    }
}

if (!function_exists('notify_css')) {
    function notify_css(): string
    {
        $driver = config('notify.default');
        $styles = config('notify.'.$driver.'.notify_css');

        return '<link rel="stylesheet" type="text/css" href="'.implode('"><link rel="stylesheet" type="text/css" href="', $styles).'">';
    }
}
