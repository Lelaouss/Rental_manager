<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormService
 * @package App\Service
 */
class FormService
{
	/**
	 * Fonction checkHttpRequest
	 *
	 * @param Request $request
	 * @return void
	 * @throws \Exception
	 */
	public static function checkHttpRequest(Request $request): void
	{
		if (!$request->isXmlHttpRequest()) {
			throw new \Exception("La requête envoyé n'est pas acceptable !");
		}
	}
	
	/**
	 * Fonction getDataRequest
	 * Récupère les données de la requête
	 *
	 * @param Request $request
	 * @return array
	 * @throws \Exception
	 */
	public static function getDataRequest(Request $request): array
	{
		if (empty($request->request->all())) {
			throw new \Exception("Les données envoyées sont vides !");
		}
		return $request->request->all();
	}
	
	/**
	 * Fonction handleRequests
	 *
	 * @param Request $request
	 * @param array   $forms
	 * @return void
	 * @throws \Exception
	 */
	public static function handleRequests(Request $request, array $forms): void
	{
		if (empty($forms)) {
			throw new \Exception("Le formulaire envoyé est vide !");
		}
		
		foreach ($forms as $form) {
			$form->handleRequest($request);
		}
	}
	
	/**
	 * Fonction checkFormData
	 * Contrôle si les données attendues sont bien présentes
	 *
	 * @param array $data
	 * @return void
	 * @throws \Exception
	 */
	public static function checkFormData(array $data): void
	{
		if (empty($data)) {
			throw new \Exception("Aucune donnée envoyée !");
		}
		
		foreach ($data as $value) {
			if (empty($value)) {
				throw new \Exception("Aucune donnée envoyée !");
			}
		}
	}
	
	/**
	 * Fonction formatData
	 * Permet de mettre les données à la valeur NULL si elles sont vides
	 *
	 * @param array $data
	 * @return array
	 * @throws \Exception
	 */
	public static function formatData(array $data): array
	{
		if (empty($data)) {
			throw new \Exception("Les données envoyées sont incorrectes !");
		}
		
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$data[$key] = self::formatData($value);
			}
			
			if (empty($value)) {
				$data[$key] = NULL;
			}
		}
		return $data;
	}
}