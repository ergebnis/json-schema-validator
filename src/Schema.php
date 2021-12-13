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

final class Schema
{
    private \stdClass $decoded;

    private function __construct(\stdClass $decoded)
    {
        $this->decoded = $decoded;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public static function fromJson(Json $json): self
    {
        $decoded = \json_decode($json->toString());

        if (!$decoded instanceof \stdClass) {
            throw Exception\InvalidSchema::notAnObject();
        }

        return new self($decoded);
    }

    public function decoded(): \stdClass
    {
        return $this->decoded;
    }
}
