<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2023 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-schema-validator
 */

namespace Ergebnis\Json\SchemaValidator\Test\Unit;

use Ergebnis\Json\Json;
use Ergebnis\Json\Pointer;
use Ergebnis\Json\SchemaValidator\Exception;
use Ergebnis\Json\SchemaValidator\Message;
use Ergebnis\Json\SchemaValidator\SchemaValidator;
use Ergebnis\Json\SchemaValidator\Test;
use Ergebnis\Json\SchemaValidator\ValidationError;
use Ergebnis\Json\SchemaValidator\ValidationResult;
use PHPUnit\Framework;

#[Framework\Attributes\CoversClass(SchemaValidator::class)]
#[Framework\Attributes\UsesClass(Exception\CanNotResolve::class)]
#[Framework\Attributes\UsesClass(Message::class)]
#[Framework\Attributes\UsesClass(ValidationError::class)]
#[Framework\Attributes\UsesClass(ValidationResult::class)]
final class SchemaValidatorTest extends Framework\TestCase
{
    use Test\Util\Helper;

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

        $schemaValidator = new SchemaValidator();

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

        $schemaValidator = new SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertFalse($result->isValid());

        $expected = [
            ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/foo/bar'),
                Message::fromString('Integer value found, but a boolean is required'),
            ),
            ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/foo/baz'),
                Message::fromString('String value found, but an array is required'),
            ),
            ValidationError::create(
                Pointer\JsonPointer::document(),
                Message::fromString('The property qux is not defined and the definition does not allow additional properties'),
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

        $schemaValidator = new SchemaValidator();

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

        $schemaValidator = new SchemaValidator();

        $this->expectException(Exception\CanNotResolve::class);

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

        $schemaValidator = new SchemaValidator();

        $result = $schemaValidator->validate(
            $data,
            $schema,
            $jsonPointer,
        );

        self::assertFalse($result->isValid());

        $expected = [
            ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/bar'),
                Message::fromString('String value found, but a boolean is required'),
            ),
            ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/baz'),
                Message::fromString('Boolean value found, but an array is required'),
            ),
        ];

        self::assertEquals($expected, $result->errors());
    }
}
