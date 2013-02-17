<?php namespace Api\Resource\Eloquent;

use Illuminate\Database\Eloquent\Collection as BaseCollection;
use Api\Resource\CollectionInterface;

class Collection extends BaseCollection implements CollectionInterface {

	public function getEtags()
	{
		$etag = '';

		foreach ( $this as $resource )
		{
			$etag .= $resource->getEtag();
		}

		return $etag;
	}

}