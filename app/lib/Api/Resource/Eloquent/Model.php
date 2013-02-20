<?php namespace Api\Resource\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Api\Resource\Eloquent\Collection;
use Api\Resource\ResourceInterface;

class Model extends BaseModel implements ResourceInterface  {

	protected $etag = false;

	/**
	* Retrieve ETag for single resource
	*
	* @return string ETag for resource
	*/
	public function getEtag()
	{
		if ( $this->exists && $this->etag === false )
    	{
    		$this->etag = $this->generateEtag();
    	}

    	return $this->etag;
	}

	/**
	* Generate ETag for single resource
	*
	* @return string ETag, using md5
	*/
	protected function generateEtag()
	{
		$etag = $this->getTable() . $this->getKey();

		if ( $this->usesTimestamps() )
		{
			$etag .= $this->updated_at;
		}

    	return md5( $etag );
	}

	/**
	 * Create a new Eloquent Collection instance.
	 *
	 * @param  array  $models
	 * @return Api\Resource\Eloquent\Collection
	 */
	public function newCollection(array $models = array())
	{
		return new Collection($models);
	}

}