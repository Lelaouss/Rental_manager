<?php

namespace App\DataFixtures;

use App\Entity\Adress;
use App\Entity\City;
use App\Entity\Person;
use App\Entity\Property;
use App\Entity\User;
use App\Entity\UserType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures permet la génération de jeux de fausses données de test
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
	private $_manager;
	private $_faker;
	private $_encoder;
	
	
	public function __construct(ObjectManager $manager, UserPasswordEncoderInterface $encoder)
	{
		// Import de l'entity manager
		$this->_manager = $manager;
		
		// Import de la lib Faker
		$this->_faker = Factory::create('fr-FR');
		
		// Import de la lib d'encodage des passwords
		$this->_encoder = $encoder;
	}
	
	public function load(ObjectManager $manager)
    {
    	// Jeu de données obligatoire pour le fonctionnement
    	$this->loadData();
    	
    	// Partie utilisateurs|personnes
    	$this->userPart();
    	
    	// Partie locaux|adresses
		$this->createProperties(6);
    }
	
    
	/**
	 * Chargement des fichiers SQL présent dans le dossier /SQL
	 * Insertion de jeu de vrais données en BDD
	 */
	private function loadData()
	{
		// Librairie pour charger les fichiers
		$finder = new Finder();
		$finder->in(__DIR__ . '/SQL');
		$finder->name('*.sql');
		$finder->files();
		$finder->sortByName();
		
		foreach( $finder as $file ){
			print "Importing: {$file->getBasename()} " . PHP_EOL;
			
			$sql = $file->getContents();
			$this->_manager->getConnection()->exec($sql);
			$this->_manager->flush();
		}
	}
 
	
	/**
	 * Fonction qui gère la partie utilisateur
	 */
	private function userPart()
	{
		$this->createPersons();
		$this->createUser();
	}
	
	/**
	 * Fonction de génération de plusieurs personnes
	 */
	private function createPersons()
	{
		$person = new Person();
		$person
			->setFirstName('John')
			->setLastName('Doe')
			->setMiddleName('Mike Toto')
			->setCivility(1)
			->setBirthday(new \DateTime('1990-07-03'))
			->setMail('john.doe@test.fr')
			->setCellPhone('0102030405')
			->setFamilySituation(0)
			->setOccupation("Testeur de plateforme");
		$this->_manager->persist($person);
		$this->_manager->flush();
		
		for ($i=0; $i<20; $i++) {
			$this->createPerson();
		}
	}
	
	/**
	 * Fonction de génération d'un utilisateur
	 */
	private function createUser()
	{
		$userType = $this->_manager->getRepository(UserType::class)->findOneBy(['label' => 'Admin']);
		$person = $this->_manager->getRepository(Person::class)->findOneBy(['firstName' => 'John', 'lastName' => 'Doe']);
		
		$user = new User();
		$hash = $this->_encoder->encodePassword($user, 'manager*');
		$user
			->setIdPerson($person)
			->setIdUserType($userType)
			->setLogin('testeur')
			->setPassword($hash);
		$this->_manager->persist($user);
		
		$this->_manager->flush();
	}
	
	private function propertiesPart($count)
	{
		$this->createProperties($count);
	}
	
	/**
	 * Fonction de création d'adresse
	 * @return Adress
	 */
	private function createAdress(): Adress
	{
		$city = $this->_manager->getRepository(City::class)->findOneBy(['idCounty' => $this->_faker->numberBetween('1', '101')]);
		$adress = new Adress();
		$adress
			->setStreet($this->_faker->streetAddress)
			->setAdditionalAdress($this->_faker->streetAddress)
			->setZipCode($city->getZipCode())
			->setIdCity($city);
		
		$this->_manager->persist($adress);
		$this->_manager->flush();
		
		return $adress;
	}
	
	/**
	 * Fonction de génération d'une personne
	 */
	private function createPerson()
	{
		$person = new Person();
		$person
			->setFirstName($this->_faker->firstNameMale)
			->setLastName($this->_faker->lastName)
			->setCivility($this->_faker->numberBetween(0, 1))
			->setMail($this->_faker->freeEmail)
			->setCellPhone($this->_faker->phoneNumber)
			->setFamilySituation($this->_faker->numberBetween('0', '3'))
			->setOccupation($this->_faker->jobTitle);
		$this->_manager->persist($person);
		$this->_manager->flush();
		
		return $person;
	}
	
	/**
	 * Fonction de création de locaux
	 * Crée autant de propriétés que demandé
	 * @param $count
	 */
	private function createProperties($count)
	{
		for ($i=0; $i<$count; $i++) {
			$property = new Property();
			$property
				->setLabel($this->_faker->streetAddress)
				->setIdAdress($this->createAdress())
				->addIdOwner($this->createPerson());
			
			$this->_manager->persist($property);
		}
		
		$this->_manager->flush();
	}
}
