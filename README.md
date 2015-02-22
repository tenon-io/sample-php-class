#Tenon Demo Example - PHP

## Intro

You need a Tenon API key to use this. Register at [https://tenon.io/register.php](https://tenon.io/register.php)

You should eventually dive right into the documentation to make your own awesome stuff with Tenon API [https://bitbucket.org/tenon-io/tenon.io-documentation/](https://bitbucket.org/tenon-io/tenon.io-documentation/)

## Install

If you want to use this immediately, all you need to do is upload it to a PHP-enabled server. Your PHP server must have the cURL extension.

If you're interested in modifying the files, read the CONTRIBUTING.md document

## Configure

Before using this, you must configure a few things. Open the config-sample.php file, edit the following details, and save it as config.php
Here is a description of each setting:

* `TENON_API_KEY`: enter your Tenon API key here.
* `TENON_API_URL`: enter the URL to the Tenon API here. By default it is set to https://tenon.io/api/ but if you're an enterprise user we might have given you a different one.
* `DEBUG`: this requires a boolean value of either `true` or `false` and indicates whether you want to see some debugging messages. In nearly all cases, you want this set to `false`, which is the default.
* `CSV_FILE_PATH`: This comes with the ability to write CSV files with issue results listed. If you intend to use that feature, enter the full file system path to a folder where the CSV files will be saved. This location must be writeable

Sample:

```
define('TENON_API_KEY', 'PUT-YOUR-API-KEY-HERE);
define('TENON_API_URL', 'https://tenon.io/api/');
define('DEBUG', false);
define('CSV_FILE_PATH', 'FULL-SYSTEM-PATH-TO-FOLDER');
```

## Run

Open the `form.html` page, enter the data, hit 'Submit' and watch it go!

## Develop and/ or Contribute

If you want to contribute, read the contributing doc.

## Disclaimer

Tenon does not offer support for this code. The code in this repository is only to show a fully functioning example of the Tenon API. This is instead intended to show you it works and give you a potential starting point for your own application.