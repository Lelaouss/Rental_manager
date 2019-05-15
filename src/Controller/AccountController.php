<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\User;
use App\Form\PersonRegistrationType;
use App\Form\RegistrationType;
use App\Service\UserService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AccountController
 * @package App\Controller
 */
class AccountController extends AbstractController
{
	/**
	 * Fonction index
	 * Affiche et gère les formulaires de connexion et inscription
	 *
	 * @param Request       $request
	 * @param ObjectManager $manager
	 * @param UserService   $userService
	 * @return Response
	 */
	public function index(Request $request, ObjectManager $manager, UserService $userService): Response
	{
		// Personne
		$person = new Person();
		// Utilisateur
		$user = new User();
		
		// Création des formulaires
		$formPerson = $this->createForm(PersonRegistrationType::class, $person);
		$formUser = $this->createForm(RegistrationType::class, $user);
		
		// Gestion de la requête (formulaire)
		$formPerson->handleRequest($request);
		$formUser->handleRequest($request);
		
		// Si le formulaire personne a été envoyé et validé
		// Si le formulaire utilisateur a été envoyé et validé
		if (($formPerson->isSubmitted() && $formPerson->isValid()) && ($formUser->isSubmitted() && $formUser->isValid())) {
			
			// Enregistrement de la nouvelle personne en BDD
			$manager->persist($person);
			$manager->flush();
			
			// Préparation du nouvel utilisateur
			$userService->setNewUserConstraints($user, $person);
			
			// Enregistrement du nouvel utilisateur en BDD
			$manager->persist($user);
			$manager->flush();
			
			dump($user, $person);
		}
		
		return $this->render('account/login.html.twig', [
			'form_person' => $formPerson->createView(),
			'form_user' => $formUser->createView()
		]);
	}
	
	/**
	 * Fonction login
	 * Permet la connexion
	 *
	 * @return Response
	 */
	public function login(): Response
	{
		// géré par symfony
	}
	
	/**
	 * Fonction logout
	 * Permet la déconnexion
	 *
	 * @return void
	 */
	public function logout(): void
	{
		// géré par symfony
	}

}