# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

For a full diff see [`4.5.1...main`][4.5.1...main].

## [`4.5.1`][4.5.1]

For a full diff see [`4.5.0...4.5.1`][4.5.0...4.5.1].

### Fixed

- Updated branch alias ([#661]), by [@localheinz]

## [`4.5.0`][4.5.0]

For a full diff see [`4.4.0...4.5.0`][4.4.0...4.5.0].

### Changed

- Allowed installation on PHP 8.5 ([#656]), by [@localheinz]

## [`4.4.0`][4.4.0]

For a full diff see [`4.3.0...4.4.0`][4.3.0...4.4.0].

### Added

- Added support for PHP 8.4 ([#633]), by [@localheinz]

### Changed

- Allowed installation of `justinrainbow/json-schema:^6.0.0` ([#632]), by [@localheinz]

## [`4.3.0`][4.3.0]

For a full diff see [`4.2.0...4.3.0`][4.2.0...4.3.0].

### Changed

- Allowed installation on PHP 8.4 ([#610]), by [@localheinz]

## [`4.2.0`][4.2.0]

For a full diff see [`4.1.0...4.2.0`][4.1.0...4.2.0].

### Changed

- Added support for PHP 8.0 ([#521]), by [@localheinz]
- Required `ergebnis/json:^1.2.0` ([#522]), by [@localheinz]
- Required `ergebnis/json-pointer:^3.4.0` ([#523]), by [@localheinz]
- Added support for PHP 7.4 ([#524]), by [@localheinz]

## [`4.1.0`][4.1.0]

For a full diff see [`4.0.0...4.1.0`][4.0.0...4.1.0].

### Changed

- Dropped support for PHP 8.0 ([#388]), by [@localheinz]
- Added support for PHP 8.3 ([#450]), by [@localheinz]

## [`4.0.0`][4.0.0]

For a full diff see [`3.2.0...4.0.0`][3.2.0...4.0.0].

### Removed

- Started using `ergebnis/json` and removed `Json`, `Exception\CanNotBeRead`, `Exception\DoesNotExist`, and `Exception\InvalidJson` ([#292]), by [@localheinz]

## [`3.2.0`][3.2.0]

For a full diff see [`3.1.0...3.2.0`][3.1.0...3.2.0].

### Changed

- Dropped support for PHP 7.4 ([#282]), by [@localheinz]

## [`3.1.0`][3.1.0]

For a full diff see [`3.0.0...3.1.0`][3.0.0...3.1.0].

### Changed

- Required `ergebnis/json-pointer:^3.0.0` ([#226]), by [@dependabot]

## [`3.0.0`][3.0.0]

For a full diff see [`2.0.0...3.0.0`][2.0.0...3.0.0].

### Changed

- Required [`ergebnis/json-pointer`](https://github.com/ergebnis/json-pointer) ([#195]), by [@localheinz]
- Started throwing an `Exception\CanNotResolve` exception instead of an `Exception\ResolvedToRootSchema` when the `JsonPointer` is not a valid URI fragment identifier representation of a JSON pointer ([#202]), by [@localheinz]
- Started using `Ergebnis\Json\Pointer\JsonPointer` instead of `Ergebnis\Json\SchemaValidator\JsonPointer` ([#200]), by [@localheinz]

### Removed

- Removed `Exception\ResolvedToRootSchema` ([#203]), by [@localheinz]

## [`2.0.0`][2.0.0]

For a full diff see [`1.0.0...2.0.0`][1.0.0...2.0.0].

### Added

- Implemented `JsonPointer` ([#163]), by [@localheinz]
- Implemented `Message` ([#164]), by [@localheinz]
- Implemented `Error` ([#165]), by [@localheinz]

### Changed

- Dropped support for PHP 7.3 ([#137]), by [@localheinz]
- Renamed `Json::encoded()` to `Json::toString()` ([#155]), by [@localheinz]
- Inlined `Decoder` into `SchemaValidator` ([#157]), by [@localheinz]
- Disallowed injection of `Validator` into `SchemaValidator` ([#158]), by [@localheinz]
- Removed `Schema` ([#161]), by [@localheinz]
- Composed `Error` into `Result` ([#166]), by [@localheinz]
- Required `JsonPointer` to allow specifying sub-schemas ([#167]), by [@localheinz]
- Renamed `Error` to `ValidationError` ([#169]), by [@localheinz]
- Renamed `Result` to `ValidationResult` ([#172]), by [@localheinz]

## [`1.0.0`][1.0.0]

For a full diff see [`dcd4cfb...1.0.0`][dcd4cfb...1.0.0].

### Added

- Added `Json` ([#2]), by [@localheinz]
- Added `Schema` ([#3]), by [@localheinz]
- Added `Decoder` ([#5]), by [@localheinz]
- Added `Result` ([#6]), by [@localheinz]
- Added `SchemaValidator` ([#8]), by [@localheinz]

[1.0.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/1.0.0
[2.0.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/2.0.0
[3.0.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/3.0.0
[3.1.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/3.1.0
[3.2.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/3.2.0
[4.0.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/4.0.0
[4.1.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/4.1.0
[4.2.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/4.2.0
[4.3.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/4.3.0
[4.4.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/4.4.0
[4.5.0]: https://github.com/ergebnis/json-schema-validator/releases/tag/4.5.0
[4.5.1]: https://github.com/ergebnis/json-schema-validator/releases/tag/4.5.1

[dcd4cfb...1.0.0]: https://github.com/ergebnis/json-schema-validator/compare/dcd4cfb...1.0.0
[1.0.0...2.0.0]: https://github.com/ergebnis/json-schema-validator/compare/1.0.0...2.0.0
[2.0.0...3.0.0]: https://github.com/ergebnis/json-schema-validator/compare/2.0.0...3.0.0
[3.0.0...3.1.0]: https://github.com/ergebnis/json-schema-validator/compare/3.0.0...3.1.0
[3.1.0...3.2.0]: https://github.com/ergebnis/json-schema-validator/compare/3.1.0...3.2.0
[3.2.0...4.0.0]: https://github.com/ergebnis/json-schema-validator/compare/3.2.0...4.0.0
[4.0.0...4.1.0]: https://github.com/ergebnis/json-schema-validator/compare/4.0.0...4.1.0
[4.1.0...4.2.0]: https://github.com/ergebnis/json-schema-validator/compare/4.1.0...4.2.0
[4.2.0...4.3.0]: https://github.com/ergebnis/json-schema-validator/compare/4.2.0...4.3.0
[4.3.0...4.4.0]: https://github.com/ergebnis/json-schema-validator/compare/4.3.0...4.4.0
[4.4.0...4.5.0]: https://github.com/ergebnis/json-schema-validator/compare/4.4.0...4.5.0
[4.5.0...4.5.1]: https://github.com/ergebnis/json-schema-validator/compare/4.5.0...4.5.1
[4.5.1...main]: https://github.com/ergebnis/json-schema-validator/compare/4.5.1...main

[#2]: https://github.com/ergebnis/json-schema-validator/pull/2
[#3]: https://github.com/ergebnis/json-schema-validator/pull/3
[#5]: https://github.com/ergebnis/json-schema-validator/pull/5
[#6]: https://github.com/ergebnis/json-schema-validator/pull/6
[#8]: https://github.com/ergebnis/json-schema-validator/pull/8
[#137]: https://github.com/ergebnis/json-schema-validator/pull/137
[#155]: https://github.com/ergebnis/json-schema-validator/pull/155
[#157]: https://github.com/ergebnis/json-schema-validator/pull/157
[#158]: https://github.com/ergebnis/json-schema-validator/pull/158
[#161]: https://github.com/ergebnis/json-schema-validator/pull/161
[#163]: https://github.com/ergebnis/json-schema-validator/pull/163
[#164]: https://github.com/ergebnis/json-schema-validator/pull/164
[#165]: https://github.com/ergebnis/json-schema-validator/pull/165
[#166]: https://github.com/ergebnis/json-schema-validator/pull/166
[#167]: https://github.com/ergebnis/json-schema-validator/pull/167
[#169]: https://github.com/ergebnis/json-schema-validator/pull/169
[#172]: https://github.com/ergebnis/json-schema-validator/pull/172
[#195]: https://github.com/ergebnis/json-schema-validator/pull/195
[#200]: https://github.com/ergebnis/json-schema-validator/pull/200
[#202]: https://github.com/ergebnis/json-schema-validator/pull/202
[#203]: https://github.com/ergebnis/json-schema-validator/pull/203
[#226]: https://github.com/ergebnis/json-schema-validator/pull/226
[#282]: https://github.com/ergebnis/json-schema-validator/pull/282
[#388]: https://github.com/ergebnis/json-schema-validator/pull/388
[#450]: https://github.com/ergebnis/json-schema-validator/pull/450
[#521]: https://github.com/ergebnis/json-schema-validator/pull/521
[#522]: https://github.com/ergebnis/json-schema-validator/pull/522
[#523]: https://github.com/ergebnis/json-schema-validator/pull/523
[#524]: https://github.com/ergebnis/json-schema-validator/pull/524
[#610]: https://github.com/ergebnis/json-schema-validator/pull/610
[#632]: https://github.com/ergebnis/json-schema-validator/pull/632
[#633]: https://github.com/ergebnis/json-schema-validator/pull/633
[#656]: https://github.com/ergebnis/json-schema-validator/pull/656
[#661]: https://github.com/ergebnis/json-schema-validator/pull/661

[@localheinz]: https://github.com/localheinz
