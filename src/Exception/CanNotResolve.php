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

use Ergebnis\Json\SchemaValidator;

final class CanNotResolve extends \InvalidArgumentException
{
    public static function jsonPointer(SchemaValidator\JsonPointer $jsonPointer): self
    {
        return new self(\sprintf(
            'Can not resolve JSON pointer "%s".',
            $jsonPointer->toString(),
        ));
    }
}
