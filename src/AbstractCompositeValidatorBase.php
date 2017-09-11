<?php

namespace Dhii\Validation;

use Traversable;
use Iterator;
use ArrayIterator;
use IteratorIterator;
use AppendIterator;
use Dhii\Iterator\NormalizeIteratorCapableTrait;
use Dhii\Iterator\CountIterableCapableTrait;
use Dhii\Validation\Exception\ValidationException;
use Dhii\Validation\Exception\ValidationFailedException;
use Exception as RootException;

/**
 * Base functionality for validators.
 * 
 * Currently, allows creation of concrete exceptions.
 *
 * @since [*next-version*]
 */
abstract class AbstractCompositeValidatorBase extends AbstractCompositeValidator implements ValidatorInterface
{
    /*
     * Adds iterator normalization functionality.
     *
     * @since [*next-version*]
     */
    use NormalizeIteratorCapableTrait;

    /*
     * Adds functionality for counting iterables.
     *
     * @since [*next-version*]
     */
    use CountIterableCapableTrait;

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function validate($subject)
    {
        $this->_validate($subject);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _createValidationException($message = null, $code = null, RootException $previous = null)
    {
        return new ValidationException($message, $code, $previous, $this);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _createValidationFailedException($message = null, $code = null, RootException $previous = null, $subject = null, $validationErrors = null)
    {
        return new ValidationFailedException($message, $code, $previous, $this, $subject, $validationErrors);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _normalizeErrorList($errorList)
    {
        $listIterator = new AppendIterator();
        foreach ($errorList as $_error) {
            $listIterator->append($this->_normalizeIterator($_error));
        }

        return $listIterator;
    }

    /**
     * Creates an iterator that will iterate over the given array.
     *
     * @param array $array The array to create an iterator for.
     *
     * @since [*next-version*]
     *
     * @return Iterator The iterator that will iterate over the array.
     */
    protected function _createArrayIterator($array)
    {
        return new ArrayIterator($array);
    }

    /**
     * Creates an iterator that will iterate over the given traversable.
     *
     * @param Traversable $traversable The traversable to create an iterator for.
     *
     * @since [*next-version*]
     *
     * @return Iterator The iterator that will iterate over the traversable.
     */
    protected function _createTraversableIterator($traversable)
    {
        return new IteratorIterator($traversable);
    }
}
