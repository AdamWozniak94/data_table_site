# Data table site

Simple site based on Symfony5.4 containing responsive data table.

## Requirements

* PHP 7.3.0 or higher;
* Apache HTTP Server;
* and the [usual Symfony application requirements][1].

## Installation

Clone this project into desirable location.
After that in main folder run:

```bash
$ composer install
```

## Usage

### Preferable option

Use a web server Apache to run the application.
It will be accessible in your browser at the given URL (<https://localhost/data_table_site/public> by default).

### Other options

#### [Download Symfony CLI][2] and run this command:

```bash
$ cd data_table_site
$ symfony serve
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).

#### Use the built-in PHP web server:

```bash
$ cd data_table_site
$ php -S localhost:8000 -t public/
```

[1]: https://symfony.com/doc/current/setup.html#technical-requirements
[2]: https://symfony.com/download
