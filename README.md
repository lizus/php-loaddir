# php-loaddir
load dir files

## first

`composer require lizus/php-loaddir`

## second

```php
require_once __DIR__ . '/vendor/autoload.php';
```

## use sample:

```php
use \Lizus\LoadDir\LoadDir;
$load=LoadDir::load_files(__DIR__.'/function');
```
