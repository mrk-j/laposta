# An easy way to work with the Laposta API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mrk-j/laposta.svg?style=flat-square)](https://packagist.org/packages/mrk-j/laposta)
[![Build Status](https://img.shields.io/travis/mrk-j/laposta/master.svg?style=flat-square)](https://travis-ci.org/mrk-j/laposta)
[![Quality Score](https://img.shields.io/scrutinizer/g/mrk-j/laposta.svg?style=flat-square)](https://scrutinizer-ci.com/g/mrk-j/laposta)
[![StyleCI](https://styleci.io/repos/90415839/shield?branch=master)](https://styleci.io/repos/90415839)
[![Total Downloads](https://img.shields.io/packagist/dt/mrk-j/laposta.svg?style=flat-square)](https://packagist.org/packages/mrk-j/laposta)

This package provides an easy way to talk to the Laposta API. Laposta is a Dutch platform to send newsletters.

The current version of the package provides support to manage lists and members.

For more information regarding the Laposta API you can visit [their documentation](http://api.laposta.nl/doc/?lib=curl).

## Installation
You can install the package via composer:

```bash
composer require mrk-j/laposta
```

## Usage

``` php
/* Create new Laposta instance */
$laposta = new Mrkj\Laposta\Laposta('{YOUR API KEY}');

/* Create new list */
$list = $laposta->createList('New list');

/* Update list */
$list->name = 'Updated list';
$laposta->updateList($list);

/* Delete list */
$laposta->deleteList($list);

/* Create new member */
$member = $laposta->createMember($list->id, 'foo@example.com');

/* Update member */
$member->email = 'bar@example.com';
$laposta->updateMember($member);

/* Delete member */
$laposta->deleteMember($member);
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
