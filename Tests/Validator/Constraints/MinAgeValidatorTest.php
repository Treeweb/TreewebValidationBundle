<?php
/**
 * (c) Treeweb <developer@treeweb.it>
 *
 * User: ruben
 * Date: 16/11/13
 * Time: 00:33
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Treeweb\Bundle\TreewebValidationBundle\Tests\Validator\Constraints;

use PHPUnit_Framework_TestCase;
use Treeweb\Bundle\TreewebValidationBundle\Validator\Constraints\MinAge;
use Treeweb\Bundle\TreewebValidationBundle\Validator\Constraints\MinAgeValidator;

class MinAgeValidatorTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new MinAgeValidator();

        $this->reflectedValidator = new \ReflectionClass($this->validator);

        $this->validator->initialize($this->context);


        $this->context->expects($this->any())
            ->method('getClassName')
            ->will($this->returnValue(__CLASS__));
    }

    protected function tearDown()
    {
        $this->context = null;
        $this->validator = null;
        $this->reflectedValidator = null;
    }


    public function testItalianDatePassedValueLikeStringIsNotValid()
    {

        $constraint  = new MinAge(array(
            'message' => 'my message'
        ));

        $oneYearBeforeNow = new \DateTime();
        $oneYearBeforeNow->sub(new \DateInterval('P1Y'));
        $oneYearBeforeNowString = $oneYearBeforeNow->format('d-m-Y');

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('my message', array(
                '{{ minAge }}' => '18',
                '{{ age }}' => '1'
            ));

        $this->validator->validate($oneYearBeforeNowString, $constraint);
    }

    public function testItalianDatePassedValueLikeStringIsValid()
    {

        $constraint  = new MinAge();

        $this->context->expects($this->never())
            ->method('addViolation');


        $this->validator->validate('7-10-1986', $constraint);
    }

    public function testStandardDatePassedValueLikeStringIsNotValid()
    {

        $constraint  = new MinAge(array(
            'message' => 'my message'
        ));

        $seventeenYearBeforeNow = new \DateTime();
        $seventeenYearBeforeNow->sub(new \DateInterval('P17Y'));
        $seventeenYearBeforeNowBeforeNowString = $seventeenYearBeforeNow->format('Y-m-d');

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('my message', array(
                '{{ minAge }}' => '18',
                '{{ age }}' => '17'
            ));

        $this->validator->validate($seventeenYearBeforeNowBeforeNowString, $constraint);
    }

    public function testStandardDatePassedValueLikeStringIsValid()
    {

        $constraint  = new MinAge();

        $this->context->expects($this->never())
            ->method('addViolation');


        $this->validator->validate('1987-08-13', $constraint);
    }

    public function testStandardDatePassedValueLikeDateTimeIsNotValid()
    {

        $constraint  = new MinAge(array(
            'message' => 'my message',
            'minAge'  => '21'
        ));

        $nineteenYearBeforeNow = new \DateTime();
        $nineteenYearBeforeNow->sub(new \DateInterval('P19Y'));


        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('my message', array(
                '{{ minAge }}' => '21',
                '{{ age }}' => '19'
            ));

        $this->validator->validate($nineteenYearBeforeNow, $constraint);
    }

    public function testStandardDatePassedValueLikeDateTimeIsValid()
    {

        $constraint  = new MinAge();

        $this->context->expects($this->never())
            ->method('addViolation');


        $this->validator->validate(new \DateTime('1987-08-13'), $constraint);
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\ValidatorException
     */
    public function testRaiseExceptionIfPassedValueIsInvalidFormat()
    {
        $constraint  = new MinAge();
        $this->validator->validate(3, $constraint);
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\ValidatorException
     */
    public function testSupportedFormat()
    {
        $supportedFormat = $this->getMethod('isSupportedFormat');
        $supportedFormat->invokeArgs($this->validator, array(
               000
            ));
    }


    public function testTransformToDateTime()
    {
        $supportedFormat = $this->getMethod('transformToDateTime');
        $actual = $supportedFormat->invokeArgs($this->validator, array(
                '2013-08-13'
            ));
        $this->assertTrue($actual instanceof \DateTime);
    }

    // Helper function to test protected methods
    protected function getMethod($name)
    {
        $method = $this->reflectedValidator->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
