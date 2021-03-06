# CHANGELOG

Gubug adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html) and all notable changes will be documented in this file.

**Tags**: Added, Changed, Deprecated, Removed, Fixed, Security  

---

## [NEXT] - YYYY-MM-DD

### Important!
- Refactored


## [v1.0.0-alpha.3] - 2018-05-28

### Added
- Config loader
- Controller fallback to parent resolver
- Session setFlash() and hasFlash()
- Param pathNamespace to controller resolver

### Changed
- Move hardcoded param to $config
- Dispatcher controller load use request
- Improve error and exception handler

### Removed
- Error log in controller resolver

### Fixed
- Fallback controller resolver never reached
- Prefixing slash checker for namespace
- _locale route active if two or more languages detected

## [v1.0.0-alpha.2] - 2018-03-03

### Added
- Symfony component HttpKernel, Event, Debug
- Add service Session, Logger, Event hook
- Resolver controller and arguments

### Changed
- HttpKernel replace Dispatcher
- Component folder replace Library


## v1.0.0-alpha.1 - 2018-02-18

### Added
* Initial


[NEXT]: https://github.com/qaharmdz/gubug/compare/v1.0.0-alpha.3...HEAD
[v1.0.0-alpha.2]: https://github.com/qaharmdz/gubug/compare/v1.0.0-alpha.1...v1.0.0-alpha.2
[v1.0.0-alpha.3]: https://github.com/qaharmdz/gubug/compare/v1.0.0-alpha.2...v1.0.0-alpha.3
