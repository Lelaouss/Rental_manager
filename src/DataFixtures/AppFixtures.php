<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Person;
use App\Entity\User;
use App\Entity\UserType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
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
		$this->createCountries();
		$this->createUser();
    }
    
    
    /**
	 * Fonction de génération des pays
	 */
	private function createCountries()
	{
		for ($i = 0; $i < 30; $i++) {
			$country = new Country();
			$country
				->setName($this->_faker->country)
				->setActive(1);
			$this->_manager->persist($country);
		}
		
		$this->_manager->flush();
	}
	
	/**
	 * Fonction de génération des user_type
	 */
	private function createUserType(): UserType
	{
		$userType = new UserType();
		$userType->setLabel('Admin');
		$this->_manager->persist($userType);
		$userType = new UserType();
		$userType->setLabel('Visitor');
		$this->_manager->persist($userType);
		
		$this->_manager->flush();
		
		return $userType;
	}
	
	/**
	 * Fonction de génération d'une personne
	 */
	private function createPerson(): Person
	{
		$person = new Person();
		$person
			->setFirstName($this->_faker->firstNameMale)
			->setLastName($this->_faker->lastName)
			->setCivility(1)
			->setMail($this->_faker->freeEmail);
		$this->_manager->persist($person);
		
		$this->_manager->flush();
		
		return $person;
	}
	
	private function createUser()
	{
		$userType = $this->createUserType();
		$person = $this->createPerson();
		
		$user = new User();
		$hash = $this->_encoder->encodePassword($user, '1234');
		$user
			->setIdPerson($person)
			->setIdUserType($userType)
			->setLogin('lelaouss')
			->setPassword($hash);
		$this->_manager->persist($user);
		
//		dd($user);
		
		$this->_manager->flush();
	}
	
}
