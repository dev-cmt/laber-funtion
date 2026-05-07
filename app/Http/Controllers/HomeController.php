<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\SeoTrait;
use App\Models\Product;
use App\Models\Page;
use App\Models\HomeSlide;
use App\Models\PromotionBanner;
use App\Models\Category;


class HomeController extends Controller
{
    use SeoTrait;

    public function index()
    {
        $products = Product::with('media')->withCount('reviews')->withAvg('reviews', 'rating')->active()->get();
        $hot_deals = $products->take(10);

        $slides = HomeSlide::query()
            ->where('status', true)
            ->whereNotNull('desktop_image')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $promotionBanners = PromotionBanner::query()
            ->where('status', true)
            ->whereNotNull('image')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // SEO
        $page = Page::with('seo')->where('slug','home')->firstOrFail();
        $this->setSeo([
            'title'       => $page->seo->meta_title ?? $page->title,
            'description' => $page->seo->meta_description ?? '',
            'keywords'    => $this->formatKeywords($page->seo->meta_keywords ?? ''),
            'image'       => $page->seo->og_image ?? '',
            'canonical'   => url()->current(),
        ]);
        $seotags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
        ]);
        $categories = Category::with('media')->where('is_home', true)->where('status', true)->take(8)->get();

        $best_sellers = $products->shuffle()->take(10);

        return view('frontend.index', compact('seotags','breadcrumbs', 'products', 'hot_deals', 'slides', 'promotionBanners', 'categories', 'best_sellers'));
    }

    public function shop()
    {
        // SEO
        $page = Page::with('seo')->where('slug','home')->firstOrFail();
        $this->setSeo([
            'title'       => $page->seo->meta_title ?? $page->title,
            'description' => $page->seo->meta_description ?? '',
            'keywords'    => $this->formatKeywords($page->seo->meta_keywords ?? ''),
            'image'       => $page->seo->og_image ?? '',
            'canonical'   => url()->current(),
        ]);
        $seotags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
        ]);
        return view('frontend.shop', compact('seotags','breadcrumbs'));
    }

    public function productShow($slug)
    {
        $product = Product::with('media', 'brand', 'category')
        ->withCount('reviews')        // review count
        ->withAvg('reviews', 'rating') // average rating
        ->where('slug', $slug)->firstOrFail();

        // SEO
        $page = Page::with('seo')->where('slug','home')->firstOrFail();
        $this->setSeo([
            'title'       => $page->seo->meta_title ?? $page->title,
            'description' => $page->seo->meta_description ?? '',
            'keywords'    => $this->formatKeywords($page->seo->meta_keywords ?? ''),
            'image'       => $page->seo->og_image ?? '',
            'canonical'   => url()->current(),
        ]);
        $seotags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
        ]);
        return view('frontend.product-details', compact('seotags','breadcrumbs', 'product'));
    }

    public function checkout()
    {
        // SEO
        $page = Page::with('seo')->where('slug','home')->firstOrFail();
        $this->setSeo([
            'title'       => $page->seo->meta_title ?? $page->title,
            'description' => $page->seo->meta_description ?? '',
            'keywords'    => $this->formatKeywords($page->seo->meta_keywords ?? ''),
            'image'       => $page->seo->og_image ?? '',
            'canonical'   => url()->current(),
        ]);
        $seotags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
        ]);
        return view('frontend.checkout', compact('seotags','breadcrumbs'));
    }

    public function cart()
    {
        // SEO
        $page = Page::with('seo')->where('slug','home')->firstOrFail();
        $this->setSeo([
            'title'       => $page->seo->meta_title ?? $page->title,
            'description' => $page->seo->meta_description ?? '',
            'keywords'    => $this->formatKeywords($page->seo->meta_keywords ?? ''),
            'image'       => $page->seo->og_image ?? '',
            'canonical'   => url()->current(),
        ]);
        $seotags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
        ]);
        return view('frontend.cart', compact('seotags','breadcrumbs'));
    }

    public function wishlist()
    {
        // SEO
        $page = Page::with('seo')->where('slug','home')->firstOrFail();
        $this->setSeo([
            'title'       => $page->seo->meta_title ?? $page->title,
            'description' => $page->seo->meta_description ?? '',
            'keywords'    => $this->formatKeywords($page->seo->meta_keywords ?? ''),
            'image'       => $page->seo->og_image ?? '',
            'canonical'   => url()->current(),
        ]);
        $seotags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
        ]);
        return view('frontend.wishlist', compact('seotags','breadcrumbs'));
    }

    public function compare()
    {
        // SEO
        $page = Page::with('seo')->where('slug','home')->firstOrFail();
        $this->setSeo([
            'title'       => $page->seo->meta_title ?? $page->title,
            'description' => $page->seo->meta_description ?? '',
            'keywords'    => $this->formatKeywords($page->seo->meta_keywords ?? ''),
            'image'       => $page->seo->og_image ?? '',
            'canonical'   => url()->current(),
        ]);
        $seotags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
        ]);
        return view('frontend.compare', compact('seotags','breadcrumbs'));
    }

}
