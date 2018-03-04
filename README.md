# Gubug

[![Build Status](https://travis-ci.org/qaharmdz/gubug.svg?branch=master)](https://travis-ci.org/qaharmdz/gubug)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/qaharmdz/gubug/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/qaharmdz/gubug/)
[![Code Coverage](https://scrutinizer-ci.com/g/qaharmdz/gubug/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/qaharmdz/gubug/)
[![GitHub license](https://img.shields.io/github/license/qaharmdz/gubug.svg)](https://github.com/qaharmdz/gubug/blob/master/LICENSE)

---

Gubug is an experimental PHP micro framework. Developed on top of Symfony Components with [PAC architecture](https://en.wikipedia.org/wiki/Presentation-abstraction-control) in mind.

No further info for now, maybe later..

## Vision
Project vision, scope and an experimental subject.

#### _Symfony component_ Micro Framework
- Flow: ```Request - {Routing % Dispatcher} - Response```.
- Event based middleware.
- Preserve the valid callback of route _\_controller_.
- _ExceptionListener_ is a must.

#### _Opinionated_ PAC Micro Framework
- Flow: ```Request - Routing - Main Agent - Dispatcher - Response```.
    - Cons: main agent become immutable from middleware.
    - Pros: _cons?_ now I know who the boss is. Just call it the ```Outerware```
- Dynamic route: route _\_path_ into ```folder/file-class/{method|index}/...argsPair[key:value]}```.
- Additional service: config, session, security, logger, hook.

#### Brainstorm Notes
- __Important__: Do not overuse Symfony component, make it KISS! :kiss:
- Assume agent-level like Joomla extensions taxonomy: component, module, plugin.
- Custom hook event like Wordpress: _action_ and _filter_.
---
- Support multilanguages route
- Agent response not necessary output, explicit requirement of _setOutput()_.
- Main agent must respect _setOutput()_ and not try to change anything.
- Embed agent controller should be done in upper agent, not in Presenter
- Silex have awesome group of provider, should we _steal_ it? :innocent:

#### Unfeatures
- No library: database, image, asset, mail, cache, i18n

