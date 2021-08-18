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

use Ergebnis\Json\SchemaValidator\Decoder;
use Ergebnis\Json\SchemaValidator\Exception;
use Ergebnis\Test\Util;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Decoder
 *
 * @uses \Ergebnis\Json\SchemaValidator\Exception\InvalidJson
 */
final class DecoderTest extends Framework\TestCase
{
    use Util\Helper;

    public function testDecodeAssociativeThrowsExceptionWhenValueCanNotBeDecoded(): void
    {
        $value = <<<'TXT'
{
    "foo:
TXT;

        $decoder = new Decoder();

        $this->expectException(Exception\InvalidJson::class);

        $decoder->decodeAssociative($value);
    }

    /**
     * @dataProvider \Ergebnis\Json\SchemaValidator\Test\DataProvider\JsonProvider::validString()
     */
    public function testDecodeAssociativeReturnsJsonDecodedValue(string $encoded): void
    {
        $decoder = new Decoder();

        $decoded = $decoder->decodeAssociative($encoded);

        $expected = \json_decode(
            $encoded,
            true,
        );

        self::assertSame($expected, $decoded);
    }

    public function testDecodeNonAssociativeThrowsExceptionWhenValueCanNotBeDecoded(): void
    {
        $value = <<<'TXT'
{
    "foo:
TXT;

        $decoder = new Decoder();

        $this->expectException(Exception\InvalidJson::class);

        $decoder->decodeAssociative($value);
    }

    /**
     * @dataProvider \Ergebnis\Json\SchemaValidator\Test\DataProvider\JsonProvider::validString()
     */
    public function testDecodeNonAssociativeReturnsJsonDecodedValue(string $encoded): void
    {
        $decoder = new Decoder();

        $decoded = $decoder->decodeNonAssociative($encoded);

        $expected = \json_decode(
            $encoded,
            false,
        );

        self::assertEquals($expected, $decoded);
    }
}
