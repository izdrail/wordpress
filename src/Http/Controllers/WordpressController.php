<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Http\Controllers;

use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Jobs\FeedExtractor;
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

    public function index(): ViewContract
    {
        return view('wordpress::index');
    }

}
