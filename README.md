# Laravel Useful CommonMark Extension

[![Build Status](https://travis-ci.com/johnnyhuy/laravel-useful-commonmark-extension.svg?branch=master)](https://travis-ci.com/johnnyhuy/laravel-useful-commonmark-extension)
[![Latest Stable Version](https://poser.pugx.org/johnnyhuy/laravel-useful-commonmark-extension/version)](https://packagist.org/packages/johnnyhuy/laravel-useful-commonmark-extension)
[![Total Downloads](https://poser.pugx.org/johnnyhuy/laravel-useful-commonmark-extension/downloads)](https://packagist.org/packages/johnnyhuy/laravel-useful-commonmark-extension)
[![composer.lock available](https://poser.pugx.org/johnnyhuy/laravel-useful-commonmark-extension/composerlock)](https://packagist.org/packages/johnnyhuy/laravel-useful-commonmark-extension)

A Laravel PHP Composer packaged of useful CommonMark extensions for The PHP Leagues [CommonMark implementation](https://github.com/thephpleague/commonmark).

## Wiki

I've composed a wiki page to describe features of this extension.

### Added Markdown features

- [YouTube](https://github.com/johnnyhuy/laravel-useful-commonmark-extension/wiki/YouTube)
- [Text Alignment](https://github.com/johnnyhuy/laravel-useful-commonmark-extension/wiki/Text-Alignment)

## Getting started

Instructions to install this extension to your Laravel project.

### Prerequisites

- PHP >= 7.1
- Laravel >= 5.5

### Installation

Follow these steps to get this CommonMark extension working in your Laravel project!

#### Installing the Composer package

Run the following command at your root Laravel project directory (where `package.json` exists).

```bash
$ composer require johnnyhuy/laravel-commonmark-useful-extensions
```

#### Adding the Markdown extension to a config

Add `JohnnyHuy\Laravel\UsefulCommonMarkExtension::class` in `config/markdown.php` in the `extensions` array. Here's an example:

```php
'extensions' => [
    ...
    JohnnyHuy\Laravel\UsefulCommonMarkExtension::class
    ...
],
```

#### (Optional) Adding the service provider to app config

If automatic package discovery is not enabled in your project, add the following line to register the service provider in your `config/app.php`. Here's an example:

```php
'providers' => [
    ...
    JohnnyHuy\Laravel\UsefulCommonMarkExtensionServiceProvider::class,
    ...
],
```

## Running the tests

Clone this repository and run `composer install` to install all relevant Composer packages. Change the root extension directory and run the following command to execute PHPUnit test cases.

```bash
$ vendor/bin/phpunit tests/
```

## Contribution

- Project derived from [Graham Campbell](https://github.com/GrahamCampbell)'s [emoji parser](https://github.com/AltThree/Emoji) for Laravel 5.
- **Johnny Huynh** - Initial changes

## License

This project is licensed under the MIT license, see [LICENSE](https://github.com/johnnyhuy/laravel-commonmark-useful-extensions/blob/master/LICENSE) for more information.

- **league/commonmark** is licensed under the [BSD-3 license](https://github.com/thephpleague/commonmark/blob/master/LICENSE)
- **GrahamCampbell/Laravel-Markdown** is licensed under the [MIT License](https://github.com/GrahamCampbell/Laravel-Markdown/blob/master/LICENSE)
- **AltThree/Emoji** is licensed under the [MIT License](https://github.com/AltThree/Emoji/blob/master/LICENSE)
