<?php

namespace Dhii\Validation\FuncTest;

use Xpmock\TestCase;
use Dhii\Validation\Exception\ValidationException;

/**
 * Tests {@see \Dhii\Validation\Exception\ValidationException}.
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
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Validation\\Exception\\ValidationException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since 0.1
     *
     * @return ValidationException
     */
    public function createInstance($message = '')
    {
        $me = $this;
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->new($message);

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
}
