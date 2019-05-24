<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, $this->getConfiguration("Identification du local :"))
            ->add('constructionDate', DateType::class, $this->getConfiguration(
            	"Date de construction :",
				"",
				[
					'widget' => "single_text",
					'required' => false
				]
			))
            ->add('purchaseDate', DateType::class, $this->getConfiguration(
            	"Date d'achat :",
				"",
				[
					'widget' => "single_text",
					'required' => false
				]
			))
            ->add('purchasePrice', MoneyType::class, $this->getConfiguration("Prix d'achat :","", ['required' => false]))
            ->add('saleDate', DateType::class, $this->getConfiguration(
				"Date de vente :",
				"",
				[
					'widget' => "single_text",
					'required' => false
				]
			))
            ->add('salePrice', MoneyType::class, $this->getConfiguration("Prix de vente :", "", ['required' => false]))
            ->add('surfaceArea', IntegerType::class, $this->getConfiguration("Surface habitable :", "", ['required' => false]))
            ->add('nbRooms', ChoiceType::class, $this->getConfiguration(
				"Nombre de pièces :",
				"",
				[
					'choices' => [
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5
					],
					'required' => false
				]
			))
            ->add('details', TextareaType::class, $this->getConfiguration("Informations complémentaires :", "", ['required' => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
