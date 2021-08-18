<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-schema-validator
 */

namespace Ergebnis\Json\SchemaValidator\Exception;

final class InvalidJson extends \InvalidArgumentException
{
    public static function string(): self
    {
        return new self('Value does not appear to be a valid JSON string.');
    }

    public static function file(string $name): self
    {
        return new self(\sprintf(
            'File "%s" does not contain a valid JSON string.',
            $name,
        ));
    }
}
