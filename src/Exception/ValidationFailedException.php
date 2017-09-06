<?php

namespace Dhii\Validation\Exception;

use Traversable;
use Exception as RootException;
use Dhii\Util\String\StringableInterface as Stringable;
use Dhii\Validation\ValidationSubjectAwareTrait;
use Dhii\Validation\ValidatorAwareTrait;
use Dhii\Validation\ValidationErrorsAwareTrait;
use Dhii\I18n\StringTranslatingTrait;
use Dhii\Exception\CreateInvalidArgumentExceptionCapableTrait;
use Dhii\Validation\ValidatorInterface;

/**
 * Represents an exception that occurs when a subject is determined to be invalid.
 *
 * @since 0.1
 */
class ValidationFailedException extends AbstractValidationFailedException implements ValidationFailedExceptionInterface
{
    /*
     * Adds validation subject awareness.
     *
     * @since [*next-version*]
     */
    use ValidationSubjectAwareTrait;

    /*
     * Adds validator awareness.
     *
     * @since [*next-version*]
     */
    use ValidatorAwareTrait;

    /*
     * Adds dummy internationalization functionality.
     *
     * @since [*next-version*]
     */
    use StringTranslatingTrait;

    /*
     * Adds functionality for creating invalid argument exceptions.
     *
     * @since [*next-version*]
     */
    use CreateInvalidArgumentExceptionCapableTrait;

    /*
     * Adds validation errors awareness.
     *
     * @since [*next-version*]
     */
    use ValidationErrorsAwareTrait;

    /**
     * @since 0.1
     *
     * @param string|Stringable|null                 $message          The error message, if any.
     * @param int|null                               $code             The error code, if any.
     * @param RootException|null                     $previous         The inner exception, if any.
     * @param ValidatorInterface|null                $validator        The validator, if any.
     * @param mixed|null                             $subject          The validation subject, if any.
     * @param string[]|Stringable[]|Traversable|null $validationErrors The validation errors to associate with this instance.
     */
    public function __construct($message = null, $code = null, RootException $previous = null, $validator = null, $subject = null, $validationErrors = null)
    {
        parent::__construct((string) $message, (int) $code, $previous);

        $this->_setValidator($validator);
        $this->_setValidationSubject($subject);
        $this->_setValidationErrors($validationErrors);
        $this->_construct();
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

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getValidator()
    {
        return $this->_getValidator();
    }
}
