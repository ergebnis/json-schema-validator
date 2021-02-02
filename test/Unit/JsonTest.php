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
use Ergebnis\Test\Util;
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
    use Util\Helper;

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
     * @dataProvider provideValidJsonString
     */
    public function testFromStringReturnsJsonWhenValueIsValidJson(string $encoded): void
    {
        $json = Json::fromString($encoded);

        self::assertSame($encoded, $json->encoded());
    }

    /**
     * @return \Generator<string, array{0: string}>
     */
    public function provideValidJsonString(): \Generator
    {
        foreach (self::filesContainingValidJson() as $key => $value) {
            $content = \file_get_contents($value);

            if (!\is_string($content)) {
                throw new \RuntimeException(\sprintf(
                    'File "%s" does not exist or can not be read.',
                    $value
                ));
            }

            yield $key => [
                $content,
            ];
        }
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
     * @dataProvider provideValidJsonFile
     */
    public function testFromFileReturnsJsonWhenFileContainsValidJson(string $file): void
    {
        $json = Json::fromFile($file);

        self::assertStringEqualsFile($file, $json->encoded());
    }

    /**
     * @return \Generator<string, array{0: string}>
     */
    public function provideValidJsonFile(): \Generator
    {
        foreach (self::filesContainingValidJson() as $key => $value) {
            yield $key => [
                $value,
            ];
        }
    }

    /**
     * @return array<string, string>
     */
    private static function filesContainingValidJson(): array
    {
        return [
            'array' => __DIR__ . '/../Fixture/Json/valid/array.json',
            'bool-false' => __DIR__ . '/../Fixture/Json/valid/bool-false.json',
            'bool-true' => __DIR__ . '/../Fixture/Json/valid/bool-true.json',
            'float' => __DIR__ . '/../Fixture/Json/valid/float.json',
            'int' => __DIR__ . '/../Fixture/Json/valid/int.json',
            'object' => __DIR__ . '/../Fixture/Json/valid/object.json',
            'string-arbitrary' => __DIR__ . '/../Fixture/Json/valid/string-arbitrary.json',
            'string-empty' => __DIR__ . '/../Fixture/Json/valid/string-empty.json',
        ];
    }
}
