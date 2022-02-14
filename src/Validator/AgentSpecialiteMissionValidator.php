<?php

namespace App\Validator;

use App\Entity\Agent;
use App\Entity\Mission;
use App\Entity\Planque;
use App\Entity\Specialite;
use App\Repository\CibleRepository;
use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AgentSpecialiteMissionValidator extends ConstraintValidator
{
    protected $specialiteId;

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();
        $fields = (object)$request->request->get('mission');
        $this->specialiteId = $fields->specialite;
    }


    public function validate($agents, Constraint $constraint)
    {
        /** @var ArrayCollection $agents */
        if (!$agents->isEmpty() && !empty($this->specialiteId)) {
            // by default, we expect that all specialites are not equals
            $allSpecialitesEquals = false;


            foreach ($agents->toArray() as $agent) {
                /** @var Agent $agent */
                $agent->getSpecialites();
                $specialites = $agent->getSpecialites();

                foreach ($specialites->toArray() as $specialite) {
                    /** @var ArrayCollection $specialite */
                    if($specialite->getId() == $this->specialiteId) {
                        $allSpecialitesEquals = true;
                    }
                }
            }

            // if at least one agent has not the same specialite than mission
            if ($allSpecialitesEquals == false) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
