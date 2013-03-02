<?php namespace Api\Facades;

use Api\Resource\ResourceInterface;
use Api\Resource\CollectionInterface;
use Illuminate\Support\Facades\Response as BaseResponse;

class Response extends BaseResponse {

	/**
	 * Return a new JSON response from the application.
	 * Including ETag for the given resource
	 *
	 * @param  Api\Resource\ResourceInterface
	 * @param  array   $data
	 * @param  int     $status
	 * @param  array   $headers
	 * @return Symfony\Component\HttpFoundation\JsonResponse
	 */
	public static function resourceJson(ResourceInterface $resource, $data = array(), $status = 200, array $headers = array())
	{
		$data[$resource->getResourceName()] = $resource->toArray();

		$response = new \Symfony\Component\HttpFoundation\JsonResponse($data, $status, $headers);
		$response->setEtag( $resource->getEtag() );

		return $response;
	}

	/**
	 * Return a new JSON response from the application.
	 * Including ETag for given collection of resources
	 *
	 * @param  Api\Resource\CollectionInterface
	 * @param  array   $data
	 * @param  int     $status
	 * @param  array   $headers
	 * @return Symfony\Component\HttpFoundation\JsonResponse
	 */
	public static function collectionJson(CollectionInterface $collection, $data = array(), $status = 200, array $headers = array())
	{
		$data[$collection->getCollectionName()] = $collection->toArray();

		$response = new \Symfony\Component\HttpFoundation\JsonResponse($data, $status, $headers);
		$response->setEtag( $collection->getEtags() );

		return $response;
	}

}