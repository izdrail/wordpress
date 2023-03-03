<?php
declare(strict_types=1);
namespace Cornatul\Wordpress\Http\Controllers;

use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Jobs\FeedExtractor;
use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Contracts\View\View as ViewContract;
class WordpressController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(WordpressRepositoryInterface $wordpressRepository): ViewContract
    {
        $wordpressSites = $wordpressRepository->paginate();

        return view('wordpress::index', compact('wordpressSites'));
    }

    public function create(): ViewContract
    {
        return view('wordpress::create');
    }

    public function store(Request $request, WordpressRepositoryInterface $wordpressRepository): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'database_host' => 'required',
            'database_user' => 'required',
            'database_pass' => 'nullable',
            'database_name' => 'required',
        ]);

        $wordpressRepository->createSite($request->all());

        return Redirect::route('wordpress.index')->with('success', 'Wordpress site created successfully');
    }


    public function delete(int $id, WordpressRepositoryInterface $wordpressRepository): RedirectResponse
    {
        $wordpressRepository->deleteSite($id);

        return Redirect::route('wordpress.index')->with('success', 'Wordpress site deleted successfully');
    }


    public function publish(int $articleID, ArticleRepositoryInterface $articleRepository, WordpressRepositoryInterface $wordpressRepository): ViewContract
    {
        $article = $articleRepository->getArticleById($articleID);

        $sites = $wordpressRepository->paginate();

        return view('wordpress::publish', compact('article', 'sites'));
    }

}
