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

namespace Ergebnis\Json\SchemaValidator\Test\DataProvider;

use Ergebnis\DataProvider;

final class JsonProvider extends DataProvider\AbstractProvider
{
    /**
     * @return \Generator<string, array{0: string}>
     */
    public static function validString(): \Generator
    {
        yield from self::provideDataForValues(\array_map(static function (string $file): string {
            $contents
                = \file_get_contents($file);

            if (!\is_string($contents)) {
                throw new \RuntimeException(\sprintf(
                    'File "%s" does not exist or can not be read.',
                    $file,
                ));
            }

            return $contents;
        }, self::filesContainingValidJson()));
    }

    /**
     * @return \Generator<string, array{0: string}>
     */
    public function validFile(): \Generator
    {
        yield from self::provideDataForValues(self::filesContainingValidJson());
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
