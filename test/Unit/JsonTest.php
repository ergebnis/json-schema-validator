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

use Ergebnis\Json\SchemaValidator\Exception;
use Ergebnis\Json\SchemaValidator\Json;
use Ergebnis\Json\SchemaValidator\Test;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Json
 *
 * @uses \Ergebnis\Json\SchemaValidator\Exception\DoesNotExist
 * @uses \Ergebnis\Json\SchemaValidator\Exception\InvalidJson
 */
final class JsonTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testFromStringThrowsWhenValueIsNotJson(): void
    {
        $encoded = <<<'TXT'
{
    "foo":
TXT;

        $this->expectException(Exception\InvalidJson::class);

        Json::fromString($encoded);
    }

    /**
     * @dataProvider \Ergebnis\Json\SchemaValidator\Test\DataProvider\JsonProvider::validString()
     */
    public function testFromStringReturnsJsonWhenValueIsValidJson(string $encoded): void
    {
        $json = Json::fromString($encoded);

        self::assertSame($encoded, $json->toString());
    }

    public function testFromFileThrowsWhenFileDoesNotExist(): void
    {
        $file = __DIR__ . '/../Fixture/Json/does-not-exist.json';

        $this->expectException(Exception\DoesNotExist::class);

        Json::fromFile($file);
    }

    public function testFromFileThrowsWhenFileIsADirectory(): void
    {
        $file = __DIR__ . '/../Fixture/Json';

        $this->expectException(Exception\DoesNotExist::class);

        Json::fromFile($file);
    }

    public function testFromFileThrowsWhenFileDoesNotContainValidJson(): void
    {
        $file = __DIR__ . '/../Fixture/Json/not-valid/object.json';

        $this->expectException(Exception\InvalidJson::class);

        Json::fromFile($file);
    }

    /**
     * @dataProvider \Ergebnis\Json\SchemaValidator\Test\DataProvider\JsonProvider::validFile()
     */
    public function testFromFileReturnsJsonWhenFileContainsValidJson(string $file): void
    {
        $json = Json::fromFile($file);

        self::assertStringEqualsFile($file, $json->toString());
    }
}
