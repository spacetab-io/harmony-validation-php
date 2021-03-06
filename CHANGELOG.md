# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

*None*

### Changed

*None*

### Deprecated

*None*

### Removed

*None*

### Fixed

*None*

### Security

*None*

## [1.1.1] - 2020-07-10

### Added

*None*

### Changed

* Update `amphp/parallel-functions` to newest version (`^1.0`) where symlink removed from package.

### Deprecated

*None*

### Removed

*None*

### Fixed

*None*

### Security

*None*

## [1.1.0] - 2020-04-16

### Added

*None*

### Changed

* Moved caching packages to dev section in composer. 
* Rewritten tests to use official `amphp/phpunit-util` package instead of `harmonyio/phpunit-extensions`.

### Deprecated

*None*

### Removed

* Removed `amphp/artax` composer package because is deprecated.
* Removed `harmonyio/phpunit-extensions` composer package.

### Fixed

* PHP 7.4 compatibility (in tests)

### Security

*None*

## [1.0.0-rc1] - 2019-01-01

### Added

- [[f754334](https://github.com/HarmonyIO/Validation/commit/f754334dc88a8d539c0a5ec4ac03e8a6118704a8)] Added .gitattributes

### Changed

- [[0edc948](https://github.com/HarmonyIO/Validation/commit/0edc948181248a5136921d56b35736d9e66284b6)] Updated PHP CodeSniffer
- [[7b7a017](https://github.com/HarmonyIO/Validation/commit/7b7a017d1fed573cd31e48085b1481e662584feb)] Added phpcs custom config to gitignore 
- [[4b50f08](https://github.com/HarmonyIO/Validation/commit/4b50f0822ac3173abc6c8f096273811356c403f6)] Cache HIBP results 1 hour instead of 1 day
- [[2840fa8](https://github.com/HarmonyIO/Validation/commit/2840fa8346b77fcc4ced830cccf02aed06ff2dc3)] Refactored http client calls to use Ttl objects for caching

### Deprecated

*None*

### Removed

*None*

### Fixed

*None*

### Security

*None*

## [0.4.0] - 2018-12-18

### Added

- [[96ddf46](https://github.com/HarmonyIO/Validation/commit/96ddf46ee6bccef0e7f0e47415ae0bc8bb48c373)] Changelog
- [[8d90eb1](https://github.com/HarmonyIO/Validation/commit/8d90eb1081efd53496d71e2734f3e9ab0e4a9f52)] Results and errors are objects now
- [[c0c622d](https://github.com/HarmonyIO/Validation/commit/c0c622d70c9fa26202c9248b3b0d4bf57b1558c4)] Numerical range validation rule
- [[f41be80](https://github.com/HarmonyIO/Validation/commit/f41be80862f1b7e69adb429f1cfa38028339b1c4)] Geolocation validation rule
- [[db09112](https://github.com/HarmonyIO/Validation/commit/db09112bf037b12c83167090e42fe525568862d7)] Text range validation rule
- [[d67ebdc](https://github.com/HarmonyIO/Validation/commit/d67ebdc1277c84e46a893394967e38f47a14365c)] Negative and positive validation rules
- [[d16c27a](https://github.com/HarmonyIO/Validation/commit/d16c27a99d0d8bfad34175737112ba64cb7cfab1)] TLD validation rule
- [[9b897aa](https://github.com/HarmonyIO/Validation/commit/9b897aa6dfc71aa9832394e7c21ff55e2a8e49de)] Alpha2-, alpha3 and numeric country code validation rules
- [[bbf5dde](https://github.com/HarmonyIO/Validation/commit/650a1498709a63209411179f4534495783344570)] Hexadecimal color validation rule
- [[7a355ac](https://github.com/HarmonyIO/Validation/commit/7a355ac642ad5136f9edf894a99debe7345cda62)] URL validation rules
- [[ad03f8d](https://github.com/HarmonyIO/Validation/commit/ad03f8d3d6ad5753bf51e696a84c43e71f820f20)] ISBN validation rules
- [[8f19a34](https://github.com/HarmonyIO/Validation/commit/8f19a34ae253e987b4e8e9e413d2099e35cb5ede)] Set and In validation rules
- [[5453522](https://github.com/HarmonyIO/Validation/commit/54535221576fe11d7715fb3244e8698b70a5e40b)] Regex validation rule

### Changed

- [[dd8856c](https://github.com/HarmonyIO/Validation/commit/dd8856cd84ba2686437684c5bfbed15e03c1ef41)] Updated egulias/email-validator
- [[3fae872](https://github.com/HarmonyIO/Validation/commit/3fae872109fa6d40306feadcd9a043a3a1512add)] Documented promise return values using generics syntax
- [[383c32f](https://github.com/HarmonyIO/Validation/commit/383c32fa1fe21bb1cfc5a96a97a729991e9235c4)] Added missing final class markers
- [[82dc9a0](https://github.com/HarmonyIO/Validation/commit/82dc9a007ca5d6a7fae4698dc9f941491a7eed48)] Updated amp to v2.1.1
- [[c8fa79d](https://github.com/HarmonyIO/Validation/commit/c8fa79dd22e963c29505467324e4e5d89148cbee)] Updated wikimedia/ip-set to v2.0.0

### Deprecated

### Removed

- [[4cf131e](https://github.com/HarmonyIO/Validation/commit/4cf131e408bc543393ae7a664d794ef9eeba0450)] Dropped PHP 7.2 support

### Fixed

- [[445dd9f](https://github.com/HarmonyIO/Validation/commit/445dd9ff1b6a85f433170e45d026d49e130d3386)] Appveyor builds are working again

### Security
