<?php

namespace App\Service;

use App\Entity\Person;
use App\Entity\User;
use App\Repository\UserTypeRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/* TODO ajouter des try catch pour contrôler les données renseignées et gérer les erreurs */
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
	 * UserService constructor.
	 * @param UserTypeRepository           $userTypeRepository
	 * @param UserPasswordEncoderInterface $encoder
	 */
	public function __construct(UserTypeRepository $userTypeRepository, UserPasswordEncoderInterface $encoder)
	{
		$this->_userTypeRepository = $userTypeRepository;
		$this->_encoder = $encoder;
	}
	
	public function setNewUserConstraints(User $user, Person $person)
	{
		// Encodage du mot de passe renseigné par le nouvel utilisateur
		$this->setUserHashPassword($user);
		
		// Renseignement du type utilisateur par défaut
		$this->setDefaultUserType($user);
		
		// Renseignement de la personne lié à l'utilisateur
		$this->setPersonLinkedUser($person, $user);
		
		// Passage de l'utilisateur en non actif
		$this->setNewUserUnactive($user);
	}
	
	/**
	 * Fonction setUserHashPassword
	 * Hash le mot passe renseigné et le renseigne sur l'utilisateur passé
	 * @param User $user
	 */
	private function setUserHashPassword(User $user)
	{
		$hash = $this->_encoder->encodePassword($user, $user->getPassword());
		$user->setPassword($hash);
	}
	
	/**
	 * Fonction setDefaultUserType
	 * Récupère l'id du type utilisateur par défaut et la renseigne à l'utilisateur passé
	 * @param User $user
	 */
	private function setDefaultUserType(User $user)
	{
		$userType = $this->_userTypeRepository->findOneActiveByName(self::DEFAULT_USER_TYPE);
		$user->setIdUserType($userType);
	}
	
	/**
	 * Fonction setPersonLinkedUser
	 * Récupère l'id du type utilisateur par défaut et la renseigne à l'utilisateur
	 * @param Person $person
	 * @param User   $user
	 */
	private function setPersonLinkedUser(Person $person, User $user)
	{
		$user->setIdPerson($person);
	}
	
	/**
	 * @param User $user
	 * @throws \Exception
	 */
	private function setNewUserUnactive(User $user)
	{
		$user->setBanished(new \DateTime());
	}
	
}