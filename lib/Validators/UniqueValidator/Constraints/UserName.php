<?php

namespace Lib\Validators\UniqueValidator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserName extends Constraint {

    public $message = "The email entered already exists.";

    public $entityManager;
    public $entityClass;
}
