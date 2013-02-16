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

		return Response::json([
			'error' => false,
			'articles' => $articles->toArray()
			] ,200);
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

		$response = Response::json([
			'error' => false,
			'message' => 'Article Created'
			], 201);

		$response->setEtag( $article->getEtag() );

		return $response;
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		$article = Article::where('id', $id)
			->take(1)
			->get();

		$etag = Request::getEtags();

		if ( $etag[0] === $article[0]->getEtag() ) {
			App::abort(304);
		}

		$response = Response::json([
			'error' => false,
			'article' => $article->toArray()
		], 200);

		$response->setEtag( $article[0]->getEtag() );

		return $response;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$article = Article::where('id', $id)
			->take(1)
			->get();

		if ( Request::get('title') )
		{
			$article->title = Request::get('title');
		}

		if ( Request::get('content') )
		{
			$article->content = Request::get('content');
		}

		$article->save();

		$response = Response::json([
			'error' => false,
			'message' => 'Article updated'
		], 200);

		$response->setEtag( $article->getEtag() );

		return $response;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = Article::where('id', $id)
			->take(1)
			->get();

		$article->delete();

		return Response::json([
			'error' => false,
			'message' => 'Article Deleted'
		], 200);
	}

}