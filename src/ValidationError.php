<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2022 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-schema-validator
 */

namespace Ergebnis\Json\SchemaValidator;

use Ergebnis\Json\Pointer;

/**
 * @psalm-immutable
 */
final class ValidationError
{
    private function __construct(
        private Pointer\JsonPointer $jsonPointer,
        private Message $message,
    ) {
    }

    public static function create(
        Pointer\JsonPointer $jsonPointer,
        Message $message,
    ): self {
        return new self(
            $jsonPointer,
            $message,
        );
    }

    public function jsonPointer(): Pointer\JsonPointer
    {
        return $this->jsonPointer;
    }

    public function message(): Message
    {
        return $this->message;
    }
}
