# Laravel Command UI

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zwartpet/command-ui.svg?style=flat-square)](https://packagist.org/packages/zwartpet/command-ui)
[![Test](https://github.com/Zwartpet/laravel-command-ui/actions/workflows/main.yml/badge.svg)](https://github.com/Zwartpet/laravel-command-ui/actions/workflows/main.yml)

Add an admin interface where you can run Laravel commands without the need to SSH into the server.

## Installation

You can install the package via composer:

```bash
composer require zwartpet/schedule-manager
```

Publish the assets
```bash
php artisan vendor:publish --tag=schedule-manager-assets
```

## Usage

The UI is available on the `/command-ui` route, configurable with `COMMAND_UI_URI` in your `.env` file.

The route is protected with a [Laravel Gate](https://laravel.com/docs/12.x/authorization#gates) named `command-ui` which you can customize with `COMMAND_UI_GATE` in your `.env` file.
Create the gate by adding the following to your `AuthServiceProvider`, not adding this will result in a 404 error when visiting the route.
```php
Gate::define('command-ui', function (User $user) {
    return $user->isAdmin; // or any other logic
});
```

### Configuration

This library is plug and play and works out of the box. There are some configuration options available.

The list of commands is filtered by a blacklist or whitelist, by default the blacklist is used.  
Publish the configuration to change the lists to your needs.
```bash
php artisan vendor:publish --tag=command-ui-config
```

For all the configuration options see the [config file](config/config.php).

## Testing

Pest
```bash
composer test
```

Pint
```bash
composer test:lint
```

PHPStan
```bash
composer test:types
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [John Zwarthoed](https://github.com/zwartpet)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
