<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;
use Dhii\Validation\Exception\ValidationFailedException;

/**
 * Tests {@see \Dhii\Validation\Exception\ValidationFailedException}.
 *
 * @since 0.1
 */
class ValidationFailedExceptionTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since 0.1
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Validation\\Exception\\ValidationFailedException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since 0.1
     *
     * @return ValidationFailedException
     */
    public function createInstance($message = '', $subject = null, $validationErrors = array())
    {
        $me = $this;
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->new($message, 0, null, $subject, $validationErrors);

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since 0.1
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(static::TEST_SUBJECT_CLASSNAME, $subject, 'Could not create a valid instance');
    }

    /**
     * Tests that passed data can be correctly retrieved from instances.
     *
     * @since 0.1
     */
    public function testAttributes()
    {
        $value = 'banana';
        $errors = array('orange', 'pineapple');

        $subject = $this->createInstance('', $value, $errors);
        $this->assertEquals($value, $subject->getSubject(), 'Validation subject could not be correctly retrieved');
        $this->assertEquals($errors, $subject->getValidationErrors(), 'Validation errors could not be correctly retrieved');
    }

    /**
     * Tests that the validation exception gets created correctly.
     *
     * @since 0.1
     */
    public function testCreateValidationException()
    {
        $message = 'apple';
        $inner = new \Exception();
        $code = 123;
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $exception = $reflection->_createValidationException($message, $code, $inner);
        /* @var $exception \Dhii\Validation\Exception\ValidationException */
        $this->assertInstanceOf('Dhii\\Validation\\Exception\\ValidationExceptionInterface', $exception, 'Created exception is not a valid validation exception');
        $this->assertEquals($message, $exception->getMessage(), 'Created exception does not have the correct message');
        $this->assertEquals($code, $exception->getCode(), 'Created exception does not have the correct code');
        $this->assertEquals($inner, $exception->getPrevious(), 'Created exception does not have the correct inner exception');
    }
}
