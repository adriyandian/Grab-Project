<?php

namespace Validators\UniqueValidator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint) {
        if (!isset($constraint->entityClass)) {
          throw new \Exception('Missing entityClass. Please define it as the current class you are using.');
        }

        if (function_exists($constraint->entityManager)
            && is_callable($constraint->entityManager)) {

            $email = call_user_func($constraint->entityManager)
                  ->getRepository($constraint->entityClass)
                  ->findBy(array('email' => $value));

            if (!empty($email)) {
              $this->context->buildViolation($constraint->message)
                            ->addViolation();
            }
        }
    }
}
