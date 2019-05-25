<?php

namespace App\Service;

/* TODO ajouter des try catch pour contrôler les données renseignées et gérer les erreurs */
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
	 */
	public static function checkHttpRequest(Request $request): void
	{
		if (!$request->isXmlHttpRequest()) {
//			throw
			dump('totototoototot');
		}
	}
	
	/**
	 * Fonction getDataRequest
	 *
	 * @param Request $request
	 * @return array
	 */
	public static function getDataRequest(Request $request): array
	{
		return $request->request->all();
	}
	
	/**
	 * Fonction handleRequests
	 *
	 * @param Request $request
	 * @param array   $forms
	 * @return void
	 */
	public static function handleRequests(Request $request, array $forms): void
	{
		if (empty($forms)) {
//			throw
		}
		
		foreach ($forms as $form) {
			$form->handleRequest($request);
		}
	}
}