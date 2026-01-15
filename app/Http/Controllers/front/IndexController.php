<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\front\IndexService;

class IndexController extends Controller
{
    protected $indexService;
    public function __construct(IndexService $indexService)
    {
       $this->indexService = $indexService;
    }


   public function index() {
    $banners = $this->indexService->getHomePageBanner();
    $featured = $this->indexService->featuredProducts();
    $newArrival = $this->indexService->newArrivalProducts();
    $categories = $this->indexService->homeCategories();

    return view('front.index', [
        'homeSliderBanner'   => $banners['homeSliderBanner'] ?? [],
        'homeFixBanner'      => $banners['homeFixBanner'] ?? [],
        'homeLogoBanner'     => $banners['homeLogoBanner'] ?? [],
        'featuredProducts'   => $featured ?? collect(),
        'newArrivalProducts' => $newArrival ?? collect(),
        'categories'         => $categories['categories'] ?? [],
    ]);
}
}
