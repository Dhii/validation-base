<?php

namespace Dhii\Validation;

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
    protected function _createValidationException($message, $code = 0, \Exception $previous = null)
    {
        return new ValidationException($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     *
     * @since 0.1
     */
    protected function _createValidationFailedException($message, $code = 0, \Exception $previous = null, $subject = null, $validationErrors = array())
    {
        return new ValidationFailedException($message, $code, $previous, $subject, $validationErrors);
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
