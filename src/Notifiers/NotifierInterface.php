<?php

/*
 * This file is part of the yoeunes/notify package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Yoeunes\Notify\Notifiers;

interface NotifierInterface
{
    /**
     * Render the notifications' script tag.
     */
    public function render(array $notifications): string;

    /**
     * Get Allowed Types.
     */
    public function getAllowedTypes(): array;

    public function getName(): string;
}
