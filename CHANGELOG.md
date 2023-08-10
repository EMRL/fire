# Changelog

## [Unreleased][unreleased]

## [4.0.2] - 2023-08-10
### Added
- Added `item_trashed` to `\Fire\Post\Type\generate_labels()` for WordPress 6.3

### Changed
- Update dependencies

## [4.0.1] - 2023-02-08
### Fixed
- Added `.gitattributes` file to ignore test and configuration files on export

## [4.0.0] - 2022-04-15
### Breaking changes
- Updated minimum PHP version to 8.1

## [3.4.1] - 2021-07-06
### Fixed
- Fixed priority of `Fire\Post\Type::addSupport()` to be before type is registered
  This fixes issue with the post type archive setting post type support

## [3.4.0] - 2021-07-01
### Added
- Added `Fire\Post\Type::addSupport()`
- Added `Fire\Post\Type::removeSupport()`
- Added `$main` argument to `Fire\Post\Type::modifyQuery()`
- Added `$main` argument to `Fire\Post\Type::modifyFrontendQuery()`
- Added `$main` argument to `Fire\Post\Type::setOnQuery()`
- Added `$main` argument to `Fire\Post\Type::setOnFrontendQuery()`
- Added `Fire\Core\array_smart_merge()`

### Fixed
- Fixed `Fire\Post\page_id_for_type()` to better handle default `post` type

### Changed
- Changed `Fire\Post\Type` and `Fire\Term\Taxonomy` to use `filter_merge` instead of `filter_replace`

## [3.3.5] - 2021-04-15
- Fixed `Fire\Post\page_id_for_type()` to get correct type even if no posts exist

## [3.3.4] - 2021-04-08
- Fixed `Fire\Post\page_for_type()` to work with native Blog page
- Improved label generation for Post Types and Taxonomies

## [3.3.3] - 2021-02-18
- Fixed `Fire\Template\Layout` to only buffer template if one has been set for plugin compatability

## [3.3.2] - 2021-02-12
- Fixed `Fire\Template\Layout` to allow for templates outside of theme for plugin compatibility

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

[unreleased]: https://github.com/emrl/fire/compare/4.0.2...master
[4.0.2]: https://github.com/emrl/fire/compare/4.0.1...4.0.2
[4.0.1]: https://github.com/emrl/fire/compare/4.0.0...4.0.1
[4.0.0]: https://github.com/emrl/fire/compare/3.4.1...4.0.0
[3.4.1]: https://github.com/emrl/fire/compare/3.4.0...3.4.1
[3.4.0]: https://github.com/emrl/fire/compare/3.3.5...3.4.0
[3.3.5]: https://github.com/emrl/fire/compare/3.3.4...3.3.5
[3.3.4]: https://github.com/emrl/fire/compare/3.3.3...3.3.4
[3.3.3]: https://github.com/emrl/fire/compare/3.3.2...3.3.3
[3.3.2]: https://github.com/emrl/fire/compare/3.3.1...3.3.2
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
