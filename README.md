= Logger: Simple PHP logging utility

== Overview

The goal of Simplogger is to provide a logging utility library for PHP Slim Framework, simple to use, and simple to integrate.

Logger can log to:

- stdout
- stderr

Typical use case is a PHP microservice that uses syslogd for logging
when deployed, but can just as easily use stdout/stderr (e.g. in the
development environment).

## [source,php]

use \Majoo\Logger\StdoutLogger;
use \Majoo\Logger\Stderr;

$logger = new StdoutLogger();
$logger->log($request, (string)$response->getBody());

---

== Setup

Add the following to your `composer.json`:

## [source,json]

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ekapratama363/logger"
         }
    ],
    "require": {
        "majoo/logger": "dev-master"
    }

---
