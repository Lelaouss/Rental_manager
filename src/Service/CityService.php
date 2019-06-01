<?php

namespace App\Service;

use App\Repository\CityRepository;

/**
 * Class CityService
 * @package App\Service
 */
class CityService
{
	/**
	 * @var CityRepository
	 */
	private $_cityRepository;
	
	
	/**
	 * CityService constructor.
	 * @param CityRepository $cityRepository
	 */
	public function __construct(CityRepository $cityRepository)
	{
		$this->_cityRepository = $cityRepository;
	}
	
	
	/**
	 * Fonction getCitiesByZipCode
	 * Renvoi les résultats de villes correspondants au code postal saisi
	 *
	 * @param $zipCode
	 * @return array
	 */
	public function getCitiesByZipCode($zipCode): array
	{
		$cities = $this->_cityRepository->findByZipCode($zipCode);
		if (count($cities) > 50 || empty($cities)) {
			return ['result' => 0];
		}
		
		return $this->_cityRepository->findByZipCode($zipCode);
	}
	
}