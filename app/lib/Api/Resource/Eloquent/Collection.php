<?php namespace Api\Resource\Eloquent;

use Illuminate\Database\Eloquent\Collection as BaseCollection;
use Api\Resource\CollectionInterface;

class Collection extends BaseCollection implements CollectionInterface {

	private $collectionName;

	/**
	* Return ETag based on collection of items
	*
	* @return string 	md5 of all ETags
	*/
	public function getEtags()
	{
		$etag = '';

		foreach ( $this as $resource )
		{
			$etag .= $resource->getEtag();
		}

		return md5($etag);
	}

	public function setCollectionName($name)
	{
		$this->collectionName = $name;

		return $this;
	}

	public function getCollectionName() {
		return $this->collectionName;
	}

}