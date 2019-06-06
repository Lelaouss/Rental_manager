<?php

namespace App\Controller;

use App\Entity\Property;
use App\Service\FormService;
use App\Service\PropertyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
	 * @Security("has_role('Admin')")
	 * @param Request         $request
	 * @param PropertyService $propertyService
	 * @return JsonResponse
	 */
	public function add(Request $request, PropertyService $propertyService): JsonResponse
	{
		try {
			// Contrôle de la requête (AJAX seulement)
			FormService::checkHttpRequest($request);
			
			// Récupération des formulaires
			$forms = $propertyService->getPropertiesForms();
			
			// Gestion de la requête
			FormService::handleRequests($request, $forms);
			
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
					
					// Récupération des données POST de la requête AJAX
					$data = FormService::getDataRequest($request);
					
					// Controle des données du formulaire
					FormService::checkFormData([
						$data['property']['label'],
						$data['property']['idOwner'],
						$data['adress']['street'],
						$data['adress']['zipCode'],
						$data['city']['name']
					]);
					
					// Formatage des données du formulaire
					$data = FormService::formatData($data);
					
					// Création du local en BDD
					$propertyService->createProperty($data);
					
					// Status pour le JSON
					$result = 1;
					$messageTitle = "L'action s'est bien déroulée";
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
		catch (\Exception $e) {
			return $this->json(['error' => $e->getMessage()]);
		}
	}
	
	/**
	 * Fonction edit
	 * Génère les formulaires d'édition d'un local
	 *
	 * @Security("has_role('Admin')")
	 * @param Property        $property
	 * @param Request         $request
	 * @param PropertyService $propertyService
	 * @return JsonResponse
	 * @throws \Exception
	 */
	public function edit(Property $property, Request $request, PropertyService $propertyService)
	{
		try {
			// Contrôle de la requête (AJAX seulement)
			FormService::checkHttpRequest($request);
			
			// Formulaires
			$forms = $propertyService->getPropertiesEditForm($property);
			
			// Ville du local édité
			$city = $propertyService->getPropertyCity($property);
			
			return $this->json([
				'result' => 1,
				'data' => [
					'html' => $this->render('pages/properties/properties--edit--form.html.twig', [
						'form_property' => $forms['form_property']->createView(),
						'form_adress' => $forms['form_adress']->createView(),
						'form_city' => $forms['form_city']->createView()
					]),
					'city' => $city
				]
			], 200);
		}
		catch (\Exception $e) {
			return $this->json(['error' => $e->getMessage()]);
		}
	}
	
	/**
	 * Fonction update
	 * Permet la modification d'un local existant
	 *
	 * @Security("has_role('Admin')")
	 * @param Request         $request
	 * @param PropertyService $propertyService
	 * @return JsonResponse
	 * @throws \Exception
	 */
	public function update(Request $request, PropertyService $propertyService): JsonResponse
	{
		try {
			// Contrôle de la requête (AJAX seulement)
			FormService::checkHttpRequest($request);
			
			// Récupération des formulaires
			$forms = $propertyService->getPropertiesForms();
			
			// Gestion de la requête
			FormService::handleRequests($request, $forms);
			
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
					
					// Récupération des données POST de la requête AJAX
					$data = FormService::getDataRequest($request);
					
					// Controle des données du formulaire
					FormService::checkFormData([
						$data['property']['idProperty'],
						$data['property']['label'],
						$data['property']['idOwner'],
						$data['adress']['idAdress'],
						$data['adress']['street'],
						$data['adress']['zipCode'],
						$data['city']['idCity'],
						$data['city']['name']
					]);
					
					// Formatage des données du formulaire
					$data = FormService::formatData($data);
					
					// Modification du local en BDD
					$propertyService->updateProperty($data);
					
					// Status pour le JSON
					$result = 1;
					$messageTitle = "L'action s'est bien déroulée";
					$messageBody = "Le local a bien été modifié";
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
						'html' => $this->render('pages/properties/properties--edit--form.html.twig', [
							'form_property' => $forms['form_property']->createView(),
							'form_adress' => $forms['form_adress']->createView(),
							'form_city' => $forms['form_city']->createView()
						])
					]
				], $code);
			}
		}
		catch (\Exception $e) {
			return $this->json(['error' => $e->getMessage()]);
		}
	}
	
	/**
	 * Fonction ban
	 * Gère la suppression d'un local
	 *
	 * @Security("has_role('Admin')")
	 * @param Request         $request
	 * @param PropertyService $propertyService
	 * @return JsonResponse
	 * @throws \Exception
	 */
	public function ban(Request $request, PropertyService $propertyService): JsonResponse
	{
		try {
			// Contrôle de la requête (AJAX seulement)
			FormService::checkHttpRequest($request);
			
			// Récupération des données POST de la requête AJAX
			$data = FormService::getDataRequest($request);
			
			// Contrôle des données reçues
			FormService::checkFormData([$data['id_property']]);
			
			// Suppression du local
			$propertyService->banProperty($data['id_property']);
			
			// Status pour le JSON
			$result = 1;
			$messageTitle = "L'action s'est bien déroulée";
			$messageBody = "Le local a bien été supprimé";
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
		catch (\Exception $e) {
			return $this->json(['error' => $e]);
		}
	}
}
