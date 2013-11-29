<?php
/**
 * (c) Treeweb <developer@treeweb.it>
 *
 * User: ruben
 * Date: 16/11/13
 * Time: 00:17
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Treeweb\Bundle\TreewebValidationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ValidatorException;

class MinAgeValidator extends ConstraintValidator
{

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $this->isSupportedFormat($value);

        $birthDate = $this->transformToDateTime($value);


        $now = new \DateTime();
        $dateInterval = $now->diff($birthDate);
        $age = (string)$dateInterval->y;

        if($age < $constraint->minAge){
            $this->context->addViolation(
                $constraint->message,
                array(
                    '{{ minAge }}' => $constraint->minAge,
                    '{{ age }}' => $age
                )
            );
        }

    }

    /**
     *
     * Check value is in a supported format
     *
     * @param $value
     *
     * @return bool
     * @throws \Symfony\Component\Validator\Exception\ValidatorException
     */
    protected function isSupportedFormat($value)
    {
        if (empty($value)) {
            throw new ValidatorException("Value can't be empty");
        }

        if(is_string($value) || $value instanceof \DateTime) {
            return true;
        } else {
            throw new ValidatorException("Value can be a string or \\DatetimeObject");
        }

        return true;
    }

    /**
     * Tranform given value into \DateTime object
     *
     * @param $value
     *
     * @return \DateTime
     */
    protected function transformToDateTime($value)
    {
        if(is_string($value)) {
            return new \DateTime($value);
        }

        if($value instanceof \DateTime){
            return $value;
        }
    }
}
