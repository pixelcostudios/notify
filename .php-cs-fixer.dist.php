<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

if (!file_exists(__DIR__.'/src')) {
    exit(0);
}

$header = <<<'EOF'
This file is part of the yoeunes/notify package.
(c) Younes KHOUBZA <younes.khoubza@gmail.com>
EOF;

$finder = new PhpCsFixer\Finder();
$finder->in(__DIR__)->exclude(__DIR__.'/vendor');

return (new PhpCsFixer\Config())->setFinder($finder)
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12:risky' => true,
    ]);
