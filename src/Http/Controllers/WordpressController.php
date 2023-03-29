<?php
declare(strict_types=1);
namespace Cornatul\Wordpress\Http\Controllers;


use Cornatul\Wordpress\Actions\WordpressDeleteAction;
use Cornatul\Wordpress\Actions\WordpressStoreAction;
use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
use Cornatul\Wordpress\Repositories\Interfaces\WebsiteRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View as ViewContract;
class WordpressController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(WebsiteRepositoryInterface $wordpressRepository): ViewContract
    {
        $wordpressSites = $wordpressRepository->paginate();

        return view('wordpress::index', compact('wordpressSites'));
    }

    public function create(): ViewContract
    {
        return view('wordpress::create');
    }

    public function store(WordpressStoreAction $action): RedirectResponse
    {
        $action->handle();

        return redirect()->route('wordpress.index')->with('success', 'Wordpress site created successfully');
    }

    public function delete(int $id,WordpressDeleteAction $action): RedirectResponse
    {
        $action->handle($id);

        return redirect()->route('wordpress.index')->with('success', 'Wordpress site deleted successfully');
    }

}
