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
use Ergebnis\Json\SchemaValidator\Test;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Error
 *
 * @uses \Ergebnis\Json\SchemaValidator\JsonPointer
 * @uses \Ergebnis\Json\SchemaValidator\Message
 */
final class ErrorTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testCreateReturnsError(): void
    {
        $jsonPointer = JsonPointer::fromString('#/foo/bar');
        $message = Message::fromString(self::faker()->sentence());

        $error = Error::create(
            $jsonPointer,
            $message,
        );

        self::assertSame($jsonPointer, $error->jsonPointer());
        self::assertSame($message, $error->message());
    }
}
