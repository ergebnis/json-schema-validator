<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-schema-validator
 */

namespace Ergebnis\Json\SchemaValidator\Test\Unit\Exception;

use Ergebnis\Json\SchemaValidator\Exception;
use PHPUnit\Framework;

#[Framework\Attributes\CoversClass(Exception\InvalidSchema::class)]
final class InvalidSchemaTest extends Framework\TestCase
{
    public function testNotAnOjectReturnsException(): void
    {
        $exception = Exception\InvalidSchema::notAnObject();

        self::assertSame('Value does not appear to be a valid JSON schema.', $exception->getMessage());
    }
}
