# Clock

[![Build Status](https://scrutinizer-ci.com/g/ericsizemore/clock/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ericsizemore/clock/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/ericsizemore/clock/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ericsizemore/clock/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ericsizemore/clock/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ericsizemore/clock/?branch=master)
[![Tests](https://github.com/ericsizemore/clock/actions/workflows/tests.yml/badge.svg)](https://github.com/ericsizemore/clock/actions/workflows/tests.yml)
[![PHPStan](https://github.com/ericsizemore/clock/actions/workflows/main.yml/badge.svg)](https://github.com/ericsizemore/clock/actions/workflows/main.yml)
[![Psalm Static analysis](https://github.com/ericsizemore/clock/actions/workflows/psalm.yml/badge.svg?branch=master)](https://github.com/ericsizemore/clock/actions/workflows/psalm.yml)

[![Type Coverage](https://shepherd.dev/github/ericsizemore/clock/coverage.svg)](https://shepherd.dev/github/ericsizemore/clock)
[![Psalm Level](https://shepherd.dev/github/ericsizemore/clock/level.svg)](https://shepherd.dev/github/ericsizemore/clock)
[![Latest Stable Version](https://img.shields.io/packagist/v/esi/clock.svg)](https://packagist.org/packages/esi/clock)
[![Downloads per Month](https://img.shields.io/packagist/dm/esi/clock.svg)](https://packagist.org/packages/esi/clock)
[![License](https://img.shields.io/packagist/l/esi/clock.svg)](https://packagist.org/packages/esi/clock)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fericsizemore%2Fclock%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/ericsizemore/clock/master)

Yet ...another... PSR-20 Clock implementation.


## Installation

### Composer

The script can be installed using composer. Add this repository as a dependency to the composer.json file.

```bash
$ composer require esi/clock:^1.0
```


## Usage

`Documentation still a work in progress.`


## About

### Requirements

- Clock works with PHP 8.2.0 or above.


### Submitting bugs and feature requests

Bugs and feature requests are tracked on [GitHub](https://github.com/ericsizemore/clock/issues)

Issues are the quickest way to report a bug. If you find a bug or documentation error, please check the following first:

* That there is not an Issue already open concerning the bug
* That the issue has not already been addressed (within closed Issues, for example)


### Contributing

Clock accepts contributions of code and documentation from the community. 
These contributions can be made in the form of Issues or [Pull Requests](http://help.github.com/send-pull-requests/) on the [Clock repository](https://github.com/ericsizemore/clock).

Clock is licensed under the MIT license. When submitting new features or patches to Clock, you are giving permission to license those features or patches under the MIT license.

Clock tries to adhere to PHPStan level 9 with strict rules and bleeding edge. Please ensure any contributions do as well.


#### Guidelines

Before we look into how, here are the guidelines. If your Pull Requests fail to pass these guidelines it will be declined, and you will need to re-submit when you’ve made the changes. This might sound a bit tough, but it is required for me to maintain quality of the code-base.


#### PHP Style

Please ensure all new contributions match the [PSR-12](https://www.php-fig.org/psr/psr-12/) coding style guide. The project is not fully PSR-12 compatible, yet; however, to ensure the easiest transition to the coding guidelines, I would like to go ahead and request that any contributions follow them.


#### Documentation

If you change anything that requires a change to documentation then you will need to add it. New methods, parameters, changing default values, adding constants, etc. are all things that will require a change to documentation. The change-log must also be updated for every change. Also, PHPDoc blocks must be maintained.


##### Documenting functions/variables (PHPDoc)

Please ensure all new contributions adhere to:

* [PSR-5 PHPDoc](https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc.md)
* [PSR-19 PHPDoc Tags](https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc-tags.md)

when documenting new functions, or changing existing documentation.


#### Branching

One thing at a time: A pull request should only contain one change. That does not mean only one commit, but one change - however many commits it took. The reason for this is that if you change X and Y but send a pull request for both at the same time, we might really want X but disagree with Y, meaning we cannot merge the request. Using the Git-Flow branching model you can create new branches for both of these features and send two requests.


### Backward Compatibility Promise

* See [backward-compatibility.md](backward-compatibility.md)


### Author

Eric Sizemore - <admin@secondversion.com> - <https://www.secondversion.com>


### License

Clock is licensed under the MIT [License](LICENSE).