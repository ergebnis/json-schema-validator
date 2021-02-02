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

use Ergebnis\Json\SchemaValidator\Result;
use Ergebnis\Test\Util;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Result
 */
final class ResultTest extends Framework\TestCase
{
    use Util\Helper;

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
            $faker->sentence,
            $faker->sentence,
            $faker->sentence,
        ];

        $result = Result::create(...$errors);

        self::assertFalse($result->isValid());
        self::assertSame($errors, $result->errors());
    }
}
