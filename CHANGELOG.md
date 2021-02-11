# Changelog

## [Unreleased][unreleased]

## [3.3.1] - 2021-02-11
- Fixed `Fire\Post\Type\Hooks::preGetPosts()` to handle multiple types

## [3.3.0] - 2021-01-26
### Added
- Added `Fire\Post\Type\generate_labels()`
- Added `Fire\Term\Taxonomy\generate_labels()`
- Added `Fire\Post\Type::object()`
- Added `Fire\Term\Taxonomy::object()`

### Changed
- `Fire\Term\Taxonomy::registerForType()` accepts variadic strings

### Deprecated
- Deprecated `Fire\Post\Type::config()` in favor of static `Fire\Post\Type::object()`
- Deprecated `Fire\Term\Taxonomy::config()` in favor of static `Fire\Term\Taxonomy::object()`

## [3.2.4] - 2020-10-07
### Changed
- Add check for existing file to `Fire\Path\JoinManifest`
- Bump priority and make it configurable in `Fire\Template\Layout`

## [3.2.3] - 2020-10-05
### Changed
- Changed `Fire\Template\Layout` `template_include` filter priority to `11`

## [3.2.2] - 2020-09-14
### Fixed
- Set `Fire\Term\Tag::TAXONOMY` to the correct value

## [3.2.1] - 2020-06-08
### Fixed
- Fixed return type error for `Fire\Path\JoinManifest::readManifest()`

## [3.2.0] - 2020-05-27
### Changed
- PHP 7.4 required, syntax updates
- `Fire\Core\parse_hosts()` accepts variadic strings

### Added
- Added `Fire\Post\Type::setOnFrontendQuery()`
- Added `Fire\Post\Type::setOnAdminQuery()`
- Added `Fire\Post\Type::modifyFrontendQuery()`
- Added `Fire\Post\Type::modifyAdminQuery()`

## [3.1.1] - 2020-05-07
### Changed
- Change `ResolveAs404` hook to wait until query has completed

## [3.1.0] - 2020-01-31
### Added
- Added functionality to complete use of `Fire\Post\Type::registerArchivePageSetting()`

## [3.0.1] - 2020-01-29
### Fixed
- Prevent endless loop in `Fire\Query\ResolveAs404`

## [3.0.0] - 2020-01-27
Complete rewrite  
[Changelog for previous versions](https://github.com/EMRL/fire/blob/2.3.1/CHANGELOG.md)

[unreleased]: https://github.com/emrl/fire/compare/3.3.1...master
[3.3.1]: https://github.com/emrl/fire/compare/3.3.0...3.3.1
[3.3.0]: https://github.com/emrl/fire/compare/3.2.4...3.3.0
[3.2.4]: https://github.com/emrl/fire/compare/3.2.3...3.2.4
[3.2.3]: https://github.com/emrl/fire/compare/3.2.2...3.2.3
[3.2.2]: https://github.com/emrl/fire/compare/3.2.1...3.2.2
[3.2.1]: https://github.com/emrl/fire/compare/3.2.0...3.2.1
[3.2.0]: https://github.com/emrl/fire/compare/3.1.1...3.2.0
[3.1.1]: https://github.com/emrl/fire/compare/3.1.0...3.1.1
[3.1.0]: https://github.com/emrl/fire/compare/3.0.1...3.1.0
[3.0.1]: https://github.com/emrl/fire/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/emrl/fire/compare/2.3.1...3.0.0
