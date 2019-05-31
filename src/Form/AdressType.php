<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('idAdress', HiddenType::class)
			->add('street', TextType::class, $this->getConfiguration("Adresse :"))
            ->add('additionalAdress', TextareaType::class, $this->getConfiguration("Complément d'adresse :", "", ['required' => false]))
            ->add('zipCode', TextType::class, $this->getConfiguration(
            	"Code postal :",
				"",
				[
					'required' => true,
					'attr' => [
						'data-search-path' => '/city/search'
					]
				]
			))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
