<?php

namespace App\Tests\Entity;

use App\Entity\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
	/** @test */
	public function personShouldHaveCivility()
	{
		$person = new Person();
		
		$this->assertTrue(!is_nan($person->getCivility()));
		$this->assertEquals(0, $person->getCivility());
	}
	
	/** @test */
	public function personShouldHaveTitleCivility()
	{
		$person = new Person();
		$person
			->setCivility(0)
		;
		
		$this->assertTrue(is_string($person->getTitleCivility()));
	}
	
	/** @test */
	public function personTitleCivilityShouldBeMisterOrMiss()
	{
		$person = new Person();
		
		$person->setCivility(0);
		$this->assertEquals('Mme', $person->getTitleCivility());
		
		$person->setCivility(1);
		$this->assertEquals('M.', $person->getTitleCivility());
	}
	
	/** @test */
    public function personShouldHaveFullName()
    {
    	$person = new Person();
    	$person
			->setFirstName('John')
			->setLastName('Doe')
			->setCivility(1)
		;
    	
        $this->assertEquals("M. John Doe", $person->getFullName());
    }
}
