<?php

use Mockery as m;
use Api\Facades\Response as Response;

class ResponseTest extends TestCase {

	public function tearDown()
	{
		m::close();
	}

	/**
	* Test resourceJson applicable to etag/response/data functionality
	*/
	public function testJsonResource()
	{
		$resource = $this->_mockResourceEloquent();
		$jsonResponse = Response::resourceJson( $resource );

		// Test Response and ETag
		$this->assertTrue( $jsonResponse instanceof \Symfony\Component\HttpFoundation\JsonResponse );
		$this->assertEquals( 200, $jsonResponse->getStatusCode() );
		$this->assertEquals( '"'.md5('someEtag').'"', $jsonResponse->getEtag() );

		// Test Data
		$content = json_decode($jsonResponse->getContent());
		$this->assertTrue( isset($content->resourceName) );
		$this->assertTrue( isset($content->resourceName->some) );
		$this->assertEquals( 'data', $content->resourceName->some );
	}

	public function testJsonCollection()
	{
		// To Do (Slightly untestable because my implementation has a hack)
	}

	private function _mockResourceEloquent()
	{
		$mock = m::mock('Api\Resource\Eloquent\Resource');
		$mock->shouldReceive('getResourceName')->once()->andReturn('resourceName');
		$mock->shouldReceive('toArray')->once()->andReturn(['some' => 'data']);
		$mock->shouldReceive('getEtag')->once()->andReturn( md5('someEtag') );

		return $mock;
	}

	private function _mockCollectionEloquent()
	{
		// To Do
	}

}