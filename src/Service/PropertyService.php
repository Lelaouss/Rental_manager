<?php

namespace App\Service;

/* TODO ajouter des try catch pour contrôler les données renseignées et gérer les erreurs */
use App\Entity\Adress;
use App\Entity\City;
use App\Entity\Property;
use App\Form\AdressType;
use App\Form\CityType;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class PropertyService
 * @package App\Service
 */
class PropertyService
{
	/**
	 * @var FormFactoryInterface
	 */
	private $_formFactory;
	
	/**
	 * @var PropertyRepository
	 */
	private $_propertyRepository;
	
	/**
	 * @var ObjectManager
	 */
	private $_manager;
	
	
	/**
	 * FormService constructor.
	 *
	 * @param FormFactoryInterface $formFactory
	 * @param PropertyRepository   $propertyRepository
	 * @param ObjectManager        $manager
	 */
	public function __construct(FormFactoryInterface $formFactory, PropertyRepository $propertyRepository, ObjectManager $manager)
	{
		$this->_formFactory = $formFactory;
		$this->_propertyRepository = $propertyRepository;
		$this->_manager = $manager;
	}
	
	
	/**
	 * Fonction getPropertiesForms
	 * Génère les formulaires nécessaires à un local
	 *
	 * @return array
	 */
	public function getPropertiesForms(): array
	{
		// Propriété
		$property = new Property();
		// Adresse
		$adress = new Adress();
		// Ville
		$city = new City();
		
		// Création des formulaires
		$formProperty = $this->_formFactory->createBuilder(PropertyType::class, $property)->getForm();
		$formAdress = $this->_formFactory->createBuilder(AdressType::class, $adress)->getForm();
		$formCity = $this->_formFactory->createBuilder(CityType::class, $city)->getForm();
		
		return [
			'form_property' => $formProperty,
			'form_adress' => $formAdress,
			'form_city' => $formCity
		];
	}
	
	/**
	 * Fonction getAllProperties
	 * Récupère toutes les propriétés qui ne sont pas bannies
	 *
	 * @return array
	 */
	public function getAllProperties(): array
	{
		return $this->_propertyRepository->findAllActive();
	}
	
	/**
	 * Fonction banProperty
	 * Supprime un local par rapport à son ID
	 *
	 * @param int $idProperty
	 * @return void
	 * @throws \Exception
	 */
	public function banProperty(int $idProperty): void
	{
		$property = $this->_propertyRepository->find($idProperty);
		$property->setBanished(new \DateTime());
		$this->_manager->persist($property);
		$this->_manager->flush();
	}
	
}