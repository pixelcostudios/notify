<?php

/*
 * This file is part of the yoeunes/notify package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Yoeunes\Notify\Notifiers;

use function basename;

abstract class AbstractNotifier
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Toastr constructor.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Render the notifications' script tag.
     */
    public function render(array $notifications): string
    {
        return '<script type="text/javascript">'.$this->options().$this->notificationsAsString($notifications).'</script>';
    }

    /**
     * Get global toastr options.
     */
    public function options(): string
    {
        return '';
    }

    public function notificationsAsString(array $notifications): string
    {
        return implode('', $this->notifications($notifications));
    }

    /**
     * map over all notifications and create an array of toastrs.
     */
    public function notifications(array $notifications): array
    {
        return array_map(
            function ($n) {
                return $this->notify($n['type'], $n['message'], $n['title'], $n['options']);
            },
            $notifications
        );
    }

    /**
     * Create a single notification.
     *
     * @param null|string $title
     * @param null|string $options
     */
    abstract public function notify(string $type, string $message = '', string $title = '', string $options = ''): string;

    /**
     * Get Allowed Types.
     */
    public function getAllowedTypes(): array
    {
        return $this->config['types'];
    }

    public function getName(): string
    {
        return basename(static::class);
    }
}
