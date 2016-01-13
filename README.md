# Survey Manager
Module for managing third-party surveys in Drupal 8.

# Installation

Download and enable it as a regular module.

# How it works
This module uses Block API, every survey is just a specific type of block.

This gives you flexibility of block visibility settings. You can control how, where and who will see the survey.


There are 2 types of surveys:

## Embed survey
This is a type of survey where you can put/embed third party JS scripts (e.g. SurveyMonkey).
You put Embed surveys in some region but they wont appear in any of them, their contents of embed code will be printed at the bottom of the page as a script.


## HTML Survey
This is just a regular block, it has a field for storing whatever HTML you want and it will be printed out as a regular block in regions or as a filter in any content.


# Usage
After installing this module you will see Survey Manger link under Structure menu. This is where all your surveys reside.


# Developer Guideline

```
# Install development dependencies
composer install

# Run PHP code audits
composer run phpcs

# Run PHP Copy-Paste detector
composer run phpcpd
```
