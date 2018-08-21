# Laravel Useful CommonMark Extension

[![Latest Stable Version](https://poser.pugx.org/johnnyhuy/laravel-useful-commonmark-extension/version)](https://packagist.org/packages/johnnyhuy/laravel-useful-commonmark-extension)
[![Total Downloads](https://poser.pugx.org/johnnyhuy/laravel-useful-commonmark-extension/downloads)](https://packagist.org/packages/johnnyhuy/laravel-useful-commonmark-extension)
[![composer.lock available](https://poser.pugx.org/johnnyhuy/laravel-useful-commonmark-extension/composerlock)](https://packagist.org/packages/johnnyhuy/laravel-useful-commonmark-extension)

A Laravel PHP Composer packaged of useful CommonMark extensions for The PHP Leagues [CommonMark implementation](https://github.com/thephpleague/commonmark).

## Getting started

Instructions to install this extension to your Laravel project.

### Prerequisites

- PHP >= 7.1
- Laravel >= 5.5

### Installation

Run the following command at your root Laravel project directory (where `package.json` exists).

```bash
$ composer require johnnyhuy/laravel-commonmark-useful-extensions
```

If automatic package discovery is not enabled in your project, add the following line to register the service provider in your `config/app.php`.

```bash
JohnnyHuy\Laravel\UsefulCommonMarkExtension
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
