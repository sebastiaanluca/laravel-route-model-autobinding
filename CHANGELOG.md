# Changelog

All Notable changes to `sebastiaanluca/laravel-route-model-autobinding` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## Unreleased

## 2.0.1 (2019-03-01)

### Fixed

- Replaced global Laravel helpers with static variants

## 2.0.0 (2019-03-01)

### Added

- Added support for Laravel 5.8

### Removed

- Removed support for Laravel 5.7 and lower

## 1.1.0 (2018-09-04)

### Added

- Run tests against Laravel 5.7

## 1.0.1 (2018-08-06)

### Fixed

- Fixed service provider auto-discovery

## 1.0.0 (2018-08-06)

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
- Read root namespace directories instead of Models/
