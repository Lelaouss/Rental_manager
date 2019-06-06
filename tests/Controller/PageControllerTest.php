<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
	private $_client = null;
	
	public function setUp()
	{
		$this->_client = static::createClient([], [
			'PHP_AUTH_USER' => 'testeur',
			'PHP_AUTH_PW'   => 'manager*',
		]);
	}
	
	public function testHome()
    {
		$crawler = $this->_client->request('GET', '/home');

        $this->assertSame(200, $this->_client->getResponse()->getStatusCode());
        
        $this->assertContains('Rental Manager', $crawler->filter('h1')->text());
        $this->assertContains('Bienvenue', $crawler->filter('h2')->text());
    }
    
    public function testHomeLinkToHome()
	{
		$crawler = $this->_client->request('GET', '/home');
		
		$link = $crawler->filter('a:contains("Rental Manager")')->eq(0)->link();
		$crawler = $this->_client->click($link);
		$this->assertSame(200, $this->_client->getResponse()->getStatusCode());
		$this->assertContains('Bienvenue', $crawler->filter('h2')->text());
	}
	
	public function testPropertiesLink()
	{
		$this->_client->request('GET', '/home');
		$crawler = $this->_client->clickLink('LOCAUX');
		
		$this->assertSame(200, $this->_client->getResponse()->getStatusCode());
		$this->assertContains('LOCAUX', $crawler->filter('h3')->text());
	}
}
