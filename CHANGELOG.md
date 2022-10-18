# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- add dependabot for GitHub Action dependency

### Changed
- disable deprecation notice PHPUnit
- update changelog form to follow keep-a-changelog format

### Removed
- remove satackey/action-docker-layer-caching on Github Actions
- remove trigger github actions on every pull-request, keep only push

### Fixed
- fixed docker test Javascript on CI
- fixed docker test Unit Database not ready

## [2.0.0-alpha1] - 2020-07-01
### Fixed
- Issue #2941631 - Doc is a bit misleading
- Issue #2996835 - Coding standard
- add travis integration
- add wengerk/docker-drupal-for-contrib
- ensure Drupal 9 readiness

## [1.2.0] - 2017-03-10
### Added
- added CCKEditor Filter to remove span

## [1.1.0] - 2017-03-08
### Added
- add ESLint for Javascript best practices

## [1.0.0] - 2017-03-08
### Added
- First draft.

[Unreleased]: https://github.com/antistatique/drupal-ckeditor-nbsp/compare/8.x-2.0-alpha1...HEAD
[2.0.0-alpha1]: https://github.com/antistatique/drupal-ckeditor-nbsp/compare/8.x-1.2...8.x-2.0-alpha1
[1.2.0]: https://github.com/antistatique/drupal-ckeditor-nbsp/compare/8.x-1.1...8.x-1.2
[1.1.0]: https://github.com/antistatique/drupal-ckeditor-nbsp/compare/8.x-1.0...8.x-1.1
[1.0.0]: https://github.com/antistatique/drupal-ckeditor-nbsp/releases/tag/8.x-1.0
