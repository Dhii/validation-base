<?php

namespace Dhii\Validation\Exception;

use Exception as RootException;
use Dhii\Validation\ValidatorAwareTrait;
use Dhii\I18n\StringTranslatingTrait;
use Dhii\Exception\CreateInvalidArgumentExceptionCapableTrait;
use Dhii\Validation\ValidatorInterface;
use Dhii\Util\String\StringableInterface as Stringable;

/**
 * Represents an exception which occurs inside of or related to a validation
 * process.
 *
 * @since 0.1
 */
class ValidationException extends AbstractValidationException implements ValidationExceptionInterface
{
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

    /**
     * @since [*next-version*]
     *
     * @param string|Stringable|null  $message   The error message, if any.
     * @param int|null                $code      The error code, if any.
     * @param RootException|null      $previous  The inner exception, if any.
     * @param ValidatorInterface|null $validator The validator, if any.
     */
    public function __construct($message = null, $code = null, RootException $previous = null, $validator = null)
    {
        parent::__construct((string) $message, (int) $code, $previous);
        $this->_setValidator($validator);
        $this->_construct();
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
