<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;
use Exception as RootException;
use Dhii\Validation\Exception\ValidationException as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since 0.1
 */
class ValidationExceptionTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since 0.1
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Validation\Exception\ValidationException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since 0.1
     *
     * @return TestSubject
     */
    public function createInstance($message = null, $code = null, $inner = null, $validator = null)
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->new($message, $code, $inner, $validator);

        return $mock;
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
     * @since [*next-version*]
     */
    public function testAttributes()
    {
        $validator = $this->_createValidator();
        $message = uniqid('message-');
        $code = rand(0, 100);
        $inner = $this->_createException();

        $subject = $this->createInstance($message, $code, $inner, $validator);
        $this->assertEquals($message, $subject->getMessage(), 'Error message could not be correctly retrieved');
        $this->assertEquals($code, $subject->getCode(), 'Error code could not be correctly retrieved');
        $this->assertEquals($inner, $subject->getPrevious(), 'Inner exception could not be correctly retrieved');
        $this->assertSame($validator, $subject->getValidator(), 'Validator could not be correctly retrieved');
    }
}
