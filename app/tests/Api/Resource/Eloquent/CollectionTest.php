<?php

use Mockery as m;
use Api\Resource\Eloquent\Collection;

class CollectionTest extends TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function testGetEtagFromCollection()
	{
		$collection = new Collection;

		$collection[] = $this->_mockModel();
		$collection[] = $this->_mockModel();
		$collection[] = $this->_mockModel();

		$expectedEtag = md5( md5('someEtag').md5('someEtag').md5('someEtag') );
		$returnedEtag = $collection->getEtags();
		

		// Test we get the proper etag
		$this->assertEquals( $expectedEtag, $returnedEtag );
	}

	protected function _mockModel()
	{
		$mock = m::mock('Api\Resource\Eloquent\Model');
		$mock->shouldReceive('getEtag')->once()->andReturn( md5('someEtag') );

		return $mock;
	}



}