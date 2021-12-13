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

use Ergebnis\Json\SchemaValidator\JsonPointer;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\JsonPointer
 */
final class JsonPointerTest extends Framework\TestCase
{
    public function testFromStringReturnsJsonPointer(): void
    {
        $value = '#/foo/bar';

        $jsonPointer = JsonPointer::fromString($value);

        self::assertSame($value, $jsonPointer->toString());
    }

    public function testEmptyReturnsJsonPointer(): void
    {
        $jsonPointer = JsonPointer::empty();

        self::assertSame('', $jsonPointer->toString());
    }

    public function testEqualsReturnsFalseWhenValueIsDifferent(): void
    {
        $one = JsonPointer::fromString('#/foo/bar');
        $two = JsonPointer::fromString('#/foo/baz');

        self::assertFalse($one->equals($two));
    }

    public function testEqualsReturnsTrueWhenValueIsSame(): void
    {
        $value = '#/foo/bar';

        $one = JsonPointer::fromString($value);
        $two = JsonPointer::fromString($value);

        self::assertTrue($one->equals($two));
    }
}
