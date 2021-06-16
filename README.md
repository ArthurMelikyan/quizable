# Quizable

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require arthurmelikyan/quizable
```

## Usage
For first you need publish package configuration file, here you can change `logo`, `asset url`, `disk driver` for file uploads and `migrations` configurations. To publish configuration file run `php artisan vendor:publish --tag=quizable.config`

If you want to change default migration directory, you need to define directory name on `quizable.php` file. Just change `'migrations_publish_path'   =>    'subfolder'` config parameter. It will publish all the migration files on `database/migrations/subfolder` directory. If you don't need migration subfolders , you can run `php artisan migrate` without publishing package migrations

To publish assets run `php artisan vendor:publish --tag=quizable.assets`
## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email arthmelikyan@gmail.com instead of using the issue tracker.

## Credits

- [ArthurMelikyan][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/arthurmelikyan/quizable.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/arthurmelikyan/quizable.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/arthurmelikyan/quizable/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/arthurmelikyan/quizable
[link-downloads]: https://packagist.org/packages/arthurmelikyan/quizable
[link-travis]: https://travis-ci.org/arthurmelikyan/quizable
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/arthurmelikyan
[link-contributors]: ../../contributors
