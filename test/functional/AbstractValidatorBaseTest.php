<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;
use Dhii\Validation\AbstractValidatorBase as TestSubject;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Exception as RootException;

/**
 * Tests {@see TestSubject}.
 *
 * @since 0.1
 */
class AbstractValidatorBaseTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since 0.1
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Validation\AbstractValidatorBase';

    /**
     * Creates a new instance of the test subject.
     *
     * @since 0.1
     *
     * @param array $methods The methods to mock.
     *
     * @return TestSubject|MockObject The new instance.
     */
    public function createInstance($methods = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
        ]);

        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods)
            ->getMockForAbstractClass();

        return $mock;
    }

    /**
     * Merges the values of two arrays.
     *
     * The resulting product will be a numeric array where the values of both inputs are present, without duplicates.
     *
     * @since [*next-version*]
     *
     * @param array $destination The base array.
     * @param array $source      The array with more keys.
     *
     * @return array The array which contains unique values
     */
    public function mergeValues($destination, $source)
    {
        return array_keys(array_merge(array_flip($destination), array_flip($source)));
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return RootException|MockObject The new exception.
     */
    public function createException($message = '')
    {
        $mock = $this->getMockBuilder('Exception')
            ->setConstructorArgs([$message])
            ->getMock();

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
     * Tests whether validation works as expected when given a valid value.
     *
     * @since [*next-version*]
     */
    public function testValidateSuccessValid()
    {
        $val = uniqid('subject');
        $subject = $this->createInstance(['_getValidationErrors']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_getValidationErrors')
            ->with($val)
            ->will($this->returnValue([]));

        $_subject->_construct();
        $subject->validate($val);
    }

    /**
     * Tests whether validation works as expected when given an invalid value.
     *
     * @since [*next-version*]
     */
    public function testValidateSuccessInvalid()
    {
        $val = uniqid('subject');
        $subject = $this->createInstance(['_getValidationErrors']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_getValidationErrors')
            ->with($val)
            ->will($this->returnValue([uniqid('problem')]));

        $this->setExpectedException('Dhii\Validation\Exception\ValidationFailedException');
        $subject->validate($val);
    }

    /**
     * Tests whether validation fails as expected when a problem happens during validation.
     *
     * @since [*next-version*]
     */
    public function testValidateFailure()
    {
        $val = uniqid('subject');
        $exception = $this->createException('Problem validating');
        $subject = $this->createInstance(['_getValidationErrors']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_getValidationErrors')
            ->with($val)
            ->will($this->throwException($exception));

        $this->setExpectedException('Dhii\Validation\Exception\ValidationException');
        $subject->validate($val);
    }
}
