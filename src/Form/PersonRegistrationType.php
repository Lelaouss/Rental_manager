<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonRegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('civility', ChoiceType::class, [
				'choices' => [
					Person::GENDER_FEMALE => "0",
					Person::GENDER_MALE => "1"
				],
				'label' => false
			])
			->add('firstName', TextType::class, $this->getConfiguration(false, "Prénom"))
			->add('lastName', TextType::class, $this->getConfiguration(false, "Nom"))
            ->add('mail', EmailType::class, $this->getConfiguration(false, "Adresse mail"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
