<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2022 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-schema-validator
 */

namespace Ergebnis\Json\SchemaValidator\Test\Unit;

use Ergebnis\Json\Pointer;
use Ergebnis\Json\SchemaValidator\Message;
use Ergebnis\Json\SchemaValidator\Test;
use Ergebnis\Json\SchemaValidator\ValidationError;
use Ergebnis\Json\SchemaValidator\ValidationResult;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\ValidationResult
 *
 * @uses \Ergebnis\Json\SchemaValidator\Message
 * @uses \Ergebnis\Json\SchemaValidator\ValidationError
 */
final class ValidationResultTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testCreateReturnsValidationResultWithoutErrors(): void
    {
        $validationResult = ValidationResult::create();

        self::assertTrue($validationResult->isValid());
        self::assertSame([], $validationResult->errors());
    }

    public function testCreateReturnsValidationResultWithErrors(): void
    {
        $faker = self::faker();

        $errors = [
            ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/foo'),
                Message::fromString($faker->sentence()),
            ),
            ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/bar'),
                Message::fromString($faker->sentence()),
            ),
            ValidationError::create(
                Pointer\JsonPointer::fromJsonString('/baz'),
                Message::fromString($faker->sentence()),
            ),
        ];

        $validationResult = ValidationResult::create(...$errors);

        self::assertFalse($validationResult->isValid());
        self::assertSame($errors, $validationResult->errors());
    }
}
