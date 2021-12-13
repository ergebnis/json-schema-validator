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

namespace Ergebnis\Json\SchemaValidator;

/**
 * @psalm-immutable
 */
final class ValidationError
{
    private JsonPointer $jsonPointer;
    private Message $message;

    private function __construct(
        JsonPointer $jsonPointer,
        Message $message
    ) {
        $this->jsonPointer = $jsonPointer;
        $this->message = $message;
    }

    public static function create(
        JsonPointer $jsonPointer,
        Message $message
    ): self {
        return new self(
            $jsonPointer,
            $message,
        );
    }

    public function jsonPointer(): JsonPointer
    {
        return $this->jsonPointer;
    }

    public function message(): Message
    {
        return $this->message;
    }
}
