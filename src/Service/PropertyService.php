<?php

namespace App\Service;

use App\Entity\Adress;
use App\Entity\City;
use App\Entity\Person;
use App\Entity\Property;
use App\Form\AdressType;
use App\Form\CityType;
use App\Form\PropertyType;
use App\Repository\AdressRepository;
use App\Repository\CityRepository;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

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
	 * @var AdressRepository
	 */
	private $_adressRepository;
	
	/**
	 * @var CityRepository
	 */
	private $_cityRepository;
	
	/**
	 * @var ObjectManager
	 */
	private $_manager;
	
	/**
	 * @var SerializerInterface
	 */
	private $_serializer;
	
	
	/**
	 * FormService constructor.
	 *
	 * @param FormFactoryInterface $formFactory
	 * @param PropertyRepository   $propertyRepository
	 * @param AdressRepository     $adressRepository
	 * @param CityRepository       $cityRepository
	 * @param ObjectManager        $manager
	 * @param SerializerInterface  $serializer
	 */
	public function __construct(FormFactoryInterface $formFactory, PropertyRepository $propertyRepository, AdressRepository $adressRepository, CityRepository $cityRepository, ObjectManager $manager, SerializerInterface $serializer)
	{
		$this->_formFactory = $formFactory;
		$this->_propertyRepository = $propertyRepository;
		$this->_adressRepository = $adressRepository;
		$this->_cityRepository = $cityRepository;
		$this->_manager = $manager;
		$this->_serializer = $serializer;
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
		return $this->createForms($property, $adress, $city);
	}
	
	/**
	 * Fonction getPropertiesEditForm
	 * Génère les formulaires nécessaires à la modification d'un local
	 *
	 * @param Property $property
	 * @return array
	 * @throws \Exception
	 */
	public function getPropertiesEditForm(Property $property): array
	{
		if (empty($property)) {
			throw new \Exception("Le local envoyé n'est pas correct.");
		}
		
		$adress = $this->_adressRepository->find($property->getIdAdress());
		if (empty($adress)) {
			throw new \Exception("L'adresse du local est inexistante.");
		}
		
		$city = $this->_cityRepository->find($adress->getIdCity());
		if (empty($city)) {
			throw new \Exception("La ville du local est inexistante.");
		}
		
		// Création des formulaires
		return $this->createForms($property, $adress, $city);
	}
	
	/**
	 * Fonction createForms
	 * Crée les formulaires pour un local
	 *
	 * @param Property $property
	 * @param Adress   $adress
	 * @param City     $city
	 * @return array
	 */
	private function createForms(Property $property, Adress $adress, City $city): array
	{
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
	 * Fonction getPropertyCity
	 * Renvoi la ville associée à un local
	 *
	 * @param Property $property
	 * @return City
	 * @throws \Exception
	 */
	public function getPropertyCity(Property $property): City
	{
		if (empty($property)) {
			throw new \Exception("Le local envoyé n'est pas correct.");
		}
		
		return $property->getIdAdress()->getIdCity();
	}
	
	/**
	 * Fonction getAllProperties
	 * Récupère toutes les propriétés qui ne sont pas bannies
	 *
	 * @return array
	 */
	public function getAllProperties(): array
	{
		$properties = $this->_propertyRepository->findAllActive();
		
		foreach ($properties as $key => $property) {
			$adress = $this->_adressRepository->find($property['id_adress']);
			$properties[$key]['idAdress'] = $adress;
		}
		
		return $properties;
	}
	
	/**
	 * Fonction createProperty
	 * Crée un local (propriété, adresse) à partir de données
	 *
	 * @param array $data
	 * @return void
	 * @throws \Exception
	 */
	public function createProperty(array $data): void
	{
		// Récupération de la ville sélectionnée
		$city = $this->_cityRepository->find($data['city']['name']);
		if (empty($city)) {
			throw new \Exception("Aucune ville ne correspond aux valeurs renseignées.");
		}
		
		// Création de l'adresse du local
		$adress = new Adress();
		$adress
			->setStreet($data['adress']['street'])
			->setAdditionalAdress($data['adress']['additionalAdress'])
			->setZipCode($data['adress']['zipCode'])
			->setIdCity($city)
		;
		$this->_manager->persist($adress);
		$this->_manager->flush();
		
		// Mise en forme des dates
		if (!empty($data['property']['constructionDate'])) {
			$data['property']['constructionDate'] = \DateTime::createFromFormat('Y-m-d', $data['property']['constructionDate']);
		}
		if (!empty($data['property']['purchaseDate'])) {
			$data['property']['purchaseDate'] = \DateTime::createFromFormat('Y-m-d', $data['property']['purchaseDate']);
		}
		if (!empty($data['property']['saleDate'])) {
			$data['property']['saleDate'] = \DateTime::createFromFormat('Y-m-d', $data['property']['saleDate']);
		}
		
		// Création de la propriété
		$property = new Property();
		$property
			->setLabel($data['property']['label'])
			->setConstructionDate($data['property']['constructionDate'])
			->setPurchaseDate($data['property']['purchaseDate'])
			->setPurchasePrice($data['property']['purchasePrice'])
			->setSaleDate($data['property']['saleDate'])
			->setSalePrice($data['property']['salePrice'])
			->setSurfaceArea($data['property']['surfaceArea'])
			->setNbRooms($data['property']['nbRooms'])
			->setDetails($data['property']['details'])
			->setIdAdress($adress)
		;
		
		// Attribution du/des propriétaire(s)
		foreach ($data['property']['idOwner'] as $idOwner) {
			$owner = $this->_manager->getRepository(Person::class)->find($idOwner);
			if (empty($owner)) {
				throw new \Exception("Aucune personne ne correspond au(x) propriétaire(s) renseigné(s).");
			}
			
			$property->addIdOwner($owner);
		}
		
		$this->_manager->persist($property);
		$this->_manager->flush();
	}
	
	/**
	 * Fonction updateProperty
	 * Modifie un local (propriété, adresse) à partir de données
	 *
	 * @param array $data
	 * @return void
	 * @throws \Exception
	 */
	public function updateProperty(array $data): void
	{
		// Chargement du local à modifier
		$property = $this->_propertyRepository->find($data['property']['idProperty']);
		if (empty($property)) {
			throw new \Exception("Aucun local ne correspond aux valeurs renseignées.");
		}
		
		// Chargement de l'adresse du local à modifier
		$adress = $this->_adressRepository->find($data['adress']['idAdress']);
		if (empty($property)) {
			throw new \Exception("Aucun local ne correspond aux valeurs renseignées.");
		}
		
		// Chargement de la ville du local à modifier
		$city = $this->_cityRepository->find($data['city']['name']);
		if (empty($city)) {
			throw new \Exception("Aucune ville ne correspond aux valeurs renseignées.");
		}
		
		// Mise en forme des dates
		if (!empty($data['property']['constructionDate'])) {
			$data['property']['constructionDate'] = \DateTime::createFromFormat('Y-m-d', $data['property']['constructionDate']);
		}
		if (!empty($data['property']['purchaseDate'])) {
			$data['property']['purchaseDate'] = \DateTime::createFromFormat('Y-m-d', $data['property']['purchaseDate']);
		}
		if (!empty($data['property']['saleDate'])) {
			$data['property']['saleDate'] = \DateTime::createFromFormat('Y-m-d', $data['property']['saleDate']);
		}
		
		// Modification de la propriété
		$property
			->setLabel($data['property']['label'])
			->setConstructionDate($data['property']['constructionDate'])
			->setPurchaseDate($data['property']['purchaseDate'])
			->setPurchasePrice($data['property']['purchasePrice'])
			->setSaleDate($data['property']['saleDate'])
			->setSalePrice($data['property']['salePrice'])
			->setSurfaceArea($data['property']['surfaceArea'])
			->setNbRooms($data['property']['nbRooms'])
			->setDetails($data['property']['details'])
		;
		
		// Modification du/des propriétaire(s)
		$owners = $property->getIdOwner();
		foreach ($owners as $owner) {
			$property->removeIdOwner($owner);
		}
		foreach ($data['property']['idOwner'] as $idOwner) {
			$owner = $this->_manager->getRepository(Person::class)->find($idOwner);
			if (empty($owner)) {
				throw new \Exception("Aucune personne ne correspond au(x) propriétaire(s) renseigné(s).");
			}
			$property->addIdOwner($owner);
		}
		
		$this->_manager->persist($property);
		
		// Modification de l'adresse du local
		$adress
			->setStreet($data['adress']['street'])
			->setAdditionalAdress($data['adress']['additionalAdress'])
			->setZipCode($data['adress']['zipCode'])
			->setIdCity($city)
		;
		$this->_manager->persist($adress);
		
		$this->_manager->flush();
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
		if (empty($property)) {
			throw new \Exception("Le local renseigné n'est pas correct, il ne peut être supprimé.");
		}
		
		$property->setBanished(new \DateTime());
		$this->_manager->persist($property);
		$this->_manager->flush();
	}
	
}