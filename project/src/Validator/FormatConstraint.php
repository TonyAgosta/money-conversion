<?php

namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FormatConstraint extends Constraint
{
    public string $message = "Il formato deve essere 'Xp Ys Zd' (esempio: '5p 10s 3d').";

}
