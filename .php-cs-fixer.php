<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-schema-validator
 */

use Ergebnis\License;
use Ergebnis\PhpCsFixer;

$license = License\Type\MIT::markdown(
    __DIR__ . '/LICENSE.md',
    License\Range::since(
        License\Year::fromString('2021'),
        new DateTimeZone('UTC'),
    ),
    License\Holder::fromString('Andreas Möller'),
    License\Url::fromString('https://github.com/ergebnis/json-schema-validator'),
);

$license->save();

$ruleSet = PhpCsFixer\Config\RuleSet\Php74::create()->withHeader($license->header());

$config = PhpCsFixer\Config\Factory::fromRuleSet($ruleSet);

$config->getFinder()
    ->exclude([
        '.build/',
        '.github/',
        '.note/',
    ])
    ->ignoreDotFiles(false)
    ->in(__DIR__);

$config->setCacheFile(__DIR__ . '/.build/php-cs-fixer/.php-cs-fixer.cache');

return $config;
