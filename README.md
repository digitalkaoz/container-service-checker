Container-Checker
=========================

This small Library checks various aspects of a Symfony2 DI-Container.

Installation
------------

let composer do the job:
```
$ composer require digitalkaoz/container-checker
```

or edit your `composer.json` manually:
```json
"require" : {
    "digitalkaoz/container-checker" : "*"
}
```

Usage
-----


*Check Instanciation of all Container Services*

```
$ bin/checker.php check:services path/to/your/AppKernel.php
```

or with different Environments and Scopes:

```
$ bin/checker.php check:services path/to/your/AppKernel.php -env=prod --scope=request
```



*Check all Container Parameters which are Class-Names to be autoloadable*

```
$ bin/checker.php check:parameters path/to/your/AppKernel.php
```

or with different Environments:

```
$ bin/checker.php check:parameters path/to/your/AppKernel.php -env=prod
```

Test
----

Nothing to see here, move along ;)

TODO
----

* some tests
* grep the autoloader of the loaded Kernel and ask there for a autoloadable class insteat of `class_exists`
* some more sanity checks


