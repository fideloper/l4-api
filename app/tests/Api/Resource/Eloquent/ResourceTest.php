<?php

use Mockery as m;
use Api\Resource\Eloquent\Resource;

/**
* Test protected method?
*
* @link http://stackoverflow.com/questions/249664/best-practices-to-test-protected-methods-with-phpunit
*/

class ResourceTest extends TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function testGetEtag()
	{
        $this->_mockConnectionAndStuff();

		$model = new Resource;

        // Of course you do...
        $model->exists = true;

        // Timestamps on in this case
        $model->timestamps = true;

        // Set updated_at to now
        $datetime = new DateTime;
        $model->updated_at = $datetime;

        // Set table name
        $table = $this->_randString();
        $model->setTable($table);

        // Set primary key
        $id = $this->_randString(2);
        $model->setAttribute($model->getKeyName(), $id);

        // Get eTag when not generated
        $expectedEtag = md5($table . $id . $datetime->format('Y-m-d H:i:s'));
        $this->assertEquals( $expectedEtag , $model->getEtag() );

        // Get eTag when is generated
        $this->assertEquals( $expectedEtag, $model->getEtag() );
	}

    public function testCreateNewCollection()
    {
        $model = new Resource;

        $collection = $model->newCollection();

        $this->assertTrue( $collection instanceof Api\Resource\Eloquent\Collection );
    }

    public function testGetSetResourceName()
    {
        $model = new Resource;

        $name = $this->_randString();

        $model->setResourceName($name);

        $this->assertEquals( $name, $model->getResourceName() );
    }

    public function testGetSetResourceNameDefaultsToTable()
    {
        $model = new Resource;

        $name = $this->_randString();

        $model->setTable($name);

        $this->assertEquals( $name, $model->getResourceName() );
    }

    protected function _mockConnectionAndStuff()
    {
        Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver = m::mock('Illuminate\Database\ConnectionResolverInterface'));
        $resolver->shouldReceive('connection')->andReturn($mockConnection = m::mock('Illuminate\Database\ConnectionInterface'));
        $mockConnection->shouldreceive('getPostProcessor')->andReturn(m::mock('Illuminate\Database\Query\Processors\Processor'));
        $mockConnection->shouldReceive('getQueryGrammar')->andReturn($queryGrammar = m::mock('Illuminate\Database\Query\Grammars\Grammar'));
        $queryGrammar->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');
    }


}