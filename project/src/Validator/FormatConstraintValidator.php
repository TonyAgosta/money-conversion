<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FormatConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$value) {
            return;
        }

        if (!preg_match('/^\d+p \d+s \d+d$/', $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
