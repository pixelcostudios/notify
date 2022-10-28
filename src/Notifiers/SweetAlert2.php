<?php

/*
 * This file is part of the yoeunes/notify package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Yoeunes\Notify\Notifiers;

class SweetAlert2 extends AbstractNotifier implements NotifierInterface
{
    /**
     * Get global toastr options.
     */
    public function options(): string
    {
        return 'const toast = swal.mixin('.json_encode($this->config['options']).');';
    }

    /**
     * Create a single notification.
     *
     * @param null|string $title
     * @param null|string $options
     */
    public function notify(string $type, string $message = '', string $title = '', string $options = ''): string
    {
        $options = substr($options, 1, -1);

        if (empty($options)) {
            return "toast({title:'{$title}', text:'{$message}', type:'{$type}'});";
        }

        return "toast({title:'{$title}', text:'{$message}', type:'{$type}', {$options}});";
    }
}
