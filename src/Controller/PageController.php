<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\City;
use App\Entity\Property;
use App\Form\AdressType;
use App\Form\CityType;
use App\Form\PropertyType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
	 * Génère les formulaires de création et modification d'un local
	 *
	 * @param Request       $request
	 * @param ObjectManager $manager
	 * @return Response
	 */
	public function properties(Request $request, ObjectManager $manager): Response
	{
		// Propriété
		$property = new Property();
		// Adresse
		$adress = new Adress();
		// Ville
		$city = new City();
		
		// Création des formulaires
		$formProperty = $this->createForm(PropertyType::class, $property);
		$formAdress = $this->createForm(AdressType::class, $adress);
		$formCity = $this->createForm(CityType::class, $city);
		
		// Gestion de la requête
		$formProperty->handleRequest($request);
		$formAdress->handleRequest($request);
		$formCity->handleRequest($request);
		
		if ($request->isXmlHttpRequest()) {
			if ($formProperty->isSubmitted() && $formAdress->isSubmitted() && $formCity->isSubmitted()) {
				
				if ($formProperty->isValid() && $formAdress->isValid() && $formCity->isValid()) {
					$result = 1;
					$message = "Tout s'est passé correctement.";
					$code = 200;
					$propertyRepository = $manager->getRepository(Property::class);
					$properties = $propertyRepository->findAll();
					$errors = [];
					
					
					return $this->json([
						'result' => $result,
						'message' => $message,
						'data' => [
							'properties' => $properties,
							'errors' => $errors
						]
					], $code);
				}
				
				if (!$formProperty->isValid() || !$formAdress->isValid() || !$formCity->isValid()) {
					$result = 0;
					$message = "Un des formulaires n'est pas valide !";
					$code = 200;
					$properties = [];
					$errors = [];
					
					foreach ($formProperty->getErrors() as $error) {
						$errors[$formProperty->getName()][] = $error->getMessage();
					}
					foreach ($formProperty as $child) {
						if (!$child->isValid()) {
							foreach ($child->getErrors() as $error) {
								$errors[$formProperty->getName()][$child->getName()][] = $error->getMessage();
							}
						}
					}
					
					foreach ($formAdress->getErrors() as $error) {
						$errors[$formAdress->getName()][] = $error->getMessage();
					}
					foreach ($formAdress as $child) {
						if (!$child->isValid()) {
							foreach ($child->getErrors() as $error) {
								$errors[$formAdress->getName()][$child->getName()][] = $error->getMessage();
							}
						}
					}
					
					foreach ($formCity->getErrors() as $error) {
						$errors[$formCity->getName()][] = $error->getMessage();
					}
					foreach ($formCity as $child) {
						if (!$child->isValid()) {
							foreach ($child->getErrors() as $error) {
								$errors[$formCity->getName()][$child->getName()][] = $error->getMessage();
							}
						}
					}
					
					return $this->render('pages/modal.html.twig', [
						'form_property' => $formProperty->createView(),
						'form_adress' => $formAdress->createView(),
						'form_city' => $formCity->createView()
					]);
				}
				
				
//				return $this->json([
//					'result' => $result,
//					'message' => $message,
//					'data' => [
//						'properties' => $properties,
//						'errors' => $errors
//					]
//				], $code);
			}
			
		}
		
		
		return $this->render('pages/properties.html.twig', [
			'form_property' => $formProperty->createView(),
			'form_adress' => $formAdress->createView(),
			'form_city' => $formCity->createView()
		]);
	}
}
