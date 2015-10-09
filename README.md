# Caspeco

![caspeco](https://cloud.githubusercontent.com/assets/499192/10389414/889fba38-6e71-11e5-8620-3d2a8831dc2f.png)

A Caspeco API library for PHP with Laravel support. Work in progress...

[![Build Status](https://img.shields.io/travis/schimpanz/PHP-Caspeco/master.svg?style=flat)](https://travis-ci.org/schimpanz/PHP-Caspeco)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/schimpanz/PHP-Caspeco.svg?style=flat)](https://scrutinizer-ci.com/g/schimpanz/PHP-Caspeco/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/schimpanz/PHP-Caspeco.svg?style=flat)](https://scrutinizer-ci.com/g/schimpanz/PHP-Caspeco)
[![Latest Version](https://img.shields.io/github/release/schimpanz/PHP-Caspeco.svg?style=flat)](https://github.com/schimpanz/PHP-Caspeco/releases)
[![License](https://img.shields.io/packagist/l/schimpanz/caspeco.svg?style=flat)](https://packagist.org/packages/schimpanz/caspeco)

## Installation
Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require schimpanz/pushwoosh
```

### Using Laravel?

Add the service provider to ```config/app.php``` in the `providers` array.

```php
Schimpanz\Caspeco\CaspecoServiceProvider::class
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in ```config/app.php``` to your aliases array.

```php
'Caspeco' => Schimpanz\Caspeco\Facades\Caspeco::class
```

## License

Caspeco is licensed under [The MIT License (MIT)](LICENSE).
