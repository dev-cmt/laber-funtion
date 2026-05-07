<x-frontend-layout title="{{ $post->title }}" :breadcrumbs="$breadcrumbs" :seotags="$seotags">
    <div class="block-header block-header--has-breadcrumb block-header--has-title">
        <div class="container">
            <div class="block-header__body">
                <h1 class="block-header__title">{{ $post->title }}</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="post-view">
                    <div class="post-view__card card">
                        @if($post->image_path)
                        <div class="post-view__image">
                            <img src="{{ asset($post->image_path) }}" alt="{{ $post->title }}">
                        </div>
                        @endif
                        <div class="post-view__body">
                            <div class="post-view__item post-view__item-header">
                                <div class="post-view__item-category">
                                    <a href="#">{{ $post->category->category_name ?? 'General' }}</a>
                                </div>
                                <div class="post-view__item-meta">
                                    By <a>{{ $post->author->name ?? 'Admin' }}</a> on {{ $post->published_date ? $post->published_date->format('F d, Y') : $post->created_at->format('F d, Y') }}
                                </div>
                            </div>
                            <div class="post-view__item post-view__item-content typography">
                                {!! $post->content !!}
                            </div>
                            <div class="post-view__item post-view__item-footer">
                                <div class="post-view__tags">
                                    @foreach($post->tags as $tag)
                                        <a href="#">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                                <div class="post-view__share-links">
                                    <div class="share-links">
                                        <ul class="share-links__list">
                                            <li class="share-links__item share-links__item--type--like"><a href="#">Like</a></li>
                                            <li class="share-links__item share-links__item--type--tweet"><a href="#">Tweet</a></li>
                                            <li class="share-links__item share-links__item--type--pin"><a href="#">Pin It</a></li>
                                            <li class="share-links__item share-links__item--type--counter"><a href="#">4</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <!-- Sidebar could go here -->
                <div class="card p-3">
                    <h5>Latest Posts</h5>
                    <ul class="list-unstyled">
                        @php
                            $recent_posts = \App\Models\BlogPost::where('status', 'published')->where('id', '!=', $post->id)->latest()->take(5)->get();
                        @endphp
                        @foreach($recent_posts as $recent)
                            <li class="mb-2">
                                <a href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a>
                                <div class="text-muted small">{{ $recent->published_date ? $recent->published_date->format('M d, Y') : $recent->created_at->format('M d, Y') }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="block-space block-space--layout--before-footer"></div>
</x-frontend-layout>
