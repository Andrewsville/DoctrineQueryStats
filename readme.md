# Zenify/DoctrineQueryStats 

[![Build Status](https://img.shields.io/travis/Zenify/DoctrineQueryStats.svg?style=flat-square)](https://travis-ci.org/Zenify/DoctrineQueryStats)
[![Quality Score](https://img.shields.io/scrutinizer/g/Zenify/DoctrineQueryStats.svg?style=flat-square)](https://scrutinizer-ci.com/g/Zenify/DoctrineQueryStats)
[![Downloads this Month](https://img.shields.io/packagist/dm/zenify/doctrine-query-stats.svg?style=flat-square)](https://packagist.org/packages/zenify/doctrine-query-stats)
[![Latest stable](https://img.shields.io/packagist/v/zenify/doctrine-query-stats.svg?style=flat-square)](https://packagist.org/packages/zenify/doctrine-query-stats)

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
