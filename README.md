# Behat Contexts Extension

 master | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GMaissa/BehatContextsExtension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GMaissa/BehatContextsExtension/?branch=master) |
--------|---------|

## About

This bundle provides Behat Context classes :

* OauthContext : to manage oauth authentication
* FormContext  : to additional form steps
* WindowSizeContext : to manage browser window resize before tests

As well as usefull Traits :

* SpinTrait : to manage retry on steps, until either they pass or time out
* WindowSizeTrait : to manage browser window resize before tests

## Installation

With composer :

First add the package repository to your composer.json file (package not yet available on packagist):

    ...
    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/GMaissa/BehatContextsExtension.git"
        }
    ],
    ...

Install the package :

    php composer.phar require --dev gmaissa/behat-contexts-extension

## Usage

Activate the extension in your behat.yml file :

    default:
        # ...
        extensions:
            GMaissa\BehatContextsExtension: ~

Enable the desired contexts:

    default:
        suites:
            default:
                contexts:
                    - gm:context:oauth
                    - gm:context:form
                    - gm:context:windowSize

## Contexts configuration

### OauthContext

* serverUrl : OAuth server URL
* clientId : OAuth client ID
* clientSecret : OAuth client secret key

### WindowSizeContext

* width : window width
* height : window height

## Contributing

In order to be accepted, your contribution needs to pass a few controls : 

* PHP files should be valid
* PHP files should follow the [PSR-2](http://www.php-fig.org/psr/psr-2/) standard
* PHP files should be [phpmd](https://phpmd.org) and [phpcpd](https://github.com/sebastianbergmann/phpcpd) warning/error free

Finally, in order to homogenize commit messages across contributors (and to ease generation of the CHANGELOG), please apply this [git commit message hook](https://gist.github.com/GMaissa/f008b2ffca417c09c7b8) onto your local repository. 
