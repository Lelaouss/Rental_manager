<?php

namespace App\Tests\Service;

use App\Service\FormService;
use PHPUnit\Framework\TestCase;

class FormServiceTest extends TestCase
{
	/** @test */
	public function checkFormDataShouldThrowExceptionIfDataIsEmpty()
	{
		$this->expectException(\Exception::class);
		
		$data = [];
		FormService::checkFormData($data);
	}
	
	/** @test */
	public function checkFormDataShouldReturnVoid()
	{
		$data = ['test'];
		
		$data = FormService::checkFormData($data);
		$this->assertNull($data);
	}
	
	/** @test */
	public function formatDataShouldThrowExceptionIfDataIsEmpty()
	{
		$this->expectException(\Exception::class);
		
		$data = [];
		$result = FormService::formatData($data);
	}
	
	/** @test */
	public function formatDataShouldReturnArray()
	{
		$data = ['test'];
		$result = FormService::formatData($data);
		
		$this->assertTrue(is_array($result));
	}
	
	/** @test */
	public function formatDataShouldFormatEmptyDataToNull()
	{
		$data = [
			'test1' => "test1",
			'test2' => "",
			'test3' => "",
			'test4' => "test4"
		];
		$result = FormService::formatData($data);
		
		$this->assertNotNull($result['test1']);
		$this->assertEquals($data['test1'], $result['test1']);
		$this->assertNull($result['test2']);
		$this->assertNull($result['test3']);
		$this->assertNotNull($result['test4']);
		$this->assertEquals($data['test4'], $result['test4']);
	}
}
