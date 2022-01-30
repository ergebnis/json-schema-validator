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

namespace Ergebnis\Json\SchemaValidator\Test\Unit\Exception;

use Ergebnis\Json\Pointer;
use Ergebnis\Json\SchemaValidator\Exception;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Exception\CanNotResolve
 */
final class CanNotResolveTest extends Framework\TestCase
{
    public function testJsonPointerReturnsException(): void
    {
        $jsonPointer = Pointer\JsonPointer::fromUriFragmentIdentifierString('#/foo/bar');

        $exception = Exception\CanNotResolve::jsonPointer($jsonPointer);

        $expected = \sprintf(
            'Can not resolve JSON pointer "%s".',
            $jsonPointer->toJsonString(),
        );

        self::assertSame($expected, $exception->getMessage());
    }
}
