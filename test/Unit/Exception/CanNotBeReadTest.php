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
use Ergebnis\Test\Util;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Exception\CanNotBeRead
 */
final class CanNotBeReadTest extends Framework\TestCase
{
    use Util\Helper;

    public function testFileReturnsException(): void
    {
        $name = __FILE__;

        $exception = Exception\CanNotBeRead::file($name);

        $expected = \sprintf(
            'File "%s" can not be read.',
            $name,
        );

        self::assertSame($expected, $exception->getMessage());
    }
}
