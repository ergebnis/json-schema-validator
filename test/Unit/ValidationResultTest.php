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

use Ergebnis\Json\Pointer;
use Ergebnis\Json\SchemaValidator;
use PHPUnit\Framework;

/**
 * @covers \Ergebnis\Json\SchemaValidator\ValidationResult
 *
 * @uses \Ergebnis\Json\SchemaValidator\Message
 * @uses \Ergebnis\Json\SchemaValidator\ValidationError
 */
final class ValidationResultTest extends Framework\TestCase
{
    use SchemaValidator\Test\Util\Helper;

    public function testCreateReturnsValidationResultWithoutErrors(): void
    {
        $validationResult = SchemaValidator\ValidationResult::create();

        self::assertTrue($validationResult->isValid());
        self::assertSame([], $validationResult->errors());
    }

    public function testCreateReturnsValidationResultWithErrors(): void
    {
        $faker = self::faker();

        $errors = [
            SchemaValidator\ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/foo'),
                SchemaValidator\Message::fromString($faker->sentence()),
            ),
            SchemaValidator\ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/bar'),
                SchemaValidator\Message::fromString($faker->sentence()),
            ),
            SchemaValidator\ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/baz'),
                SchemaValidator\Message::fromString($faker->sentence()),
            ),
        ];

        $validationResult = SchemaValidator\ValidationResult::create(...$errors);

        self::assertFalse($validationResult->isValid());
        self::assertSame($errors, $validationResult->errors());
    }
}
