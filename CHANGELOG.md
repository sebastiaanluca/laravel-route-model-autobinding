# Changelog

All Notable changes to `sebastiaanluca/laravel-route-model-autobinding` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## Unreleased

### Added

- Added automatic route model binding
- Added cache command
- Added clear cache command

### Fixed

- Ignore traits
- Ignore interfaces
- Ignore non-Eloquent classes
- Ignore abstract classes
- Ignore plain PHP files
- Include models that inherit Eloquent model higher up the chain
