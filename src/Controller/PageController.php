<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PageController
 * @package App\Controller
 */
class PageController extends AbstractController
{
	/**
	 * Fonction home
	 * Permet l'accès à la page d'accueil
	 * 
	 * @return Response
	 */
    public function home(): Response
    {
        return $this->render('pages/homepage.html.twig');
    }
	
	/**
	 * Fonction properties
	 * Permet l'accès à la page de gestion des locaux
	 *
	 * @return Response
	 */
	public function properties(): Response
	{
		return $this->render('pages/properties.html.twig');
	}
}
