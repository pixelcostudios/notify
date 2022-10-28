<?php

/*
 * This file is part of the yoeunes/notify package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Yoeunes\Notify;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;
use RuntimeException;
use Yoeunes\Notify\Notifiers\NotifierInterface;

/**
 * @method error(string $message, string $title = '', array $options = [])
 * @method info(string $message, string $title = '', array $options = [])
 * @method success(string $message, string $title = '', array $options = [])
 * @method warning(string $message, string $title = '', array $options = [])
 * @method alert(string $message, string $title = '', array $options = [])
 * @method notice(string $message, string $title = '', array $options = [])
 * @method question(string $message, string $title = '', array $options = [])
 */
class Notify
{
    public const NOTIFICATIONS_NAMESPACE = 'notify::notifications';

    /**
     * Added notifications.
     *
     * @var array
     */
    protected $notifications = [];

    /**
     * Illuminate Session.
     *
     * @var \Illuminate\Session\SessionManager
     */
    protected $session;

    /**
     * Notification config.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var NotifyInterface
     */
    protected $notifier;

    /**
     * Notification constructor.
     */
    public function __construct(NotifierInterface $notifier, SessionManager $session, Repository $config)
    {
        $this->notifier = $notifier;

        $this->session = $session;

        $this->config = $config;

        $this->notifications = $this->session->get(self::NOTIFICATIONS_NAMESPACE, []);
    }

    public function __call($method, $arguments)
    {
        if (!\in_array($method, $this->notifier->getAllowedTypes(), true)) {
            throw new RuntimeException('Invalid type "'.$method.'" for the "'.$this->notifier->getName().'"');
        }

        $this->addNotification($method, ...$arguments);
    }

    /**
     * Add a notification.
     *
     * @param string $type    could be error, info, success, or warning
     * @param string $message The notification's message
     * @param string $title   The notification's title
     */
    public function addNotification(string $type, string $message, string $title = '', array $options = []): self
    {
        if (!\in_array($type, $this->notifier->getAllowedTypes(), true)) {
            throw new RuntimeException('Invalid type "'.$type.'" for the "'.$this->notifier->getName().'"');
        }

        $this->notifications[] = [
            'type' => $type,
            'title' => $this->escapeSingleQuote($title),
            'message' => $this->escapeSingleQuote($message),
            'options' => json_encode($options),
        ];

        $this->session->flash(self::NOTIFICATIONS_NAMESPACE, $this->notifications);

        return $this;
    }

    /**
     * Render the notifications' script tag.
     */
    public function render(): string
    {
        $notification = $this->notifier->render($this->notifications);

        $this->session->forget(self::NOTIFICATIONS_NAMESPACE);

        return $notification;
    }

    /**
     * Clear all notifications.
     */
    public function clear(): self
    {
        $this->notifications = [];

        $this->session->forget(self::NOTIFICATIONS_NAMESPACE);

        return $this;
    }

    /**
     * helper function to escape single quote for example for french words.
     */
    private function escapeSingleQuote(string $value): string
    {
        return str_replace("'", "\\'", $value);
    }
}
