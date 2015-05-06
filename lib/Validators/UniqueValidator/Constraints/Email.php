<?php

namespace Validators\UniqueValidator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Email extends Constraint {

    public $message = "The email entered already exists.";

    public $entityManager;
    public $entityClass;
}
