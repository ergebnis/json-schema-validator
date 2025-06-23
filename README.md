# json-schema-validator

[![Integrate](https://github.com/ergebnis/json-schema-validator/workflows/Integrate/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)
[![Merge](https://github.com/ergebnis/json-schema-validator/workflows/Merge/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)
[![Release](https://github.com/ergebnis/json-schema-validator/workflows/Release/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)
[![Renew](https://github.com/ergebnis/json-schema-validator/workflows/Renew/badge.svg)](https://github.com/ergebnis/json-schema-validator/actions)

[![Code Coverage](https://codecov.io/gh/ergebnis/json-schema-validator/branch/main/graph/badge.svg)](https://codecov.io/gh/ergebnis/json-schema-validator)

[![Latest Stable Version](https://poser.pugx.org/ergebnis/json-schema-validator/v/stable)](https://packagist.org/packages/ergebnis/json-schema-validator)
[![Total Downloads](https://poser.pugx.org/ergebnis/json-schema-validator/downloads)](https://packagist.org/packages/ergebnis/json-schema-validator)
[![Monthly Downloads](http://poser.pugx.org/ergebnis/json-schema-validator/d/monthly)](https://packagist.org/packages/ergebnis/json-schema-validator)

This project provides a [`composer`](https://getcomposer.org) package with a JSON schema validator, building on top of [`justinrainbow/json-schema`](https://github.com/justinrainbow/json-schema).

## Installation

Run

```sh
composer require ergebnis/json-schema-validator
```

## Usage

If you have used the validator from `justinrainbow/json-schema` before, you might have observed that it has a few flaws:

- The validator is stateful.
- The validator requires decoding JSON strings before validating them.
- The validator returns an `array` of errors, where each error is an `array`.

This package delegates the validation to `justinrainbow/json-schema` and provides a friendlier interface.

```php
<?php

declare(strict_types=1);

use Ergebnis\Json\Json;
use Ergebnis\Json\Pointer;
use Ergebnis\Json\SchemaValidator;

$json = Json::fromFile('composer.json');
$schema = Json::fromString(file_get_contents('https://getcomposer.org/schema.json'));
$jsonPointer = Pointer\JsonPointer::document();

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

The maintainers of this project record notable changes to this project in a [changelog](CHANGELOG.md).

## Contributing

The maintainers of this project suggest following the [contribution guide](.github/CONTRIBUTING.md).

## Code of Conduct

The maintainers of this project ask contributors to follow the [code of conduct](https://github.com/ergebnis/.github/blob/main/CODE_OF_CONDUCT.md).

## General Support Policy

The maintainers of this project provide limited support.

You can support the maintenance of this project by [sponsoring @ergebnis](https://github.com/sponsors/ergebnis).

## PHP Version Support Policy

This project supports PHP versions with [active and security support](https://www.php.net/supported-versions.php).

The maintainers of this project add support for a PHP version following its initial release and drop support for a PHP version when it has reached the end of security support.

## Security Policy

This project has a [security policy](.github/SECURITY.md).

## License

This project uses the [MIT license](LICENSE.md).

## Social

Follow [@localheinz](https://twitter.com/intent/follow?screen_name=localheinz) and [@ergebnis](https://twitter.com/intent/follow?screen_name=ergebnis) on Twitter.
