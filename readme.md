# Zenify/DoctrineQueryStats 

[![Downloads this Month](https://img.shields.io/packagist/dm/zenify/doctrine-query-stats.svg)](https://packagist.org/packages/zenify/doctrine-query-stats)
[![Latest stable](https://img.shields.io/packagist/v/zenify/doctrine-query-stats.svg)](https://packagist.org/packages/zenify/doctrine-query-stats)

Implementation of [DoctrineQueryStatisticsBundle](https://github.com/sensiolabs/SensioLabsDoctrineQueryStatisticsBundle) in Nette.


## Usage

Install latest version via composer:

```sh
$ composer require zenify/doctrine-query-stats
```

Register extension in `config.neon`:

```yaml
extensions:
	- Zenify\DoctrineQueryStats\DI\DqsExtension
```

For duplicate queries now you can see overview in debug bar:
	
![Debug panel](screenshot.png)
