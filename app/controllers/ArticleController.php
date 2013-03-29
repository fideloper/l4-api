<?php

class ArticleController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('api.auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$articles = Article::all();

		$articles->setCollectionName('articles');

		$etag = Request::getEtags();

		if ( isset($etag[0]) )
		{
			$etag = str_replace('"', '', $etag[0]);

			if ( $etag === $articles->getEtags() ) {
				App::abort(304);
			}
		}

		return Response::collectionJson($articles);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$article = new Article;
		$article->user_id = Auth::user()->id;
		$article->title = Request::get('title');
		$article->content = Request::get('content');

		$article->save();

		return Response::resourceJson($article, [], 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$article = Article::find($id);

		$etag = Request::getEtags();

		if ( isset($etag[0]) )
		{
			$etag = str_replace('"', '', $etag[0]);

			if ( $etag === $article->getEtag() ) {
				App::abort(304);
			}
		}

		return Response::resourceJson($article);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		// Find article
		$article = Article::find($id);

		// If no article return a bad request
		// because article id is invalid
		if( !$article )
		{
			App::abort(400);
		}

		// Check If-Match header
		$etag = Request::header('if-match');

		// If etag is given, and does not match
		if( $etag !== null && $etag !== $article->getEtag() )
		{
			return Response::json([], 412);
		}

		// Some validation, only update fields that are present
		if ( Request::get('title') )
		{
			$article->title = Request::get('title');
		}

		if ( Request::get('content') )
		{
			$article->content = Request::get('content');
		}

		// Save it
		$article->save();

		// Refresh the eTag, since it'll be new
		$article->getEtag(true);

		return Response::resourceJson($article, [], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = Article::find($id);

		$article->delete();

		return Response::json([
			'message' => 'Article Deleted'
		], 200);
	}

}