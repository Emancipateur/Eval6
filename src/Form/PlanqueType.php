<?php

namespace App\Form;

use App\Entity\Nationalite;
use App\Entity\Planque;
use App\Entity\TypePlanque;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_code', TextType::class, [
                'required' => true])
            ->add('adresse', TextType::class, [
                'required' => true])
            ->add('type', EntityType::class, [
                'class' => TypePlanque::class,
                'choice_label' => 'nom',
                'required' => true
            ])
            ->add('nationalite', EntityType::class, [
                'class' => Nationalite::class,
                'choice_label' => 'pays',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planque::class,
        ]);
    }
}
