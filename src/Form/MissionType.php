<?php

namespace App\Form;

use App\Entity\Administrateur;
use App\Entity\Agent;
use App\Entity\Cible;
use App\Entity\Contact;
use App\Entity\Mission;
use App\Entity\Nationalite;
use App\Entity\Planque;
use App\Entity\Specialite;
use App\Entity\StatutMission;
use App\Entity\TypeMission;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType


{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true])
            ->add('description', TextareaType::class, [
                'required' => true])
            ->add('nom_code', TextType::class, [
                'required' => true])
            ->add('date_debut', DateType::class, [
                'required' => true])
            ->add('date_fin', DateType::class, [
                'required' => true])
            ->add('nationalite', EntityType::class, [
                'class' => Nationalite::class,
                'choice_label' => 'pays',
                'required' => true,
            ])
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'nom',
                'required' => true,
            ])
            ->add('statut', EntityType::class, [
                'class' => StatutMission::class,
                'choice_label' => 'nom',
                'required' => true,
            ])
            ->add('type', EntityType::class, [
                'class' => TypeMission::class,
                'choice_label' => 'nom',
                'required' => true,
            ])

            
            ->add('agents', EntityType::class, [
                'class' => Agent::class,
                'choice_label' => function (Agent $agent) {
                   
                      
                    return $agent->getPrenom() . ' ' . $agent->getNom() . ' (' . $agent->getNationalite()->getNationalite() . ')'. ' Specialité : ' .$agent->getSpecialites()[0] ;
                },
                'required' => true,
                'multiple' => true
            ])
            ->add('planques', EntityType::class, [
                'class' => Planque::class,
                'choice_label' => function (Planque $planque) {
                    return $planque->getNomCode() . ' (' . $planque->getNationalite()->getNationalite() . ')';
                },
                'required' => true,
                'multiple' => true
            ])
            ->add('contacts', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => function (Contact $contact) {
                    return $contact->getPrenom() . " " . $contact->getNom() . '(' . $contact->getNationalite()->getNationalite() . ')';
                },
                'required' => true,
                'multiple' => true
            ])
            ->add('cibles', EntityType::class, [
                'class' => Cible::class,
                'choice_label' => function (Cible $cible) {
                    return $cible->getPrenom() . " " . $cible->getNom() . ' (' . $cible->getNationalite()->getNationalite() . ')';
                },
                'required' => true,
                'multiple' => true
            ])

            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
