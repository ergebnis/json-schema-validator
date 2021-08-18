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

namespace Ergebnis\Json\SchemaValidator\Test\Unit;

use Ergebnis\Json\SchemaValidator\Decoder;
use Ergebnis\Json\SchemaValidator\Json;
use Ergebnis\Json\SchemaValidator\Schema;
use Ergebnis\Json\SchemaValidator\SchemaValidator;
use Ergebnis\Test\Util;
use JsonSchema\Validator;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\SchemaValidator
 *
 * @uses \Ergebnis\Json\SchemaValidator\Decoder
 * @uses \Ergebnis\Json\SchemaValidator\Json
 * @uses \Ergebnis\Json\SchemaValidator\Result
 * @uses \Ergebnis\Json\SchemaValidator\Schema
 */
final class SchemaValidatorTest extends Framework\TestCase
{
    use Util\Helper;

    public function testValidateReturnsResultWhenDataIsNotValidAccordingToSchema(): void
    {
        $json = Json::fromString(
            <<<'JSON'
{
    "number": 1600,
    "street_name": "Pennsylvania",
    "street_type": "Avenue",
    "direction": "NW"
}
JSON
        );

        $schema = Schema::fromJson(Json::fromString(
            <<<'JSON'
{
    "type": "object",
    "properties": {
        "name": {
            "type": "string"
        },
        "email": {
            "type": "string"
        },
        "address": {
            "type": "string"
        },
        "telephone": {
            "type": "string"
        }
    },
    "required": [
        "name",
        "email"
    ],
    "additionalProperties": false
}
JSON
        ));

        $validator = new SchemaValidator(
            new Decoder(),
            new Validator(),
        );

        $result = $validator->validate(
            $json,
            $schema,
        );

        self::assertFalse($result->isValid());

        $expected = [
            'name: The property name is required',
            'email: The property email is required',
            'The property number is not defined and the definition does not allow additional properties',
            'The property street_name is not defined and the definition does not allow additional properties',
            'The property street_type is not defined and the definition does not allow additional properties',
            'The property direction is not defined and the definition does not allow additional properties',
        ];

        self::assertSame($expected, $result->errors());
    }

    public function testValidateReturnsResultWhenDataIsValidAccordingToSchema(): void
    {
        $json = Json::fromString(
            <<<'JSON'
{
    "name": "Jane Doe",
    "email": "jane.doe@example.org"
}
JSON
        );

        $schema = Schema::fromJson(Json::fromString(
            <<<'JSON'
{
    "type": "object",
    "properties": {
        "name": {
            "type": "string"
        },
        "email": {
            "type": "string"
        },
        "address": {
            "type": "string"
        },
        "telephone": {
            "type": "string"
        }
    },
    "required": [
        "name",
        "email"
    ],
    "additionalProperties": false
}
JSON
        ));

        $validator = new SchemaValidator(
            new Decoder(),
            new Validator(),
        );

        $result = $validator->validate(
            $json,
            $schema,
        );

        self::assertTrue($result->isValid());
        self::assertSame([], $result->errors());
    }

    public function testValidateClearsStateOfInternalValidator(): void
    {
        $invalidJson = Json::fromString(
            <<<'JSON'
{
    "number": 1600,
    "street_name": "Pennsylvania",
    "street_type": "Avenue",
    "direction": "NW"
}
JSON
        );

        $validJson = Json::fromString(
            <<<'JSON'
{
    "name": "Jane Doe",
    "email": "jane.doe@example.org"
}
JSON
        );

        $schema = Schema::fromJson(Json::fromString(
            <<<'JSON'
{
    "type": "object",
    "properties": {
        "name": {
            "type": "string"
        },
        "email": {
            "type": "string"
        },
        "address": {
            "type": "string"
        },
        "telephone": {
            "type": "string"
        }
    },
    "required": [
        "name",
        "email"
    ],
    "additionalProperties": false
}
JSON
        ));

        $validator = new SchemaValidator(
            new Decoder(),
            new Validator(),
        );

        $validator->validate(
            $invalidJson,
            $schema,
        );

        $secondResult = $validator->validate(
            $validJson,
            $schema,
        );

        self::assertTrue($secondResult->isValid());
        self::assertSame([], $secondResult->errors());
    }
}
