# Gubug

[![Build Status](https://travis-ci.org/qaharmdz/gubug.svg?branch=master)](https://travis-ci.org/qaharmdz/gubug)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/qaharmdz/gubug/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/qaharmdz/gubug/)
[![Code Coverage](https://scrutinizer-ci.com/g/qaharmdz/gubug/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/qaharmdz/gubug/)
[![GitHub license](https://img.shields.io/github/license/qaharmdz/gubug.svg)](https://github.com/qaharmdz/gubug/blob/master/LICENSE)

---

Gubug is an experimental opinionated micro framework developed on top of Symfony 4 components with [PAC architecture](https://en.wikipedia.org/wiki/Presentation-abstraction-control) in mind.

## Scenario
- Support multiple apps (Admin, Front etc is different app)
- Apps controller 

## Challenge
- Dynamic route automatically locate controller at app component
    - Able to setup base namespace to cover different app base
- A resolver to map required file per app
    - Resolver can be used to map child controller, module, language etc
- Main component covered by event middleware, while other call use before/ after event
- Log all error, optionaly display on screen
