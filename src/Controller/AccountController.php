<?php

namespace App\Controller;

use App\Service\FormService;
use App\Service\UserService;
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
	 * Permet la création d'un nouvel utilisateur et de la personne qui lui est rattachée
	 *
	 * @param Request     $request
	 * @param UserService $userService
	 * @return Response
	 * @throws \Exception
	 */
	public function index(Request $request, UserService $userService): Response
	{
		try {
			// Création des formulaires et objets
			$forms = $userService->getUserForms();
			
			// Gestion de la requête
			FormService::handleRequests($request, [$forms['form_person'], $forms['form_user']]);
			
			// Si les formulaires personne et utilisateur ont étés envoyés et validés
			if (($forms['form_person']->isSubmitted() && $forms['form_person']->isValid()) && ($forms['form_user']->isSubmitted() && $forms['form_user']->isValid())) {
				
				// Enregistrement de la nouvelle personne en BDD
				$userService->saveObjectDB($forms['person']);
				
				// Préparation du nouvel utilisateur
				$userService->setNewUserConstraints($forms['user'], $forms['person']);
				
				// Enregistrement du nouvel utilisateur en BDD
				$userService->saveObjectDB($forms['user']);
				
				/* TODO gestion de l'envoi de mail pour activation du compte utilisateur */
				/* TODO ajout d'un message d'avertissement sur l'enregistrement des données */
			}
			
			return $this->render('account/login.html.twig', [
				'form_person' => $forms['form_person']->createView(),
				'form_user' => $forms['form_user']->createView()
			]);
		}
		catch (\Exception $e) {
			return $this->render('account/login.html.twig', [
				'form_person' => $forms['form_person']->createView(),
				'form_user' => $forms['form_user']->createView()
			]);
		}
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