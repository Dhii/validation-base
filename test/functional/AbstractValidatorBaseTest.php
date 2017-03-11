<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;

/**
 * Tests {@see \Dhii\Validation\AbstractValidatorBase}.
 *
 * @since [*next-version*]
 */
class AbstractValidatorBaseTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Validation\\AbstractValidatorBase';

    /**
     * Creates a new instance of the test subject.
     *
     * It will validate any boolean true value; all other values are invalid.
     *
     * @since [*next-version*]
     *
     * @return AbstractValidator
     */
    public function createInstance()
    {
        $me = $this;
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->_getValidationErrors(function ($subject) {
                    if ($subject !== true) {
                        return array('Subject must be a boolean `true` value');
                    }

                    return array();
                })
                ->new();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(static::TEST_SUBJECT_CLASSNAME, $subject, 'Could not create a valid instance');
    }

    /**
     * Tests whether valid values pass validation.
     *
     * @since [*next-version*]
     */
    public function testValidateSuccess()
    {
        $subject = $this->createInstance();

        $subject->validate(true);
        $this->assertTrue(true, 'This line cannot be reached if validation fails.');
    }

    /**
     * Tests whether invalid values do not pass validation.
     *
     * @expectedException \Dhii\Validation\Exception\ValidationFailedException
     *
     * @since [*next-version*]
     */
    public function testValidateFailed()
    {
        $subject = $this->createInstance();

        $subject->validate(false);
        $this->assertTrue(false, 'Invalid subject passed validation');
    }

    /**
     * Tests that the validation exception gets created correctly.
     *
     * @since [*next-version*]
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

    /**
     * Tests that the validation exception gets created correctly.
     *
     * @since [*next-version*]
     */
    public function testCreateValidationFailedException()
    {
        $message = 'apple';
        $inner = new \Exception();
        $code = 123;
        $value = 'banana';
        $errors = array('strawberry', 'pineapple');
        $subject = $this->createInstance();
        $reflection = $this->reflect($subject);

        $exception = $reflection->_createValidationFailedException($message, $code, $inner, $value, $errors);
        /* @var $exception \Dhii\Validation\Exception\ValidationFailedException */
        $this->assertInstanceOf('Dhii\\Validation\\Exception\\ValidationFailedExceptionInterface', $exception, 'Created exception is not a valid validation failed exception');
        $this->assertEquals($message, $exception->getMessage(), 'Created exception does not have the correct message');
        $this->assertEquals($code, $exception->getCode(), 'Created exception does not have the correct code');
        $this->assertEquals($inner, $exception->getPrevious(), 'Created exception does not have the correct inner exception');
        $this->assertEquals($value, $exception->getSubject(), 'Created exception does not have the correct subject');
        $this->assertEquals($errors, $exception->getValidationErrors(), 'Created exception does not have the correct validation errors');
    }
}
