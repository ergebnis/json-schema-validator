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
use Ergebnis\Json\SchemaValidator\Schema;
use PHPUnit\Framework;

/**
 * @internal
 *
 * @covers \Ergebnis\Json\SchemaValidator\Schema
 *
 * @uses \Ergebnis\Json\SchemaValidator\Exception\InvalidSchema
 * @uses \Ergebnis\Json\SchemaValidator\Json
 */
final class SchemaTest extends Framework\TestCase
{
    public function testFromJsonThrowsWhenValueDoesNotDecodeToObject(): void
    {
        $json = Json::fromString(
            <<<'TXT'
"foo"
TXT
        );

        $this->expectException(Exception\InvalidSchema::class);

        Schema::fromJson($json);
    }

    public function testFromJsonReturnsSchemaWhenValueDecodesToObject(): void
    {
        $json = Json::fromString(
            <<<'JSON'
{}
JSON
        );

        $schema = Schema::fromJson($json);

        $decoded = \json_decode($json->encoded());

        self::assertEquals($decoded, $schema->decoded());
    }
}
