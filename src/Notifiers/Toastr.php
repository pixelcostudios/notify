<?php

/*
 * This file is part of the yoeunes/notify package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Yoeunes\Notify\Notifiers;

class Toastr extends AbstractNotifier implements NotifierInterface
{
    /**
     * Get global toastr options.
     */
    public function options(): string
    {
        return 'toastr.options = '.json_encode($this->config['options']).';';
    }

    /**
     * Create a single notification.
     *
     * @param null|string $title
     * @param null|string $options
     */
    public function notify(string $type, string $message = '', string $title = '', string $options = ''): string
    {
        return "toastr.{$type}('{$message}', '{$title}', {$options});";
    }
}
