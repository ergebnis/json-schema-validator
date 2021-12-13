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

use Ergebnis\Json\SchemaValidator\Error;
use Ergebnis\Json\SchemaValidator\JsonPointer;
use Ergebnis\Json\SchemaValidator\Message;
use Ergebnis\Json\SchemaValidator\Result;
use Ergebnis\Json\SchemaValidator\Test;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Result
 *
 * @uses \Ergebnis\Json\SchemaValidator\Error
 * @uses \Ergebnis\Json\SchemaValidator\JsonPointer
 * @uses \Ergebnis\Json\SchemaValidator\Message
 */
final class ResultTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testCreateReturnsResultWithoutErrors(): void
    {
        $result = Result::create();

        self::assertTrue($result->isValid());
        self::assertSame([], $result->errors());
    }

    public function testCreateReturnsResultWithErrors(): void
    {
        $faker = self::faker();

        $errors = [
            Error::create(
                JsonPointer::fromString('/foo'),
                Message::fromString($faker->sentence()),
            ),
            Error::create(
                JsonPointer::fromString('/bar'),
                Message::fromString($faker->sentence()),
            ),
            Error::create(
                JsonPointer::fromString('/baz'),
                Message::fromString($faker->sentence()),
            ),
        ];

        $result = Result::create(...$errors);

        self::assertFalse($result->isValid());
        self::assertSame($errors, $result->errors());
    }
}
