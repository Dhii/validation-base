# Dhii - Validation - Base
[![Build Status](https://travis-ci.org/Dhii/validation-base.svg?branch=develop)](https://travis-ci.org/Dhii/validation-base)
[![Code Climate](https://codeclimate.com/github/Dhii/validation-base/badges/gpa.svg)](https://codeclimate.com/github/Dhii/validation-base)
[![Test Coverage](https://codeclimate.com/github/Dhii/validation-base/badges/coverage.svg)](https://codeclimate.com/github/Dhii/validation-base/coverage)
[![Latest Stable Version](https://poser.pugx.org/dhii/validation-base/version)](https://packagist.org/packages/dhii/validation-base)
[![This package complies with Dhii standards](https://img.shields.io/badge/Dhii-Compliant-green.svg?style=flat-square)][Dhii]

Base concrete functionality for validation.

## Details
This package defines concrete exceptions, and implements their factories in a
validator specialization. It also provides a base for composite validators.

### Classes
- [`AbstractValidatorBase`] - The base class for validators that perform a single validation.
- [`AbstractCompositeValidatorBase`] -  The base class for validators that delegate to one or more iterators.
- [`ValidationException`] - A concrete exception related to validation or a validator.
- [`ValidationFailedException`] - A concrete exception that signals validation failure,
and exposes aspects of the validation.


[`AbstractValidatorBase`]:                  src/AbstractValidatorBase.php
[`AbstractCompositeValidatorBase`]:         src/AbstractCompositeValidatorBase.php
[`ValidationException`]:                    src/Exception/ValidationException.php
[`ValidationFailedException`]:              src/Exception/ValidationFailedException.php

[Dhii]: https://github.com/Dhii/dhii
