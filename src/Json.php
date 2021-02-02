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

final class Json
{
    private $encoded;

    private function __construct(string $encoded)
    {
        $this->encoded = $encoded;
    }

    /**
     * @throws Exception\InvalidJson
     */
    public static function fromString(string $encoded): self
    {
        $decoded = \json_decode($encoded);

        if (null === $decoded && \JSON_ERROR_NONE !== \json_last_error()) {
            throw Exception\InvalidJson::string();
        }

        return new self($encoded);
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

        $encoded = \file_get_contents($file);

        if (!\is_string($encoded)) {
            throw Exception\CanNotBeRead::file($file);
        }

        $decoded = \json_decode($encoded);

        if (null === $decoded && \JSON_ERROR_NONE !== \json_last_error()) {
            throw Exception\InvalidJson::file($file);
        }

        return new self($encoded);
    }

    public function encoded(): string
    {
        return $this->encoded;
    }
}
