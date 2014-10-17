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
use Symfony\Component\Validator\ConstraintValidator;

class DateRangeValidator extends ConstraintValidator {

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint) {
        if (null === $value) {
            return;
        }

        if (!($value instanceof \DateTime)) {
            $this->context->addViolation($constraint->invalidMessage, array(
                '{{ value }}' => $this->formatDate($value),
            ));

            return;
        }

        if (null !== $constraint->max && $value > $constraint->max) {
            $this->context->addViolation($constraint->maxMessage, array(
                '{{ value }}' => $this->formatDate($value),
                '{{ limit }}' => $this->formatDate($constraint->max),
            ));
        }

        if (null !== $constraint->min && $value < $constraint->min) {
            $this->context->addViolation($constraint->minMessage, array(
                '{{ value }}' => $this->formatDate($value),
                '{{ limit }}' => $this->formatDate($constraint->min),
            ));
        }
    }

    protected function formatDate(\DateTime $date) {
        return $date->format('d.m.Y');
       
    }

    /**
     * @param  \IntlDateFormatter $formatter
     * @param  \Datetime          $date
     * @return string
     */
    protected function processDate(\IntlDateFormatter $formatter, \Datetime $date) {
        return $formatter->format((int) $date->format('U'));
    }

}
