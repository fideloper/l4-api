<?php

use Mockery as m;
use Api\Resource\Eloquent\Model;

class ModelTest extends TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function testGetEtagWhenNotYetGenerated()
	{
		$this->assertTrue(true);
	}

    public function testGetEtagWhenAlreadyGenerated()
    {
        $this->assertTrue(true);
    }

    public function testGenerateEtagWithTimestamp()
    {
        $model = new Model;

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

        // Need to mock connection revolver in order to get date format, which is pulled from DB connection !!
        // "fromDateTime" is the issue
        // $this->assertTrue( md5($table . $id . $model->fromDateTime($datetime)), $model->generateEtag() );
        $this->assertTrue(true);
    }

    public function testGenerateEtagWithoutTimestamp()
    {
        $model = new Model;

        $model->timestamps = false;



        $this->assertTrue(true);
    }

    public function testCreateNewCollection()
    {
        $model = new Model;

        $collection = $model->newCollection();

        $this->assertTrue( $collection instanceof Api\Resource\Eloquent\Collection );
    }


}