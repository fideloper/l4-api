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

		$collection->add( $this->_mockModel() );
		$collection->add( $this->_mockModel() );
		$collection->add( $this->_mockModel() );

		$expectedEtag = md5( md5('someEtag').md5('someEtag').md5('someEtag') );
		$returnedEtag = $collection->getEtags();


		// Test we get the proper etag
		$this->assertEquals( $expectedEtag, $returnedEtag );
	}

	public function testGetSetCollectionName()
	{
		$collection = new Collection;

		$name = $this->_randName();

		$collection->setCollectionName($name);

		$this->assertEquals( $name, $collection->getCollectionName() );
	}

	protected function _mockModel()
	{
		$mock = m::mock('Api\Resource\Eloquent\Model');
		$mock->shouldReceive('getKey')->once()->andReturn( rand(0,500) ); // Called in Illuminate\Database\Eloquent\Collection
		$mock->shouldReceive('getEtag')->once()->andReturn( md5('someEtag') );

		return $mock;
	}

	/**
	* @link   http://stackoverflow.com/questions/4356289/php-random-string-generator
	*/
	protected function _randName($length=10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}



}