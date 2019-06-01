<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        
        $this->assertContains('Rental Manager', $crawler->filter('h1')->text());
        $this->assertContains('Bienvenue', $crawler->filter('h2')->text());
    }
    
    public function testHomeLinkToHome()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/home');
		
		$link = $crawler->filter('a:contains("Rental Manager")')->eq(0)->link();
		$crawler = $client->click($link);
		$this->assertSame(200, $client->getResponse()->getStatusCode());
		$this->assertContains('Bienvenue', $crawler->filter('h2')->text());
	}
	
	public function testPropertiesLink()
	{
		$client = static::createClient();
		$client->request('GET', '/home');
		$crawler = $client->clickLink('LOCAUX');
		
		$this->assertSame(200, $client->getResponse()->getStatusCode());
		$this->assertContains('LOCAUX', $crawler->filter('h3')->text());
	}
}
