# json-schema-validator

[![Integrate](https://github.com/ergebnis/json-schema-validator/workflows/Integrate/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)
[![Merge](https://github.com/ergebnis/json-schema-validator/workflows/Merge/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)
[![Prune](https://github.com/ergebnis/json-schema-validator/workflows/Prune/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)
[![Release](https://github.com/ergebnis/json-schema-validator/workflows/Release/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)
[![Renew](https://github.com/ergebnis/json-schema-validator/workflows/Renew/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)

[![Code Coverage](https://codecov.io/gh/ergebnis/json-schema-validator/branch/main/graph/badge.svg)](https://codecov.io/gh/ergebnis/json-schema-validator)
[![Type Coverage](https://shepherd.dev/github/ergebnis/json-schema-validator/coverage.svg)](https://shepherd.dev/github/ergebnis/json-schema-validator)

[![Latest Stable Version](https://poser.pugx.org/ergebnis/json-schema-validator/v/stable)](https://packagist.org/packages/ergebnis/json-schema-validator)
[![Total Downloads](https://poser.pugx.org/ergebnis/json-schema-validator/downloads)](https://packagist.org/packages/ergebnis/json-schema-validator)

Provides a JSON schema validator, building on top of [`justinrainbow/json-schema`](https://github.com/justinrainbow/json-schema).

## Installation

Run

```sh
$ composer require ergebnis/json-schema-validator
```

## Usage

If you have used the validator from `justinrainbow/json-schema` before, you might have observed that it has a few flaws:

- The validator is stateful.
- The validator requires decoding JSON strings before validating them.
- The validator returns an `array` of errors, where each error is an `array`.

This package delegates the validation to `justinrainbow/json-schema` and provides a friendlier interface.

```php
<?php

use Ergebnis\Json\SchemaValidator;

$json = SchemaValidator\Json::fromFile('composer.json');
$schema = SchemaValidator\Json::fromString(file_get_contents('https://getcomposer.org/schema.json'));
$jsonPointer = SchemaValidator\JsonPointer::empty();

$schemaValidator = new SchemaValidator\SchemaValidator();

$result = $schemaValidator->validate(
    $json,
    $schema,
    $jsonPointer
);

var_dump($result->isValid()); // bool
var_dump($result->errors());  // flat list of `ValidationError` value objects
```

## Changelog

Please have a look at [`CHANGELOG.md`](CHANGELOG.md).

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CODE_OF_CONDUCT.md`](https://github.com/ergebnis/.github/blob/main/CODE_OF_CONDUCT.md).

## License

This package is licensed using the MIT License.

Please have a look at [`LICENSE.md`](LICENSE.md).

## Curious what I am building?

:mailbox_with_mail: [Subscribe to my list](https://localheinz.com/projects/), and I will occasionally send you an email to let you know what I am working on.
