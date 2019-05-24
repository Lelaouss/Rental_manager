<?php

namespace App\DataFixtures;

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
		$this->createUserType();
		$this->createPerson();
		$this->createUser();
    }
	
	
	/**
	 * Fonction de génération des types utilisateur
	 */
	private function createUserType()
	{
		$userType = new UserType();
		$userType->setLabel('Admin');
		$this->_manager->persist($userType);
		$userType = new UserType();
		$userType->setLabel('Visitor');
		$this->_manager->persist($userType);
		
		$this->_manager->flush();
	}
	
	/**
	 * Fonction de génération d'une personne
	 */
	private function createPerson()
	{
		$person = new Person();
		$person
			->setFirstName('Léonce')
			->setLastName('Piron')
			->setMiddleName('Eyram Daniel')
			->setCivility(1)
			->setBirthday(new \DateTime('1986-02-06'))
			->setMail('leonce.piron@hotmail.fr')
			->setCellPhone('0630613401')
			->setFamilySituation(0)
			->setOccupation("Développeur web");
		$this->_manager->persist($person);
		
		for ($i=0; $i<20; $i++) {
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
			
		}
		$this->_manager->flush();
	}
	
	/**
	 * Fonction de génération d'un utilisateur
	 */
	private function createUser()
	{
		$userType = $this->_manager->getRepository(UserType::class)->findOneBy(['label' => 'Admin']);
		$person = $this->_manager->getRepository(Person::class)->findOneBy(['firstName' => 'Léonce', 'lastName' => 'Piron']);
		
		$user = new User();
		$hash = $this->_encoder->encodePassword($user, '1234');
		$user
			->setIdPerson($person)
			->setIdUserType($userType)
			->setLogin('lelaouss')
			->setPassword($hash);
		$this->_manager->persist($user);
		
		$this->_manager->flush();
	}
	
}
