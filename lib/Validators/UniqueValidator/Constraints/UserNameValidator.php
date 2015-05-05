<?php

namespace Lib\Validators\UniqueValidator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UserNameValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint) {
        if (!isset($constraint->entityClass)) {
          throw new \Exception('Missing entityClass. Please define it as the current class you are using.');
        }

        if (function_exists($constraint->entityManager)
            && is_callable($constraint->entityManager)) {

            $userName = call_user_func($constraint->entityManager)
                  ->getRepository($constraint->entityClass)
                  ->findBy(array('user_name' => $value));

            if (!empty($userName)) {
              $this->context->buildViolation($constraint->message)
                            ->addViolation();
            }
        }
    }
}
