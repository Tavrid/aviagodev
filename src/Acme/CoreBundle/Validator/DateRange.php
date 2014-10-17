<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateRange
 *
 * @author ablyakim
 */

namespace Acme\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class DateRange extends Constraint {

    public $minMessage = 'This date should be greater than {{ limit }}.';
    public $maxMessage = 'This date should be less than {{ limit }}.';
    public $invalidMessage = 'This value should be a valid date.';
    public $min;
    public $max;

    public function __construct($options = null) {
        parent::__construct($options);

        if (null === $this->min && null === $this->max) {
            throw new MissingOptionsException('Either option "min" or "max" must be given for constraint ' . __CLASS__, array('min', 'max'));
        }

        if (null !== $this->min) {
            $this->min = new \DateTime($this->min);
        }

        if (null !== $this->max) {
            $this->max = new \DateTime($this->max);
        }
    }

}
