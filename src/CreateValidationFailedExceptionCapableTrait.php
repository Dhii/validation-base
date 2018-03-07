<?php

namespace Dhii\Validation;

use Dhii\Validation\Exception\ValidationFailedException;
use Exception as RootException;
use Dhii\Util\String\StringableInterface as Stringable;
use Traversable;

/**
 * Functionality for creating Validation exceptions.
 *
 * @since [*next-version*]
 */
trait CreateValidationFailedExceptionCapableTrait
{
    /**
     * Creates a new validation exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|null $message  The message, if any
     * @param int|null               $code     The error code, if any.
     * @param RootException|null     $previous The inner exception, if any.
     * @param ValidatorInterface|null     $validator The validator which triggered the exception, if any.
     * @param mixed|null                             $subject          The subject that has failed validation, if any.
     * @param string[]|Stringable[]|Traversable|null $validationErrors The errors that are to be associated with the new exception, if any.
     *
     * @return ValidationFailedException The new exception.
     */
    protected function _createValidationFailedException(
        $message = null,
        $code = null,
        RootException $previous = null,
        ValidatorInterface $validator = null,
        $subject = null,
        $validationErrors = null
    ) {

        return new ValidationFailedException($message, $code, $previous, $validator, $subject, $validationErrors);
    }
}
