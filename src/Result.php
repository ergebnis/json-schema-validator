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

final class Result
{
    /**
     * @psalm-var list<string>
     *
     * @var array<int, string>
     */
    private array $errors;

    private function __construct(string ...$errors)
    {
        $this->errors = $errors;
    }

    public static function create(string ...$errors): self
    {
        return new self(...$errors);
    }

    public function isValid(): bool
    {
        return [] === $this->errors;
    }

    /**
     * @psalm-return list<string>
     *
     * @return array<int, string>
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
