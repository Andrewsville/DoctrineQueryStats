# Lekarna/DoctrineQueryStats 

[![Downloads this Month](https://img.shields.io/packagist/dm/lekarna/doctrine-query-stats.svg)](https://packagist.org/packages/lekarna/doctrine-query-stats)
[![Latest stable](https://img.shields.io/packagist/v/lekarna/doctrine-query-stats.svg)](https://packagist.org/packages/lekarna/doctrine-query-stats)

Implementation of [DoctrineQueryStatisticsBundle](https://github.com/sensiolabs/SensioLabsDoctrineQueryStatisticsBundle) in Nette.


## Usage

Install latest version via composer:

```sh
$ composer require lekarna/doctrine-query-stats
```

Register extension in `config.neon`:

```yaml
extensions:
	- Lekarna\DoctrineQueryStats\DI\DqsExtension
```

For duplicate queries now you can see overview in debug bar:
	
![Debug panel](screenshot.png)
