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

namespace Ergebnis\Json\SchemaValidator\Exception;

final class InvalidSchema extends \InvalidArgumentException implements Exception
{
    public static function notAnObject(): self
    {
        return new self('Value does not appear to be a valid JSON schema.');
    }
}
