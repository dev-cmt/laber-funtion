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
use App\Models\Order;
use App\Models\OrderItem;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;


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

        $related_products = Product::with('media', 'brand', 'category')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(10)
            ->get();

        return view('frontend.product-details', compact('seotags','breadcrumbs', 'product', 'related_products'));
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

    public function blog(){
        return view('frontend.blog');
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


    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'text' => 'required|string|max:1000',
        ]);

        ProductReview::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(), // Nullable if guest
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'comment' => $request->text,
            'status' => 0, // Pending approval by default
        ]);

        return redirect()->back()->with('success', 'Your review has been submitted and is waiting for approval.');
    }

    public function placeOrder(Request $request)
    {
        $cart = Cart::session(Auth::id() ?? session()->getId());
        if ($cart->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $order = Order::create([
            'invoice_no' => 'INV-' . strtoupper(uniqid()),
            'source' => 'web',
            'customer_name' => $request->first_name . ' ' . $request->last_name,
            'customer_phone' => $request->phone,
            'customer_address' => $request->address . ', ' . $request->city,
            'sub_total' => $cart->getSubTotal(),
            'shipping_cost' => 0, // Placeholder
            'discount' => 0,
            'total' => $cart->getTotal(),
            'paid' => 0,
            'due' => $cart->getTotal(),
            'payment_method' => $request->payment_method,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'notes' => $request->note,
            'customer_id' => Auth::id(),
        ]);

        foreach ($cart->getContent() as $item) {
            // Need product ID from associated model or attribute if available, fallback to 0
            $productId = $item->associatedModel->id ?? $item->id;
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'sku' => $item->id,
                'quantity' => $item->quantity,
                'purchase_price' => 0, // Fallback if unknown
                'sale_price' => $item->price,
                'attributes' => $item->attributes->toArray() ?? [],
            ]);
        }

        $cart->clear();

        // Redirect to a thank you page, for now just home with success
        return redirect()->route('home')->with('success', 'Thank you! Your order has been placed successfully. Invoice: ' . $order->invoice_no);
    }

    public function addWishlist(Request $request)
    {
        $product = Product::findOrFail($request->id);
        Cart::session((Auth::id() ?? session()->getId()) . '_wishlist')->add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->sale_price,
            'quantity' => 1,
            'attributes' => [
                'image' => $product->main_image ? asset($product->main_image) : asset('images/no-image.jpg'),
                'url' => route('product.show', $product->slug),
                'stock' => $product->current_stock > 0 ? 'In Stock' : 'Out of Stock',
            ]
        ]);
        return response()->json(['message' => 'Added to wishlist successfully']);
    }

    public function removeWishlist($id)
    {
        Cart::session((Auth::id() ?? session()->getId()) . '_wishlist')->remove($id);
        return back()->with('success', 'Item removed from wishlist.');
    }

    public function addCompare(Request $request)
    {
        $product = Product::with('category', 'brand')->findOrFail($request->id);
        Cart::session((Auth::id() ?? session()->getId()) . '_compare')->add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->sale_price,
            'quantity' => 1,
            'attributes' => [
                'image' => $product->main_image ? asset($product->main_image) : asset('images/no-image.jpg'),
                'url' => route('product.show', $product->slug),
                'stock' => $product->current_stock > 0 ? 'In Stock' : 'Out of Stock',
                'sku' => $product->sku ?? 'N/A',
                'category' => $product->category->name ?? 'Uncategorized',
                'brand' => $product->brand->name ?? 'No Brand',
                'description' => $product->short_description ?? 'No description',
            ]
        ]);
        return response()->json(['message' => 'Added to compare list successfully']);
    }

    public function removeCompare($id)
    {
        Cart::session((Auth::id() ?? session()->getId()) . '_compare')->remove($id);
        return back()->with('success', 'Item removed from compare list.');
    }

}
