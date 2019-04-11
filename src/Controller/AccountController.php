<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AccountController
 * @package App\Controller
 */
class AccountController extends AbstractController
{
	/**
	 * Fonction login qui permet l'accès à la page de connexion ainsi que la connexion
	 * Affiche et gère le formulaire de connexion
	 *
	 * @param AuthenticationUtils $utils
	 * @return Response
	 */
	public function login(AuthenticationUtils $utils): Response
	{
		// Gestion des erreurs d'authenfication (si pas d'erreur === null)
		$error = $utils->getLastAuthenticationError();
		$username = $utils->getLastUsername();
		
		return $this->render('account/login.html.twig', [
			'hasError' => $error !== null,
			'username' => $username
		]);
	}
	
	/**
	 * Fonction logout de déconnexion
	 *
	 * @return void
	 */
	public function logout(): void
	{
		// géré par symfony
	}
	
	/**
	 * Fonction register d'inscription au site
	 * Affiche le formulaire d'inscription
	 *
	 * @return Response
	 */
	public function register(): Response
	{
	
	}
}