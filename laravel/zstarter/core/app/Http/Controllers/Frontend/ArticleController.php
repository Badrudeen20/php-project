<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $articles = Article::whereIsPublish(1)->simplepaginate(10);
        return view('frontend.website.article.index',compact('articles'));
    }
   
    public function show($slug)
    {
        $article = Article::where('slug',$slug)->first();
        $related_posts = Article::where('id','!=',$article->id)->where('category_id',$article->category_id)->latest()->take(2)->get();
        return view('frontend.website.article.show',compact('article','related_posts'));
    }
   
}