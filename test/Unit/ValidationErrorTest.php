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
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\ValidationError
 *
 * @uses \Ergebnis\Json\SchemaValidator\Message
 */
final class ValidationErrorTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testCreateReturnsValidationError(): void
    {
        $jsonPointer = Pointer\JsonPointer::fromUriFragmentIdentifierString('#/foo/bar');
        $message = Message::fromString(self::faker()->sentence());

        $validationError = ValidationError::create(
            $jsonPointer,
            $message,
        );

        self::assertSame($jsonPointer, $validationError->jsonPointer());
        self::assertSame($message, $validationError->message());
    }
}
