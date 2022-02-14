<?php

namespace App\Validator;


use App\Entity\Mission;
use App\Entity\Planque;
use App\Repository\CibleRepository;
use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MissionPlanqueMissionNationalityValidator extends ConstraintValidator
{
    protected $nationaliteId;

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();
        $fields = (object)$request->request->get('mission');
        $this->nationaliteId = $fields->nationalite;
    }

    public function validate($planques, Constraint $constraint)
    {
        /** @var ArrayCollection $planques */
        if (!$planques->isEmpty() && !empty($this->nationaliteId)) {
            // by default, we expect that all nationalites are equals
            $allNationaliteEquals = true;

            // check if it's true for all contact nationalite
            foreach ($planques->toArray() as $planque) {
                /** @var Planque $planque */
                // if planque's nationelite is not equal to mission nationalite, switch to false
                if ($this->nationaliteId != $planque->getNationalite()->getId()) {
                    $allNationaliteEquals = false;
                }
            }

            // if at least one planque has not the same nationalite than mission
            if ($allNationaliteEquals === false) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
