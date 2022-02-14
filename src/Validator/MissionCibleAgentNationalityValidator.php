<?php

namespace App\Validator;

use App\Entity\Agent;
use App\Entity\Cible;
use App\Repository\CibleRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\Common\Collections\ArrayCollection;

class MissionCibleAgentNationalityValidator extends ConstraintValidator
{
    protected $cibles;

    public function __construct(RequestStack $requestStack, CibleRepository $cibleRepository)
    {
        $request = $requestStack->getCurrentRequest();
        $fields = (object) $request->request->get('mission');
        $this->cibles = $cibleRepository->findBy(['id' => $fields->cibles]);
    }

    public function validate($agents, Constraint $constraint)
    {
        /** @var ArrayCollection $agents */
        if (!$agents->isEmpty() && is_array($this->cibles)) {
            // transform $agents array in Nationalite id array
            $agentNationaliteIds = array_map(function (Agent $agent) {
                return $agent->getNationalite()->getId();
            }, $agents->toArray());

            // transform $this->cibles array in Nationalite id array
            $cibleNationaliteIds = array_map(function (Cible $cible) {
                return $cible->getNationalite()->getId();
            }, $this->cibles);

            // keep only y ids in both array
            $badNationaliteIds = array_intersect($agentNationaliteIds, $cibleNationaliteIds);

            // if has at least 1 item in badNationaliteIds array, show violation
            if (count($badNationaliteIds) > 0) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
