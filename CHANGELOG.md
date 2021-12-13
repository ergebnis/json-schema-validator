# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

For a full diff see [`2.0.0...main`][2.0.0...main].

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

[dcd4cfb...1.0.0]: https://github.com/ergebnis/json-schema-validator/compare/dcd4cfb...1.0.0
[1.0.0...2.0.0]: https://github.com/ergebnis/json-schema-validator/compare/1.0.0...2.0.0
[2.0.0...main]: https://github.com/ergebnis/json-schema-validator/compare/2.0.0...main

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

[@localheinz]: https://github.com/localheinz
