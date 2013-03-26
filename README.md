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

You can check **services** or **parameters** of your DI-Container. Services will be checked if they could be *getted* from the Container.
Parameters which looks like ClassNames will be checked if they can be autoloaded.

Here are a few use cases:

**Check Instanciation of all Services**

```
$ bin/checker.php check:services path/to/your/AppKernel.php
```

or with different Environments and Scopes:

```
$ bin/checker.php check:services path/to/your/AppKernel.php -env=prod --scope=request
```


**Check if all Parameters which are Class-Names can be autoloaded**

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
* Portable for other Containers (e.g. ZendDI)


