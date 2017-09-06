<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;
use Dhii\Validation\Exception\ValidationFailedException as TestSubject;

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
     * Tests that passed data can be correctly retrieved from instances.
     *
     * @since 0.1
     */
    public function testAttributes()
    {
        $value = 'banana';
        $errors = array('orange', 'pineapple');

        $subject = $this->createInstance(null, null, null, $value, $errors);
        $this->assertEquals($value, $subject->getSubject(), 'Validation subject could not be correctly retrieved');
        $this->assertEquals($errors, $subject->getValidationErrors(), 'Validation errors could not be correctly retrieved');
    }
}
