<?php

namespace App\Validator;

use App\Entity\Contact;
use App\Entity\Mission;
use App\Repository\CibleRepository;
use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MissionContactMissionNationalityValidator extends ConstraintValidator
{
    protected $nationaliteId;

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();
        $fields = (object)$request->request->get('mission');
        $this->nationaliteId = $fields->nationalite;
    }

    public function validate($contacts, Constraint $constraint)
    {
        /** @var ArrayCollection $contacts */
        if (!$contacts->isEmpty() && !empty($this->nationaliteId)) {
            // by default, we expect that all nationalites are equals
            $allNationaliteEquals = true;

            // check if it's true for all contact nationality
            foreach ($contacts->toArray() as $contact) {
                /** @var Contact $contact */
                // if contact's nationelity is not equal to mission nationalite, switch to false
                if ($this->nationaliteId != $contact->getNationalite()->getId()) {
                    $allNationaliteEquals = false;
                }
             }

            // if at least one contact has not the same nationalite than mission
            if ($allNationaliteEquals === false) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}