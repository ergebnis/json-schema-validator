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

namespace Ergebnis\Json\SchemaValidator;

use JsonSchema\Validator;

final class SchemaValidator
{
    public function validate(
        Json $json,
        Json $schema
    ): Result {
        $validator = new Validator();

        $validator->reset();

        $jsonDecoded = \json_decode(
            $json->toString(),
            false,
        );

        $schemaDecoded = \json_decode(
            $schema->toString(),
            false,
        );

        $validator->validate(
            $jsonDecoded,
            $schemaDecoded,
        );

        /** @var array<int, array> $originalErrors */
        $originalErrors = $validator->getErrors();

        $errors = \array_map(static function (array $error): Error {
            return Error::create(
                JsonPointer::fromString($error['pointer']),
                Message::fromString($error['message']),
            );
        }, $originalErrors);

        return Result::create(...$errors);
    }
}
