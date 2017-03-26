<?php

namespace Dhii\Validation\Exception;

/**
 * Represents an exception that occurs when a subject is determined to be invalid.
 *
 * @since 0.1
 */
class ValidationFailedException extends AbstractValidationFailedException implements ValidationFailedExceptionInterface
{
    /**
     * @since 0.1
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
    public function getSubject()
    {
        return $this->_getValidationSubject();
    }

    /**
     * {@inheritdoc}
     *
     * @since 0.1
     */
    public function getValidationErrors()
    {
        return $this->_getValidationErrors();
    }
}
