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

namespace Ergebnis\Json\SchemaValidator\Test\Unit\Exception;

use Ergebnis\Json\SchemaValidator\Exception;
use Ergebnis\Json\SchemaValidator\Test;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Exception\InvalidJson
 */
final class InvalidJsonTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testStringReturnsException(): void
    {
        $exception = Exception\InvalidJson::string();

        self::assertSame('Value does not appear to be a valid JSON string.', $exception->getMessage());
    }

    public function testFileReturnsException(): void
    {
        $name = __FILE__;

        $exception = Exception\InvalidJson::file($name);

        $expected = \sprintf(
            'File "%s" does not contain a valid JSON string.',
            $name,
        );

        self::assertSame($expected, $exception->getMessage());
    }
}
