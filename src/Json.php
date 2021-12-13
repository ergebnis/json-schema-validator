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
final class Json
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @throws Exception\InvalidJson
     */
    public static function fromString(string $value): self
    {
        $decoded = \json_decode($value);

        if (
            null === $decoded
            && \JSON_ERROR_NONE !== \json_last_error()
        ) {
            throw Exception\InvalidJson::string();
        }

        return new self($value);
    }

    /**
     * @throws Exception\CanNotBeRead
     * @throws Exception\DoesNotExist
     * @throws Exception\InvalidJson
     */
    public static function fromFile(string $file): self
    {
        if (!\is_file($file)) {
            throw Exception\DoesNotExist::file($file);
        }

        $value = \file_get_contents($file);

        if (!\is_string($value)) {
            throw Exception\CanNotBeRead::file($file);
        }

        $decoded = \json_decode($value);

        if (
            null === $decoded
            && \JSON_ERROR_NONE !== \json_last_error()
        ) {
            throw Exception\InvalidJson::file($file);
        }

        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
