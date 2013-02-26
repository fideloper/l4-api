<?php

use Mockery as m;
use Api\Resource\Eloquent\Model;

class ModelTest extends TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function testShutUpPhpUnit()
	{
		$this->assertTrue(true);
	}


}