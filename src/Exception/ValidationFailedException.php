<?php

namespace Dhii\Validation\Exception;

/**
 * Represents an exception that occurs when a subject is determined to be invalid.
 *
 * @since [*next-version*]
 */
class ValidationFailedException extends AbstractValidationFailedException implements ValidationFailedExceptionInterface
{
    /**
     * @since [*next-version*]
     *
     * @param string[]|StringableInterface[]|\Traversable $validationErrors The validation errors to associate with this instance.
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null, $subject = null, $validationErrors = array())
    {
        parent::__construct($message, $code, $previous);

        $this->_setValidationSubject($subject);
        $this->_setValidationErrors($validationErrors);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _createValidationException($message, $code = 0, \Exception $previous = null)
    {
        return new ValidationException($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getSubject()
    {
        return $this->_getValidationSubject();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getValidationErrors()
    {
        return $this->_getValidationErrors();
    }
}
