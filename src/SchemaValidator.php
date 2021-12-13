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

use Ergebnis\Json\SchemaValidator\Exception\CanNotResolve;
use Ergebnis\Json\SchemaValidator\Exception\ResolvedToRootSchema;
use JsonSchema\Constraints;
use JsonSchema\Exception;
use JsonSchema\SchemaStorage;
use JsonSchema\Uri;
use JsonSchema\Validator;

final class SchemaValidator
{
    /**
     * @throws CanNotResolve
     * @throws ResolvedToRootSchema
     */
    public function validate(
        Json $json,
        Json $schema,
        JsonPointer $jsonPointer
    ): ValidationResult {
        $schemaDecoded = \json_decode(
            $schema->toString(),
            false,
        );

        $uriRetriever = new Uri\UriRetriever();

        if (!$jsonPointer->equals(JsonPointer::empty())) {
            try {
                $subSchemaDecoded = $uriRetriever->resolvePointer(
                    $schemaDecoded,
                    $jsonPointer->toString(),
                );
            } catch (Exception\ResourceNotFoundException $exception) {
                throw CanNotResolve::jsonPointer($jsonPointer);
            }

            if ($schemaDecoded === $subSchemaDecoded) {
                throw ResolvedToRootSchema::jsonPointer($jsonPointer);
            }

            $schemaDecoded = $subSchemaDecoded;
        }

        $schemaStorage = new SchemaStorage(
            $uriRetriever,
            new Uri\UriResolver(),
        );

        $validator = new Validator(new Constraints\Factory(
            $schemaStorage,
            $uriRetriever,
        ));

        $jsonDecoded = \json_decode(
            $json->toString(),
            false,
        );

        $validator->validate(
            $jsonDecoded,
            $schemaDecoded,
        );

        /** @var array<int, array> $originalErrors */
        $originalErrors = $validator->getErrors();

        $validationErrors = \array_map(static function (array $error): ValidationError {
            return ValidationError::create(
                JsonPointer::fromString($error['pointer']),
                Message::fromString($error['message']),
            );
        }, $originalErrors);

        return ValidationResult::create(...$validationErrors);
    }
}
