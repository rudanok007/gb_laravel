<?php


namespace Modules\News\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\News\Model\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::getNews();
        return view('news::index', compact(
            'news'
        ));
    }

    public function getNews($id)
    {
        $news = News::getNews();

        $oneNews = collect($news)->filter(function ($item) use (&$id){
            return $item['id'] == $id;
        })->first();

        return view('news::oneNews', compact('oneNews'));
    }

    public function about()
    {
        return view('news::index');
    }
}
