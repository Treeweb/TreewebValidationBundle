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
        $now = new \DateTime();
        $birthDate = null;

        if (!empty($value)) {

            if(is_string($value)) {

                $birthDate = new \DateTime($value);

            } else if($value instanceof \DateTime){

                $birthDate = $value;

            }else{

                throw new ValidatorException("Value can be a string or \\DatetimeObject");
            }

        } else {
            throw new ValidatorException("Value can't be empty");
        }

        /**
         * @var $dateInterval \DateInterval
         */
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
}
