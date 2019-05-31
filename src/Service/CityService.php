<?php

namespace App\Service;

use App\Repository\CityRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CityService
 * @package App\Service
 */
class CityService
{
	/**
	 * @var ObjectManager
	 */
	private $_manager;
	
	/**
	 * @var CityRepository
	 */
	private $_cityRepository;
	
	
	/**
	 * CityService constructor.
	 * @param ObjectManager  $manager
	 * @param CityRepository $cityRepository
	 */
	public function __construct(ObjectManager $manager, CityRepository $cityRepository)
	{
		$this->_manager = $manager;
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