<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2023 Andreas Möller
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/ergebnis/json-schema-validator
 */

namespace Ergebnis\Json\SchemaValidator\Test\Unit;

use Ergebnis\DataProvider;
use Ergebnis\Json\SchemaValidator\Message;
use PHPUnit\Framework;

#[Framework\Attributes\CoversClass(Message::class)]
final class MessageTest extends Framework\TestCase
{
    #[Framework\Attributes\DataProviderExternal(DataProvider\StringProvider::class, 'arbitrary')]
    public function testFromStringReturnsMessage(string $value): void
    {
        $message = Message::fromString($value);

        self::assertSame($value, $message->toString());
    }
}
