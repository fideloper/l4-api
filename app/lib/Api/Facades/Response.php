<?php namespace Api\Facades;

use Api\Resource\ResourceInterface;
use Api\Resource\CollectionInterface;

class Response extends \Illuminate\Support\Facades\Response {

	/**
	 * Return a new JSON response from the application.
	 *
	 * @param  string  $content
	 * @param  int     $status
	 * @param  array   $headers
	 * @return Symfony\Component\HttpFoundation\JsonResponse
	 */
	public static function resourceJson(ResourceInterface $resource, $data = array(), $status = 200, array $headers = array())
	{
		$data[$resource->getTable()] = $resource->toArray();

		$response = new \Symfony\Component\HttpFoundation\JsonResponse($data, $status, $headers);
		$response->setEtag( $resource->getEtag() );

		return $response;
	}

	/**
	 * Return a new JSON response from the application.
	 *
	 * @param  string  $content
	 * @param  int     $status
	 * @param  array   $headers
	 * @return Symfony\Component\HttpFoundation\JsonResponse
	 */
	public static function collectionJson(CollectionInterface $collection, $data = array(), $status = 200, array $headers = array())
	{
		// Bit hacky. Need better "name" assignment
		$data[$collection[0]->getTable()] = $collection->toArray();

		$response = new \Symfony\Component\HttpFoundation\JsonResponse($data, $status, $headers);
		$response->setEtag( $collection->getEtags() );

		return $response;
	}

}