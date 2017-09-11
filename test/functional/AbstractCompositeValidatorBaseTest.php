<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;
use ArrayIterator;
use Traversable;
use Dhii\Validation\ValidatorInterface;
use Dhii\Validation\Exception\ValidationFailedExceptionInterface;
use Dhii\Validation\AbstractCompositeValidatorBase as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractCompositeValidatorBaseTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Validation\AbstractCompositeValidatorBase';

    /**
     * Creates a new instance of the test subject.
     *
     * It will validate any boolean true value; all other values are invalid.
     *
     * @param ValidatorInterface[]|Traversable $validators The list of validators that the composite validator has.
     *
     * @since [*next-version*]
     *
     * @return TestSubject
     */
    public function createInstance($validators = null)
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->_getChildValidators($validators)
                ->__()
                ->new();

        return $mock;
    }

    /**
     * Creates a new list of validators.
     *
     * @param array|Traversable $messages A list of messages for the validators to fail with, one per validator.
     *                                    Falsy value indicates that the validator should pass.
     *
     * @since [*next-version*]
     *
     * @return Traversable The list of validators.
     */
    protected function _createValidators($messages = [])
    {
        $me = $this;
        $validators = [];
        foreach ($messages as $_idx => $_message) {
            $mock = $this->mock('Dhii\Validation\ValidatorInterface')
                    ->validate(function ($subject) use ($_message, &$me) {
                        if (!$_message) {
                            return;
                        }

                        throw $me->createValidationFailedException('Validation failed', null, null, $this, $subject, [$_message]);
                    })
                    ->new();
            $validators[] = $mock;
        }

        return new ArrayIterator($validators);
    }

    /**
     * Creates a mock that both extends a class and implements interfaces.
     *
     * @since [*next-version*]
     *
     * @param string $className      Name of the class for the mock to extend.
     * @param string $interfaceNames Names of the interfaces for the mock to implement.
     *
     * @return object The object that extends and implements the specified class and interfaces.
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

        return $this->mock($paddingClassName);
    }

    /**
     * Creates a new validation failed exception.
     *
     * @since [*next-version*]
     *
     * @return ValidationFailedExceptionInterface
     */
    public function createValidationFailedException($message = null, $code = null, $previous = null, $validator = null, $subject = null, $errors = null)
    {
        $mock = $this->mockClassAndInterfaces('Exception', ['Dhii\Validation\Exception\ValidationFailedExceptionInterface'])
                ->getValidator($this->returnValue($validator))
                ->getValidationErrors(function () use ($errors) {return $errors;})
                ->getSubject(function () use ($subject) {return $subject;})
                ->getMessage($this->returnValue($message))
                ->getCode($this->returnValue($code))
                ->getPrevious($this->returnValue($previous))
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
        // Two passing validators
        $data = [
            null,
            null,
        ];
        $subject = $this->createInstance($this->_createValidators($data));

        $subject->validate(uniqid());
        $this->assertTrue(true, 'This line cannot be reached if validation fails.');
    }

    /**
     * Tests whether invalid values do not pass validation.
     *
     * @since [*next-version*]
     */
    public function testValidateFailed()
    {
        // 3 validators, to of which pass
        $data = [
            uniqid('message-'),
            null,
            uniqid('message-'),
        ];
        $messages = array_values(array_filter($data));
        $subject = $this->createInstance($this->_createValidators($data));

        try {
            $subject->validate(uniqid());
        } catch (ValidationFailedExceptionInterface $e) {
            $errors = iterator_to_array($e->getValidationErrors(), false);
            $this->assertEquals($messages, $errors, 'Wrong set of validation errors reported', 0.0, 10, true);

            return;
        }

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
        $this->assertInstanceOf('Dhii\Validation\Exception\ValidationExceptionInterface', $exception, 'Created exception is not a valid validation exception');
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
        $this->assertInstanceOf('Dhii\Validation\Exception\ValidationFailedExceptionInterface', $exception, 'Created exception is not a valid validation failed exception');
        $this->assertEquals($message, $exception->getMessage(), 'Created exception does not have the correct message');
        $this->assertEquals($code, $exception->getCode(), 'Created exception does not have the correct code');
        $this->assertEquals($inner, $exception->getPrevious(), 'Created exception does not have the correct inner exception');
        $this->assertEquals($value, $exception->getSubject(), 'Created exception does not have the correct subject');
        $this->assertEquals($errors, $exception->getValidationErrors(), 'Created exception does not have the correct validation errors');
    }
}
