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

final class Decoder
{
    /**
     * @throws Exception\InvalidJson
     *
     * @return null|array|bool|float|int|string
     */
    public function decodeAssociative(string $value)
    {
        $decoded = \json_decode(
            $value,
            true
        );

        if (null === $decoded && \JSON_ERROR_NONE !== \json_last_error()) {
            throw Exception\InvalidJson::string();
        }

        return $decoded;
    }

    /**
     * @throws Exception\InvalidJson
     *
     * @return null|array|bool|float|int|\stdClass|string
     */
    public function decodeNonAssociative(string $value)
    {
        $decoded = \json_decode(
            $value,
            false
        );

        if (null === $decoded && \JSON_ERROR_NONE !== \json_last_error()) {
            throw Exception\InvalidJson::string();
        }

        return $decoded;
    }
}
