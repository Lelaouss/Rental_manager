<?php

namespace App\Controller\Property;

use App\Service\FormService;
use App\Service\PropertyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PropertyController
 * @package App\Controller
 */
class PropertyController extends AbstractController
{
	/**
	 * Fonction add
	 * Permet la création d'un nouveau local
	 *
	 * @param Request         $request
	 * @param PropertyService $propertyService
	 * @return JsonResponse
	 */
	public function add(Request $request, PropertyService $propertyService): JsonResponse
	{
		// Contrôle de la requête (AJAX seulement)
		FormService::checkHttpRequest($request);
		
		// Récupération des formulaires
		$forms = $propertyService->getPropertiesForms();
		
		// Gestion de la requête
		FormService::handleRequests($request, [$forms['form_property'], $forms['form_adress'], $forms['form_city']]);
		
		// Retour des formulaires
		if ($forms['form_property']->isSubmitted() && $forms['form_adress']->isSubmitted() && $forms['form_city']->isSubmitted()) {
			
			// Un des formulaires n'est pas valide
			if (!$forms['form_property']->isValid() || !$forms['form_adress']->isValid() || !$forms['form_city']->isValid()) {
				
				// Status pour le JSON
				$result = 0;
				$messageTitle = "Un des formulaires n'est pas valide";
				$messageBody = "Un ou plusieurs champs du formulaire n'a pas été correctement renseigné";
				$code = 200;
				$properties = [];
			}
			
			// Formulaires valides
			if ($forms['form_property']->isValid() && $forms['form_adress']->isValid() && $forms['form_city']->isValid()) {
				
				// Status pour le JSON
				$result = 1;
				$messageTitle = "L'action s'est bien déroulé";
				$messageBody = "Le nouveau local a bien été créé";
				$code = 200;
				
				// Récupération des propriétés
				$properties = $propertyService->getAllProperties();
				
				// Reset forms
				$forms = $propertyService->getPropertiesForms();
			}
			
			// Réponse
			return $this->json([
				'result' => $result,
				'message' => [
					'title' => $messageTitle,
					'body' => $messageBody
				],
				'data' => [
					'properties' => $properties,
					'html' => $this->render('pages/properties/properties--add--form.html.twig', [
						'form_property' => $forms['form_property']->createView(),
						'form_adress' => $forms['form_adress']->createView(),
						'form_city' => $forms['form_city']->createView()
					])
				]
			], $code);
			
		}
	}
	
	/**
	 * Fonction update
	 * Permet la modification d'un local existant
	 *
	 * @param Request         $request
	 * @param PropertyService $propertyService
	 * @return JsonResponse
	 */
	public function update(Request $request, PropertyService $propertyService): JsonResponse
	{
		// Contrôle de la requête (AJAX seulement)
		FormService::checkHttpRequest($request);
		
		$forms = $propertyService->getPropertiesForms();
		// Gestion de la requête
		FormService::handleRequests($request, [$forms['form_property'], $forms['form_adress'], $forms['form_city']]);
		
		// Retour des formulaires
		if ($forms['form_property']->isSubmitted() && $forms['form_adress']->isSubmitted() && $forms['form_city']->isSubmitted()) {
			
			// Un des formulaires n'est pas valide
			if (!$forms['form_property']->isValid() || !$forms['form_adress']->isValid() || !$forms['form_city']->isValid()) {
				
				// Status pour le JSON
				$result = 0;
				$messageTitle = "Un des formulaires n'est pas valide";
				$messageBody = "Un ou plusieurs champs du formulaire n'a pas été correctement renseigné";
				$code = 200;
				$properties = [];
			}
			
			// Formulaires valides
			if ($forms['form_property']->isValid() && $forms['form_adress']->isValid() && $forms['form_city']->isValid()) {
				
				// Status pour le JSON
				$result = 1;
				$messageTitle = "L'action s'est bien déroulé";
				$messageBody = "Le nouveau local a bien été créé";
				$code = 200;
				
				// Récupération des propriétés
				$properties = $propertyService->getAllProperties();
				
				// Reset forms
				$forms = $propertyService->getPropertiesForms();
			}
			
			// Réponse
			return $this->json([
				'result' => $result,
				'message' => [
					'title' => $messageTitle,
					'body' => $messageBody
				],
				'data' => [
					'properties' => $properties,
					'html' => $this->render('pages/properties/properties--add--form.html.twig', [
						'form_property' => $forms['form_property']->createView(),
						'form_adress' => $forms['form_adress']->createView(),
						'form_city' => $forms['form_city']->createView()
					])
				]
			], $code);
			
		}
	}
	
	/**
	 * Fonction ban
	 * Gère la suppression d'un local
	 *
	 * @param Request         $request
	 * @param PropertyService $propertyService
	 * @return JsonResponse
	 * @throws \Exception
	 */
	public function ban(Request $request, PropertyService $propertyService): JsonResponse
	{
		// Contrôle de la requête (AJAX seulement)
		FormService::checkHttpRequest($request);
		
		// Récupération des données POST de la requête AJAX
		$datas = FormService::getDataRequest($request);
		
		if (empty($datas['id_property'])) {
//			throw
		}
		
		// Suppression du local
		$propertyService->banProperty($datas['id_property']);
		
		// Status pour le JSON
		$result = 1;
		$messageTitle = "L'action s'est bien déroulé";
		$messageBody = "Le local a correctement été supprimé";
		$code = 200;
		
		// Récupération des toutes les propriétés existantes
		$properties = $propertyService->getAllProperties();
		
		// Réponse
		return $this->json([
			'result' => $result,
			'message' => [
				'title' => $messageTitle,
				'body' => $messageBody
			],
			'data' => [
				'properties' => $properties
			]
		], $code);
	}
}
