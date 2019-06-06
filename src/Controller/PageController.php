<?php

namespace App\Controller;

use App\Service\PropertyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
	 * @Security("has_role('Admin') or has_role('Visitor')")
	 * @return Response
	 */
    public function home(): Response
    {
        return $this->render('pages/homepage.html.twig');
    }
	
	/**
	 * Fonction properties
	 * Permet l'accès à la page de gestion des locaux
	 * Génère les formulaires de création et modification d'un local (propriété, adresse, ville)
	 *
	 * @Security("has_role('Admin') or has_role('Visitor')")
	 * @param PropertyService $propertyService
	 * @return Response
	 */
	public function properties(PropertyService $propertyService): Response
	{
		// Récupération des formulaires
		$forms = $propertyService->getPropertiesForms();
		$formProperty = $forms['form_property'];
		$formAdress = $forms['form_adress'];
		$formCity = $forms['form_city'];
		
		// Récupération des toutes les propriétés existantes
		$properties = $propertyService->getAllProperties();
		
		// Si pas d'envoi de formulaire
		return $this->render('pages/properties/properties.html.twig', [
			'form_property' => $formProperty->createView(),
			'form_adress' => $formAdress->createView(),
			'form_city' => $formCity->createView(),
			'properties' => $properties
		]);
	}
}
