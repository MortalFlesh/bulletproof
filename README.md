Bulletproof
===========

[![Latest Stable Version](https://img.shields.io/packagist/v/mf/bulletproof.svg)](https://packagist.org/packages/mf/bulletproof)
[![Build Status](https://travis-ci.org/mf/bulletproof.svg?branch=master)](https://travis-ci.org/mf/bulletproof)
[![Coverage Status](https://coveralls.io/repos/github/mf/bulletproof/badge.svg?branch=master)](https://coveralls.io/github/mf/bulletproof?branch=master)

The union of [PHPStan](https://github.com/phpstan/phpstan) type analysis (_type inference_) and property based testing by [Eris](https://github.com/giorgiosironi/eris).

The idea is that [PHPStan](https://github.com/phpstan/phpstan) will deduce types of parameters and return type of the given method.
Then `Bulletproof` (_currently `AbstractTestCase`_) lib will create generators from [Eris](https://github.com/giorgiosironi/eris) to generate the input for property based test.

For those who knows `QuickCheck`, this _might_ be something similar for PHP (_hopefully one day_).

## Disclaimer
@Ocramius said:
> It would be cool to have a library which do that!

So here it is ...

Well I hope I (_or we 😉_) will implement this library in the future in the way we discuss it with @ocramius, but for now it is basically only the **idea**... 
because [PHPStan](https://github.com/phpstan/phpstan) is not meant to be used like this now... so it could take some time...

## Present

For now there is just a PR https://github.com/MortalFlesh/bulletproof/pull/1 which I will retain open till it will actually do something.

I might (_and probably will_) do some implementation to the PR, some more playing and prototyping of what it _would/could/should_ do in the future,
but it will still be just a _naive and dummy_ implementation for now. 

## Future

We have to wait for [PHPStan](https://github.com/phpstan/phpstan) (_or other tool 🤔_) to get types we need for creating proper generators.

If you have some idea of your own feel free to open an issue or send PR and we can discuss it. 

## Installation
- _NOT YET AVAILABLE_
```bash
composer require mf/bulletproof
```

## Usage

Run **tests** and see the output
```bash
composer tests
```

## Changelog
For latest changes see [CHANGELOG.md](CHANGELOG.md) file. We follow [Semantic Versioning](https://semver.org/).

## Contributing and development

### Install dependencies

```bash
composer install
```

### Run tests

For each pull-request, unit tests as well as static analysis and codestyle checks must pass.

To run all those checks execute:

```bash
composer all
```
