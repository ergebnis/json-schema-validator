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

use Ergebnis\Json\SchemaValidator\Exception;
use Ergebnis\Json\SchemaValidator\Json;
use Ergebnis\Json\SchemaValidator\JsonPointer;
use Ergebnis\Json\SchemaValidator\Message;
use Ergebnis\Json\SchemaValidator\SchemaValidator;
use Ergebnis\Json\SchemaValidator\Test;
use Ergebnis\Json\SchemaValidator\ValidationError;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\SchemaValidator
 *
 * @uses \Ergebnis\Json\SchemaValidator\Exception\CanNotResolve
 * @uses \Ergebnis\Json\SchemaValidator\Exception\ResolvedToRootSchema
 * @uses \Ergebnis\Json\SchemaValidator\Json
 * @uses \Ergebnis\Json\SchemaValidator\JsonPointer
 * @uses \Ergebnis\Json\SchemaValidator\Message
 * @uses \Ergebnis\Json\SchemaValidator\ValidationError
 * @uses \Ergebnis\Json\SchemaValidator\ValidationResult
 */
final class SchemaValidatorTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testValidateReturnsResultWhenJsonIsValidAccordingToSchemaAndJsonPointerIsEmpty(): void
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

        $jsonPointer = JsonPointer::empty();

        $schemaValidator = new SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertTrue($result->isValid());
    }

    public function testValidateReturnsResultWhenJsonIsNotValidAccordingToSchemaAndJsonPointerIsEmpty(): void
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

        $jsonPointer = JsonPointer::empty();

        $schemaValidator = new SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertFalse($result->isValid());

        $expected = [
            ValidationError::create(
                JsonPointer::fromString('/foo/bar'),
                Message::fromString('Integer value found, but a boolean is required'),
            ),
            ValidationError::create(
                JsonPointer::fromString('/foo/baz'),
                Message::fromString('String value found, but an array is required'),
            ),
            ValidationError::create(
                JsonPointer::empty(),
                Message::fromString('The property qux is not defined and the definition does not allow additional properties'),
            ),
        ];

        self::assertEquals($expected, $result->errors());
    }

    public function testValidateReturnsResultWhenJsonIsValidAccordingToSchemaAndJsonPointerIsNotEmpty(): void
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

        $jsonPointer = JsonPointer::fromString('#/properties/foo');

        $schemaValidator = new SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertTrue($result->isValid());
    }

    public function testValidateThrowsCanNotResolveWhenJsonPointerIsNotEmptyAndSubSchemaCouldNotBeResolved(): void
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

        $jsonPointer = JsonPointer::fromString('#/properties/qux');

        $schemaValidator = new SchemaValidator();

        $this->expectException(Exception\CanNotResolve::class);

        $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );
    }

    public function testValidateThrowsResolvedToRootSchemaWhenJsonPointerIsNotEmptyAndSubSchemaWasResolvedToRootSchema(): void
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

        $jsonPointer = JsonPointer::fromString('/properties/qux');

        $schemaValidator = new SchemaValidator();

        $this->expectException(Exception\ResolvedToRootSchema::class);

        $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );
    }

    public function testValidateReturnsResultWhenJsonIsNotValidAccordingToSchemaAndJsonPathIsNotEmpty(): void
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

        $jsonPointer = JsonPointer::fromString('#/properties/foo');

        $schemaValidator = new SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertFalse($result->isValid());

        $expected = [
            ValidationError::create(
                JsonPointer::fromString('/bar'),
                Message::fromString('String value found, but a boolean is required'),
            ),
            ValidationError::create(
                JsonPointer::fromString('/baz'),
                Message::fromString('Boolean value found, but an array is required'),
            ),
        ];

        self::assertEquals($expected, $result->errors());
    }
}
