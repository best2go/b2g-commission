Table of Contents
-----------------
* [TODOs](#TODOs)
* [result](#result)
* [phpunit](#phpunit)

## TODOs
- refactor `string $country` as `Country`
- refactor `string $currency` as `Currency`
- refactor `float $amount|$fee` as `Money`
- refactor `float $rate` as `FxRate`
- refactor `float $commission` as `Commission`
- use `Serializer::deserialize()` instead of `json_decode()`
- review naming (namespaces)
- review responsibility
- provide E2E auto test

## result
```
[docker://xphp:8.2/]:php /opt/project/app.php input.txt
+----------+---------+--------------+----------+--------+---------+
| bin      | country |       amount | currency |    fee | message |
+----------+---------+--------------+----------+--------+---------+
| 45717360 | DK      |       100.00 | EUR      |   1.00 | OK      |
| 516793   | LT      |        50.00 | USD      |   0.45 | OK      |
| 45417360 | JP      |     10000.00 | JPY      |   1.53 | OK      |
| 41417360 | US      |       130.00 | USD      |   2.31 | OK      |
| 4745030  | N/A     |      2000.00 | GBP      |  47.89 | OK      |
+----------+---------+--------------+----------+--------+---------+

Process finished with exit code 0
```

## phpunit
```
---------------------------
PHP-7.4

Loading composer repositories with package information
Updating dependencies
Nothing to modify in lock file
Installing dependencies from lock file (including require-dev)
Nothing to install, update or remove
Generating autoload files
40 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
stty: standard input
PHPUnit 9.6.19 by Sebastian Bergmann and contributors.

........                                                            8 / 8 (100%)

Time: 00:00.013, Memory: 6.00 MB

OK (8 tests, 11 assertions)
---------------------------
PHP-8.1

Loading composer repositories with package information
Updating dependencies
Lock file operations: 0 installs, 7 updates, 2 removals
- Removing symfony/polyfill-php73 (v1.29.0)
- Removing symfony/polyfill-php80 (v1.29.0)
- Upgrading doctrine/instantiator (1.5.0 => 2.0.0)
- Upgrading psr/container (1.1.2 => 2.0.2)
- Upgrading symfony/console (v5.4.39 => v6.4.7)
- Upgrading symfony/deprecation-contracts (v2.5.3 => v3.5.0)
- Upgrading symfony/dotenv (v5.4.39 => v6.4.7)
- Upgrading symfony/service-contracts (v2.5.3 => v3.5.0)
- Upgrading symfony/string (v5.4.39 => v6.4.7)
  Writing lock file
  Installing dependencies from lock file (including require-dev)
  Package operations: 0 installs, 7 updates, 2 removals
- Removing symfony/polyfill-php80 (v1.29.0)
- Removing symfony/polyfill-php73 (v1.29.0)
- Upgrading symfony/deprecation-contracts (v2.5.3 => v3.5.0): Extracting archive
- Upgrading doctrine/instantiator (1.5.0 => 2.0.0): Extracting archive
- Upgrading symfony/string (v5.4.39 => v6.4.7): Extracting archive
- Upgrading psr/container (1.1.2 => 2.0.2): Extracting archive
- Upgrading symfony/service-contracts (v2.5.3 => v3.5.0): Extracting archive
- Upgrading symfony/console (v5.4.39 => v6.4.7): Extracting archive
- Upgrading symfony/dotenv (v5.4.39 => v6.4.7): Extracting archive
  Generating autoload files
  38 packages you are using are looking for funding.
  Use the `composer fund` command to find out more!
  stty: standard input
  PHPUnit 9.6.19 by Sebastian Bergmann and contributors.

........                                                            8 / 8 (100%)

Time: 00:00.011, Memory: 6.00 MB

OK (8 tests, 11 assertions)
---------------------------
PHP-8.2

Loading composer repositories with package information
Updating dependencies
Lock file operations: 0 installs, 3 updates, 0 removals
- Upgrading symfony/console (v6.4.7 => v7.0.7)
- Upgrading symfony/dotenv (v6.4.7 => v7.0.7)
- Upgrading symfony/string (v6.4.7 => v7.0.7)
  Writing lock file
  Installing dependencies from lock file (including require-dev)
  Package operations: 0 installs, 3 updates, 0 removals
- Upgrading symfony/string (v6.4.7 => v7.0.7): Extracting archive
- Upgrading symfony/console (v6.4.7 => v7.0.7): Extracting archive
- Upgrading symfony/dotenv (v6.4.7 => v7.0.7): Extracting archive
  Generating autoload files
  38 packages you are using are looking for funding.
  Use the `composer fund` command to find out more!
  stty: standard input
  PHPUnit 9.6.19 by Sebastian Bergmann and contributors.

........                                                            8 / 8 (100%)

Time: 00:00.012, Memory: 6.00 MB

OK (8 tests, 11 assertions)
---------------------------
PHP-8.3

Loading composer repositories with package information
Updating dependencies
Nothing to modify in lock file
Writing lock file
Installing dependencies from lock file (including require-dev)
Nothing to install, update or remove
Generating autoload files
38 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
stty: standard input
PHPUnit 9.6.19 by Sebastian Bergmann and contributors.

........                                                            8 / 8 (100%)

Time: 00:00.023, Memory: 6.00 MB

OK (8 tests, 11 assertions)
```
