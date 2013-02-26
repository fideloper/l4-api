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
		$article = Article::find($id);

		if ( Request::get('title') )
		{
			$article->title = Request::get('title');
		}

		if ( Request::get('content') )
		{
			$article->content = Request::get('content');
		}

		$article->save();

		return Response::resourceJson($article, [], 201);
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