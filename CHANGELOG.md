# Change Log

## [Unreleased][unreleased]

## [2.3.1] - 2018-09-19
### Changed
- `Asset::url` returns root-relative path if file does not exist
- `AbstractPost::summary` handles Relevanssi better

## [2.3.0] - 2018-08-23
### Added
- Added `AbstractPostType::modifyPostUrl`
- Added `AbstractPostType::modifyArchiveTitle`
- Added manifest.json support for assets

### Fixed
- Whitespace and comments, general syntax improvements

## [2.2.0] - 2018-05-25
### Added
- Added `count` method to `Term` model
- Added `url` method to `Comment` model
- Added `srcset` method to `Upload` model
- Added `implode` method to `Collection` object
- Added `hasChildren` method to `AbstractPost` model
- Added `AbstractPostType::modifyQuery` to modify query for post types

### Changed
- Bound `AbstractPostEntityMapper` to container to ease process of creating new
  post types and to reuse the same instance across all post types
- `AbstractPost::content` uses simpler method to get the content

### Fixed
- RSS feeds now use absolute URLs instead of relative
- Fixed incorrect variable name in `menuAtLocation` and `menuItemsAtLocation`
  functions.
- Fixed bug when replacing absolute URLs inside of serialized data
- Layout functionality is now optional
- Upload `srcset` method now correctly passes size value to WP function
- `Asset::url` fix for Windows path separator issue
- Typo in `Collection::jsonSerialize` method name
- `Asset::url` works when `WP_CONTENT_URL` uses a full URL

## [2.1.1] - 2015-10-27
### Fixed
- Fixing a backwards incompatible change introduced in 2.1.0 where
  `AbstractPostEntityMapper` required an instance of
  `CommentRepositoryContract`; that is now optional and backward compatible

## [2.1.0] - 2015-10-27
### Added
- Added check in `Admin\RelativeUrls` class to check for existence of server
  variable adding actions
- Added `Comment` model and repository
- Added more relationships to models

### Fixed
- Fixed bug in TermTaxonomy where default labels weren't being set correctly.
- Fixed some typos and weird formatting

### Changed
- Repository default params are now replaced with passed params instead of
  merged.

## [2.0.6] - 2015-09-21
### Added
- When passing an array to repository `find` method it will now include default
  arguments that were specified by the `newParams` method

### Changed
- `AbstractPost::excerpt` method uses `$this->content` property instead of
  method because the `the_content` filter is so slow. Not sure how to fix?

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

[2.3.0]: https://github.com/emrl/fire/compare/2.2.0...2.3.0
[2.2.0]: https://github.com/emrl/fire/compare/2.1.1...2.2.0
[2.1.1]: https://github.com/emrl/fire/compare/2.1.0...2.1.1
[2.1.0]: https://github.com/emrl/fire/compare/2.0.6...2.1.0
[2.0.6]: https://github.com/emrl/fire/compare/2.0.5...2.0.6
[2.0.5]: https://github.com/emrl/fire/compare/2.0.4...2.0.5
[2.0.4]: https://github.com/emrl/fire/compare/2.0.3...2.0.4
[2.0.3]: https://github.com/emrl/fire/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/emrl/fire/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/emrl/fire/compare/2.0.0...2.0.1
