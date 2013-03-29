<?php namespace Api\Resource\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Api\Resource\Eloquent\Collection;
use Api\Resource\ResourceInterface;

class Resource extends Model implements ResourceInterface  {

	protected $etag = false;

	protected $resourceName;

	/**
	* Retrieve ETag for single resource
	*
	* @return string ETag for resource
	*/
	public function getEtag($regen=false)
	{
		if ( $this->exists && ($this->etag === false || $regen === true)  )
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
			$datetime = $this->updated_at;

			if ( $datetime instanceof \DateTime )
			{
				$datetime = $this->fromDateTime($datetime);
			}

			$etag .= $datetime;

		}

    	return md5( $etag );
	}

	/**
	* Set the name of the resource
	* for API resource output
	*
	* @param string   Name of the resource
	* @return object  Api\Resource\Eloquent\Model
	*/
	public function setResourceName($name)
	{
		$this->resourceName = $name;

		return $this;
	}

	/**
	* Retrieve the resource name
	*
	* @return string Name of the resource
	*/
	public function getResourceName() {
		if ( $this->resourceName === null )
		{
			$this->resourceName = $this->getTable();
		}
		return $this->resourceName;
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