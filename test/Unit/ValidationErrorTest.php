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
 * @covers \Ergebnis\Json\SchemaValidator\ValidationError
 *
 * @uses \Ergebnis\Json\SchemaValidator\Message
 */
final class ValidationErrorTest extends Framework\TestCase
{
    use SchemaValidator\Test\Util\Helper;

    public function testCreateReturnsValidationError(): void
    {
        $jsonPointer = Pointer\JsonPointer::fromUriFragmentIdentifierString('#/foo/bar');
        $message = SchemaValidator\Message::fromString(self::faker()->sentence());

        $validationError = SchemaValidator\ValidationError::create(
            $jsonPointer,
            $message,
        );

        self::assertSame($jsonPointer, $validationError->jsonPointer());
        self::assertSame($message, $validationError->message());
    }
}
