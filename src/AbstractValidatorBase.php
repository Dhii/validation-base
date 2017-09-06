<?php

namespace Dhii\Validation;

use Exception as RootException;
use Dhii\Validation\Exception\ValidationException;
use Dhii\Validation\Exception\ValidationFailedException;

/**
 * Base functionality for validators.
 * 
 * Currently, allows creation of concrete exceptions.
 *
 * @since 0.1
 */
abstract class AbstractValidatorBase extends AbstractValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     *
     * @since 0.1
     */
    protected function _createValidationException($message = null, $code = null, RootException $previous = null)
    {
        return new ValidationException($message, $code, $previous, $this);
    }

    /**
     * {@inheritdoc}
     *
     * @since 0.1
     */
    protected function _createValidationFailedException($message = null, $code = null, RootException $previous = null, $subject = null, $validationErrors = null)
    {
        return new ValidationFailedException($message, $code, $previous, $this, $subject, $validationErrors);
    }

    /**
     * {@inheritdoc}
     *
     * @since 0.1
     */
    public function validate($subject)
    {
        $this->_validate($subject);
    }
}
