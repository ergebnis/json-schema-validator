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

/**
 * @psalm-immutable
 */
final class Result
{
    /**
     * @psalm-var list<Error>
     *
     * @var array<int, Error>
     */
    private array $errors;

    private function __construct(Error ...$errors)
    {
        $this->errors = $errors;
    }

    public static function create(Error ...$errors): self
    {
        return new self(...$errors);
    }

    public function isValid(): bool
    {
        return [] === $this->errors;
    }

    /**
     * @psalm-return list<Error>
     *
     * @return array<int, Error>
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
