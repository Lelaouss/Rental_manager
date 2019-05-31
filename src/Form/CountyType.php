<?php

namespace App\Form;

use App\Entity\County;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountyType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, $this->getConfiguration(
            	"Département :",
				"",
				[
					'class' => County::class,
					'query_builder' => function (EntityRepository $entityRepository) {
            			return $entityRepository->createQueryBuilder('c')
							->where('c.active = 1')
							->orderBy('c.name', 'ASC');
					},
					'choice_label' => 'name'
				]
			))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => County::class,
        ]);
    }
}
