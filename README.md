# An easy way to work with the Laposta API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrk-j/laposta.svg?style=flat-square)](https://packagist.org/packages/mrk-j/laposta)
[![Build Status](https://img.shields.io/travis/mrk-j/laposta/master.svg?style=flat-square)](https://travis-ci.org/mrk-j/laposta)
[![Quality Score](https://img.shields.io/scrutinizer/g/mrk-j/laposta.svg?style=flat-square)](https://scrutinizer-ci.com/g/mrk-j/laposta)
[![StyleCI](https://styleci.io/repos/90415839/shield?branch=master)](https://styleci.io/repos/90415839)
[![Total Downloads](https://img.shields.io/packagist/dt/mrk-j/laposta.svg?style=flat-square)](https://packagist.org/packages/mrk-j/laposta)

An easy way to work with the Laposta API. This package is currently under development and therefore **not available through Packagist/composer yet**!

## ~~Installation~~
~~You can install the package via composer:~~

```bash
composer require mrk-j/laposta
```

## Usage

``` php
/* Create new Laposta instance */
$laposta = new Mrkj\Laposta\Laposta('{YOUR API KEY}');

/* Create new List */
$list = $laposta->createList('New list');

/* Update list */
$list->name = 'Updated list';
$laposta->updateList($list);

/* Delete list */
$laposta->deleteList($list);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email github@markj.nl instead of using the issue tracker.

## Credits

- [Mark](https://github.com/mrk-j)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
