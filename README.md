# Laravel Useful CommonMark Extension

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
GrahamCampbell\Markdown\MarkdownServiceProvider
```

## License

This project is licensed under the MIT license, see [LICENSE](https://github.com/johnnyhuy/laravel-commonmark-useful-extensions/blob/master/LICENSE) for more information.

- **GrahamCampbell/Laravel-Markdown** is licensed under [The MIT License (MIT)](https://github.com/GrahamCampbell/Laravel-Markdown/blob/master/LICENSE)
- **league/commonmark** is licensed under the [BSD-3 license](https://github.com/thephpleague/commonmark/blob/master/LICENSE)
