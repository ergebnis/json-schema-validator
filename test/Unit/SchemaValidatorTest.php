<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-schema-validator
 */

namespace Ergebnis\Json\SchemaValidator\Test\Unit;

use Ergebnis\Json\Json;
use Ergebnis\Json\Pointer;
use Ergebnis\Json\SchemaValidator;
use PHPUnit\Framework;

/**
 * @covers \Ergebnis\Json\SchemaValidator\SchemaValidator
 *
 * @uses \Ergebnis\Json\SchemaValidator\Exception\CanNotResolve
 * @uses \Ergebnis\Json\SchemaValidator\Message
 * @uses \Ergebnis\Json\SchemaValidator\ValidationError
 * @uses \Ergebnis\Json\SchemaValidator\ValidationResult
 */
final class SchemaValidatorTest extends Framework\TestCase
{
    use SchemaValidator\Test\Util\Helper;

    public function testValidateReturnsResultWhenJsonIsValidAccordingToSchemaAndJsonPointerRefersToDocument(): void
    {
        $faker = self::faker();

        $data = Json::fromString(\json_encode([
            'foo' => [
                'bar' => $faker->boolean(),
                'baz' => $faker->words(),
            ],
        ]));

        $schema = Json::fromString(\json_encode([
            'additionalProperties' => false,
            'properties' => [
                'foo' => [
                    'additionalProperties' => false,
                    'properties' => [
                        'bar' => [
                            'type' => 'boolean',
                        ],
                        'baz' => [
                            'type' => 'array',
                        ],
                    ],
                    'required' => [
                        'bar',
                        'baz',
                    ],
                    'type' => 'object',
                ],
            ],
            'required' => [
                'foo',
            ],
            'type' => 'object',
        ]));

        $jsonPointer = Pointer\JsonPointer::document();

        $schemaValidator = new SchemaValidator\SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertTrue($result->isValid());
    }

    public function testValidateReturnsResultWhenJsonIsNotValidAccordingToSchemaAndJsonPointerRefersToDocument(): void
    {
        $faker = self::faker();

        $data = Json::fromString(\json_encode([
            'foo' => [
                'bar' => $faker->numberBetween(1),
                'baz' => $faker->sentence(),
            ],
            'qux' => $faker->sentence(),
        ]));

        $schema = Json::fromString(\json_encode([
            'additionalProperties' => false,
            'properties' => [
                'foo' => [
                    'additionalProperties' => false,
                    'properties' => [
                        'bar' => [
                            'type' => 'boolean',
                        ],
                        'baz' => [
                            'type' => 'array',
                        ],
                    ],
                    'required' => [
                        'bar',
                        'baz',
                    ],
                    'type' => 'object',
                ],
            ],
            'required' => [
                'foo',
            ],
            'type' => 'object',
        ]));

        $jsonPointer = Pointer\JsonPointer::document();

        $schemaValidator = new SchemaValidator\SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertFalse($result->isValid());

        $expected = [
            SchemaValidator\ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/foo/bar'),
                SchemaValidator\Message::fromString('Integer value found, but a boolean is required'),
            ),
            SchemaValidator\ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/foo/baz'),
                SchemaValidator\Message::fromString('String value found, but an array is required'),
            ),
            SchemaValidator\ValidationError::create(
                Pointer\JsonPointer::document(),
                SchemaValidator\Message::fromString('The property qux is not defined and the definition does not allow additional properties'),
            ),
        ];

        self::assertEquals($expected, $result->errors());
    }

    public function testValidateReturnsResultWhenJsonIsValidAccordingToSchemaAndJsonPointerDoesNotReferToDocument(): void
    {
        $faker = self::faker();

        $data = Json::fromString(\json_encode([
            'bar' => $faker->boolean(),
            'baz' => $faker->words(),
        ]));

        $schema = Json::fromString(\json_encode([
            'additionalProperties' => false,
            'properties' => [
                'foo' => [
                    'additionalProperties' => false,
                    'properties' => [
                        'bar' => [
                            'type' => 'boolean',
                        ],
                        'baz' => [
                            'type' => 'array',
                        ],
                    ],
                    'required' => [
                        'bar',
                        'baz',
                    ],
                    'type' => 'object',
                ],
            ],
            'required' => [
                'foo',
            ],
            'type' => 'object',
        ]));

        $jsonPointer = Pointer\JsonPointer::fromUriFragmentIdentifierString('#/properties/foo');

        $schemaValidator = new SchemaValidator\SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertTrue($result->isValid());
    }

    public function testValidateThrowsCanNotResolveWhenJsonPointerDoesNotReferToDocumentAndSubSchemaCouldNotBeResolved(): void
    {
        $faker = self::faker();

        $data = Json::fromString(\json_encode([
            'bar' => $faker->boolean(),
            'baz' => $faker->words(),
        ]));

        $schema = Json::fromString(\json_encode([
            'additionalProperties' => false,
            'properties' => [
                'foo' => [
                    'additionalProperties' => false,
                    'properties' => [
                        'bar' => [
                            'type' => 'boolean',
                        ],
                        'baz' => [
                            'type' => 'array',
                        ],
                    ],
                    'required' => [
                        'bar',
                        'baz',
                    ],
                    'type' => 'object',
                ],
            ],
            'required' => [
                'foo',
            ],
            'type' => 'object',
        ]));

        $jsonPointer = Pointer\JsonPointer::fromUriFragmentIdentifierString('#/properties/qux');

        $schemaValidator = new SchemaValidator\SchemaValidator();

        $this->expectException(SchemaValidator\Exception\CanNotResolve::class);

        $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );
    }

    public function testValidateReturnsResultWhenJsonIsNotValidAccordingToSchemaAndJsonPointerDoesNotReferToDocument(): void
    {
        $faker = self::faker();

        $data = Json::fromString(\json_encode([
            'bar' => $faker->sentence(),
            'baz' => $faker->boolean(),
        ]));

        $schema = Json::fromString(\json_encode([
            'additionalProperties' => false,
            'properties' => [
                'foo' => [
                    'additionalProperties' => false,
                    'properties' => [
                        'bar' => [
                            'type' => 'boolean',
                        ],
                        'baz' => [
                            'type' => 'array',
                        ],
                    ],
                    'required' => [
                        'bar',
                        'baz',
                    ],
                    'type' => 'object',
                ],
            ],
            'required' => [
                'foo',
            ],
            'type' => 'object',
        ]));

        $jsonPointer = Pointer\JsonPointer::fromUriFragmentIdentifierString('#/properties/foo');

        $schemaValidator = new SchemaValidator\SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertFalse($result->isValid());

        $expected = [
            SchemaValidator\ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/bar'),
                SchemaValidator\Message::fromString('String value found, but a boolean is required'),
            ),
            SchemaValidator\ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/baz'),
                SchemaValidator\Message::fromString('Boolean value found, but an array is required'),
            ),
        ];

        self::assertEquals($expected, $result->errors());
    }
}
