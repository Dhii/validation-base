<?php

namespace Dhii\Validation\FuncTest;

use Dhii\Validation\CreateValidationFailedExceptionCapableTrait as TestSubject;
use Dhii\Validation\ValidatorInterface;
use Xpmock\TestCase;
use Exception as RootException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_MockObject_MockBuilder as MockBuilder;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class CreateValidationFailedExceptionCapableTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Validation\CreateValidationFailedExceptionCapableTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $methods The methods to mock.
     *
     * @return MockObject The new instance.
     */
    public function createInstance($methods = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
            '__',
        ]);

        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods)
            ->getMockForTrait();

        $mock->method('__')
                ->will($this->returnArgument(0));

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
     * Creates a mock that both extends a class and implements interfaces.
     *
     * This is particularly useful for cases where the mock is based on an
     * internal class, such as in the case with exceptions. Helps to avoid
     * writing hard-coded stubs.
     *
     * @since [*next-version*]
     *
     * @param string   $className      Name of the class for the mock to extend.
     * @param string[] $interfaceNames Names of the interfaces for the mock to implement.
     *
     * @return MockBuilder The builder for a mock of an object that extends and implements
     *                     the specified class and interfaces.
     */
    public function mockClassAndInterfaces($className, $interfaceNames = [])
    {
        $paddingClassName = uniqid($className);
        $definition = vsprintf('abstract class %1$s extends %2$s implements %3$s {}', [
            $paddingClassName,
            $className,
            implode(', ', $interfaceNames),
        ]);
        eval($definition);

        return $this->getMockBuilder($paddingClassName);
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
     * Creates a new validator.
     *
     * @since [*next-version*]
     *
     * @param array|null $methods The methods to mock, if any.
     *
     * @return MockObject|ValidatorInterface The new validator.
     */
    public function createValidator($methods = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
        ]);
        $mock = $this->getMockBuilder('Dhii\Validation\ValidatorInterface')
            ->setMethods($methods)
            ->getMock();

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

        $this->assertInternalType(
            'object',
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests that `_createValidationFailedException()` works as expected.
     *
     * @since [*next-version*]
     */
    public function testCreateValidationFailedExceptionCapableTrait()
    {
        $message = uniqid('message');
        $code = rand(0, 99);
        $inner = $this->createException(uniqid('message'));
        $validator = $this->createValidator();
        $val = uniqid('subject');
        $errors = [uniqid('error')];
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $result = $_subject->_createValidationFailedException($message, $code, $inner, $validator, $val, $errors);
        $this->assertInstanceOf('Dhii\Validation\Exception\ValidationFailedException', $result, 'Created exception is of the wrong type');
        $this->assertEquals($message, $result->getMessage(), 'Created exception has the wrong message');
        $this->assertEquals($code, $result->getCode(), 'Created exception has the wrong code');
        $this->assertEquals($inner, $result->getPrevious(), 'Created exception has the wrong inner exception');
        $this->assertEquals($validator, $result->getValidator(), 'Created exception has the wrong validator');
        $this->assertEquals($val, $result->getSubject(), 'Created exception has the wrong subject');
        $this->assertEquals($errors, $result->getValidationErrors(), 'Created exception has the wrong validation errors');
    }
}
