# Change Log

## [Unreleased][unreleased]

## [2.0.5] - 2015-09-18
### Added
- Added `pageUrl` method to `User` object
- Added `postOlderThan` and `postNewerThan` methods to `AbstractPost` object

### Fixed
- Fixed bug in `Request` class that tried loading post types other than `post`

## [2.0.4] - 2015-09-11
### Fixed
- Fixed typo in `limitChars` function

### Added
- Added `url` method to Term objects

### Changed
- Make AbstractPost::featuredImage return an Upload object

## [2.0.3] - 2015-09-09
### Changed
- Changed repository `newParams` method to public visibility

### Added
- Added User params builder

## [2.0.2] - 2015-09-08
### Added
- Added `limitWords` and `limitChars` helper functions

## [2.0.1] - 2015-09-04
### Fixed
- Fixed typo in Upload services file

## 2.0.0 - 2015-09-01
### Added
- Initial public release

[2.0.5]: https://github.com/emrl/fire/compare/2.0.4...2.0.5
[2.0.4]: https://github.com/emrl/fire/compare/2.0.3...2.0.4
[2.0.3]: https://github.com/emrl/fire/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/emrl/fire/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/emrl/fire/compare/2.0.0...2.0.1
