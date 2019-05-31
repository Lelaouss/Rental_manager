<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('idCity', HiddenType::class)
			->add('name', ChoiceType::class, $this->getConfiguration(
            	"Ville :",
				'',
				[
					'disabled' => true,
					'required' => true,
					'choices' => []
				]
			))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
