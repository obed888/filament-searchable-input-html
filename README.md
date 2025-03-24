# A searchable autocomplete input for Filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/defstudio/filament-searchable-input.svg?style=flat-square)](https://packagist.org/packages/defstudio/filament-searchable-input)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/defstudio/filament-searchable-input/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/defstudio/filament-searchable-input/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/defstudio/filament-searchable-input/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/defstudio/filament-searchable-input/actions?query=workflow%3A"fix-php-code-style-issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/defstudio/filament-searchable-input.svg?style=flat-square)](https://packagist.org/packages/defstudio/filament-searchable-input)



[demo.webm](https://github.com/user-attachments/assets/cdc816c4-fa80-46f7-bb7b-43f2f018f61e)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require defstudio/filament-searchable-input
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-searchable-input-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-searchable-input-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-searchable-input-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$searchableInput = new DefStudio\SearchableInput();
echo $searchableInput->echoPhrase('Hello, DefStudio!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Fabio Ivona](https://github.com/fabio-ivona)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
