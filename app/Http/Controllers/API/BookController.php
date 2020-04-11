<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends BaseController
{

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->model = new Book();
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function listBooks(Request $request)
    {
  	
		$query = $this->model::select('id', 'gutenberg_id', 'title', 'download_count')->with('author', 'language', 'subject', 'bookshelf', 'format');

		$query = $query->when(!empty(request('author')) && empty(request('bookid')), function ($query, $request) {
            $query->whereHas('author' , function($query){
	        	$query = $query->where(function ($query) {
	        		$queryAuthors = explode(',', request('author'));
		            for ($i = 0; $i < count($queryAuthors); $i++){
		            	$query->orwhere('name', 'like',  '%' . $queryAuthors[$i] .'%');
		            }      
		        });
		    });
        });

        $query = $query->when(!empty(request('topic')) && empty(request('bookid')), function ($query, $request) {
            $query->whereHas('subject' , function($query){
	        	$query = $query->where(function ($query) {
	        		$queryTopics = explode(',', request('topic'));
		            for ($i = 0; $i < count($queryTopics); $i++){
		            	$query->orwhere('name', 'like',  '%' . $queryTopics[$i] .'%');
		            }      
		        });
		    })->orWhereHas('bookshelf' , function($query){
	        	$query = $query->where(function ($query) {
	        		$queryTopics = explode(',', request('topic'));
		            for ($i = 0; $i < count($queryTopics); $i++){
		            	$query->orwhere('name', 'like',  '%' . $queryTopics[$i] .'%');
		            }      
		        });
        	});
        });

		$query = $query->when(!empty(request('language')) && empty(request('bookid')), function ($query, $request) {
            $query->whereHas('language' , function($query){
		        	$query = $query->whereIn('code', explode(',', request('language')));
		    });
        });

		$query = $query->when(!empty(request('mimetype')) && empty(request('bookid')), function ($query, $request) {
            $query->whereHas('format' , function($query){
		        	$query = $query->whereIn('mime_type', explode(',', request('mimetype')));
		    });
        });

        $query = $query->when(!empty(request('title')) && empty(request('bookid')), function ($query, $request) {
            $query = $query->where(function ($query) {
        		$queryTitles = explode(',', request('title'));
	            for ($i = 0; $i < count($queryTitles); $i++){
	            	$query->orwhere('title', 'like',  '%' . $queryTitles[$i] .'%');
	            }      
	        });
        });

        $query = $query->orderByDesc('download_count');        

        $page = request('page') ? : "1";
        $totalCount = $query->count();

		if ($page) {
		    $skip = 25 * ($page - 1);
		    $query = $query->take(25)->skip($skip);
		} else {
		    $query = $query->take(25)->skip(0);
		}

		$parameters = $request->getQueryString();

		$parameters = preg_replace('/&page(=[^&]*)?|^page(=[^&]*)?&?/','', $parameters);
		$path = url('/') . '/api/listbooks?' . $parameters;

		$books = $query->get()->toArray();

		$paginator = new \Illuminate\Pagination\LengthAwarePaginator($books, $totalCount, 25, $page);
		$paginator = $paginator->withPath($path);

        return $this->sendResponse($paginator, 'Books Retrived Successfully.');
    }
}
