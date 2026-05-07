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
use App\Models\Brand;
use App\Models\BlogPost;


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
        $new_arrivals = Product::with('media')->withCount('reviews')->withAvg('reviews', 'rating')->active()->latest()->take(10)->get();
        $top_rated = $products->sortByDesc('reviews_avg_rating')->take(3);
        $special_offers = $products->filter(function($p) {
            return $p->sale_price < $p->regular_price;
        })->take(3);
        $column_bestsellers = $products->shuffle()->take(3);
        $brands = Brand::where('status', true)->orderBy('sort_order')->get();
        $latest_posts = BlogPost::with('author')->where('status', 'published')->latest()->take(10)->get();

        return view('frontend.index', compact(
            'seotags',
            'breadcrumbs', 
            'products', 
            'hot_deals', 
            'slides', 
            'promotionBanners', 
            'categories', 
            'best_sellers', 
            'new_arrivals', 
            'top_rated', 
            'special_offers', 
            'column_bestsellers', 
            'brands',
            'latest_posts'
        ));
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

    public function blogShow($slug)
    {
        $post = BlogPost::with('author', 'category', 'tags')->where('slug', $slug)->firstOrFail();
        
        // SEO
        $this->setSeo([
            'title'       => $post->seo->meta_title ?? $post->title,
            'description' => $post->seo->meta_description ?? Str::limit(strip_tags($post->content), 160),
            'keywords'    => $this->formatKeywords($post->seo->meta_keywords ?? ''),
            'image'       => $post->seo->og_image ?? $post->image_path,
            'canonical'   => url()->current(),
        ]);
        $seotags = $this->generateTags();

        $breadcrumbs = $this->generateBreadcrumbJsonLd([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Blog', 'url' => '#'],
            ['name' => $post->title, 'url' => url()->current()],
        ]);

        return view('frontend.blog-details', compact('seotags', 'breadcrumbs', 'post'));
    }

}
