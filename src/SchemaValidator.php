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

        $errors = \array_map(static function (array $error): string {
            $property = '';

            if (
                \array_key_exists('property', $error)
                && \is_string($error['property'])
                && '' !== \trim($error['property'])
            ) {
                $property = \trim($error['property']);
            }

            $message = '';

            if (
                \array_key_exists('message', $error)
                && \is_string($error['message'])
                && '' !== \trim($error['message'])
            ) {
                $message = \trim($error['message']);
            }

            if ('' === $property) {
                return $message;
            }

            return \sprintf(
                '%s: %s',
                $property,
                $message,
            );
        }, $originalErrors);

        $filtered = \array_filter($errors, static function (string $error): bool {
            return '' !== $error;
        });

        return Result::create(...$filtered);
    }
}
