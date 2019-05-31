<?php

namespace App\Controller;

use App\Service\CityService;
use App\Service\FormService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CityController
 * @package App\Controller
 */
class CityController extends AbstractController
{
	/**
	 * Fonction searchByZipCode
	 * Permet la recherche de ville en BDD en fonction du code postal envoyé
	 *
	 * @param Request     $request
	 * @param CityService $cityService
	 * @return JsonResponse
	 * @throws \Exception
	 */
    public function searchByZipCode(Request $request, CityService $cityService): JsonResponse
    {
    	try {
			// Contrôle de la requête (AJAX seulement)
			FormService::checkHttpRequest($request);
		
			// Récupération des données POST de la requête AJAX
			$data = FormService::getDataRequest($request);
		
			// Contrôle des données reçues
			if (empty($data['zip_code'])) {
				throw new \Exception("Le code postal est mal renseigné.");
			}
		
			// Recherche de ville correspondant au code postal envoyé
			$cities = $cityService->getCitiesByZipCode($data['zip_code']);
		
			// Status pour le JSON
			$result = 1;
			if (isset($cities['result'])) {
				$result = 0;
			}
		
			// Réponse
			return $this->json([
				'result' => $result,
				'data' => [
					'cities' => $cities,
				]
			], 200);
		}
		catch (\Exception $e) {
    		return $this->json(['error' => $e->getMessage()]);
		}
    }
}
