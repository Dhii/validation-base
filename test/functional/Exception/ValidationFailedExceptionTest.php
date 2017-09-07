<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;
use Exception as RootException;
use Dhii\Validation\Exception\ValidationFailedException as TestSubject;
use Dhii\Validation\ValidatorInterface;

/**
 * Tests {@see TestSubject}.
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
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Validation\Exception\ValidationFailedException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since 0.1
     *
     * @return TestSubject
     */
    public function createInstance($message = null, $code = null, $inner = null, $validator = null, $subject = null, $validationErrors = null)
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->new($message, $code, $inner, $validator, $subject, $validationErrors);

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
     * Creates a new validator instance.
     *
     * @since [*next-version*]
     *
     * @return ValidatorInterface The new validator.
     */
    protected function _createValidator()
    {
        $mock = $this->mock('Dhii\Validation\ValidatorInterface')
                ->validate()
                ->new();

        return $mock;
    }

    /**
     * Creates a new exception instance.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message
     *
     * @return RootException The new exception.
     */
    protected function _createException($message = '')
    {
        return new RootException($message);
    }

    /**
     * Tests that passed data can be correctly retrieved from instances.
     *
     * @since 0.1
     */
    public function testAttributes()
    {
        $value = 'banana';
        $validator = $this->_createValidator();
        $errors = array('orange', 'pineapple');
        $message = uniqid('message-');
        $code = rand(0, 100);
        $inner = $this->_createException();

        $subject = $this->createInstance($message, $code, $inner, $validator, $value, $errors);
        $this->assertEquals($message, $subject->getMessage(), 'Error message could not be correctly retrieved');
        $this->assertEquals($code, $subject->getCode(), 'Error code could not be correctly retrieved');
        $this->assertEquals($inner, $subject->getPrevious(), 'Inner exception could not be correctly retrieved');
        $this->assertSame($validator, $subject->getValidator(), 'Validator could not be correctly retrieved');
        $this->assertEquals($value, $subject->getSubject(), 'Validation subject could not be correctly retrieved');
        $this->assertEquals($errors, $subject->getValidationErrors(), 'Validation errors could not be correctly retrieved');
    }
}
