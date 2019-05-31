<?php

namespace App\Service;

use App\Entity\Person;
use App\Entity\User;
use App\Form\PersonRegistrationType;
use App\Form\RegistrationType;
use App\Repository\UserTypeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
	const DEFAULT_USER_TYPE = "Visitor";
	
	/**
	 * @var UserTypeRepository
	 */
	private $_userTypeRepository;
	
	/**
	 * @var UserPasswordEncoderInterface
	 */
	private $_encoder;
	
	/**
	 * @var FormFactoryInterface
	 */
	private $_formFactory;
	
	/**
	 * @var ObjectManager
	 */
	private $_manager;
	
	
	/**
	 * UserService constructor.
	 * @param UserTypeRepository           $userTypeRepository
	 * @param UserPasswordEncoderInterface $encoder
	 * @param FormFactoryInterface         $formFactory
	 * @param ObjectManager                $manager
	 */
	public function __construct(UserTypeRepository $userTypeRepository, UserPasswordEncoderInterface $encoder, FormFactoryInterface $formFactory, ObjectManager $manager)
	{
		$this->_userTypeRepository = $userTypeRepository;
		$this->_encoder = $encoder;
		$this->_formFactory = $formFactory;
		$this->_manager = $manager;
	}
	
	
	/**
	 * Fonction getUserForms
	 * Génère les formulaires nécessaires à un utilisateur
	 *
	 * @return array
	 */
	public function getUserForms(): array
	{
		// Personne
		$person = new Person();
		// Utilisateur
		$user = new User();
		
		// Création des formulaires
		$formPerson = $this->_formFactory->createBuilder(PersonRegistrationType::class, $person)->getForm();
		$formUser = $this->_formFactory->createBuilder(RegistrationType::class, $user)->getForm();
		
		return [
			'person' => $person,
			'user' => $user,
			'form_person' => $formPerson,
			'form_user' => $formUser
		];
	}
	
	/**
	 * Fonction setNewUserConstraints
	 * Permet de paramétrer toutes les contraintes obligatoires à un nouvel utilisateur lors de création
	 *
	 * @param User   $user
	 * @param Person $person
	 * @return void
	 * @throws \Exception
	 */
	public function setNewUserConstraints(User $user, Person $person): void
	{
		// Encodage du mot de passe renseigné par le nouvel utilisateur
		$hash = $this->_encoder->encodePassword($user, $user->getPassword());
		$user->setPassword($hash);
		
		// Renseignement du type utilisateur par défaut
		$userType = $this->_userTypeRepository->findOneActiveByName(self::DEFAULT_USER_TYPE);
		if (empty($userType)) {
			throw new \Exception("Le type utilisateur par défaut n'existe pas en BDD.");
		}
		$user->setIdUserType($userType);
		
		// Renseignement de la personne lié à l'utilisateur
		$user->setIdPerson($person);
		
		// Passage de l'utilisateur en non actif
		$user->setBanished(new \DateTime());
	}
	
	/**
	 * Fonction saveObjectDB
	 * Persist et flush l'objet en BDD
	 *
	 * @param $object
	 * @return void
	 */
	public function saveObjectDB($object): void
	{
		$this->_manager->persist($object);
		$this->_manager->flush();
	}
	
}