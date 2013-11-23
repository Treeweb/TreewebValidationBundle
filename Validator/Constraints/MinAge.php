<?php
/**
 * (c) Treeweb <developer@treeweb.it>
 *
 * User: ruben
 * Date: 16/11/13
 * Time: 00:14
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Treeweb\Bundle\TreewebValidationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MinAge extends Constraint
{
    public $message = 'You are only {{ age }} years old. You must be {{ minAge }} years old or over.';
    public $minAge = 18;
}
