<x-frontend-layout title="{{ $post->title }}" :breadcrumbs="$breadcrumbs" :seotags="$seotags">
    <!-- site__header -->
    <header class="site__header">
        <div class="header">
            <div class="header__megamenu-area megamenu-area"></div>
            <div class="header__topbar-start-bg"></div>
            <div class="header__topbar-start">
                <div class="topbar topbar--spaceship-start">
                    <div class="topbar__item-text d-none d-xxl-flex">Call Us: +1 (800) 060-07-30</div>
                    <div class="topbar__item-text"><a class="topbar__link" href="#">About Us</a></div><div class="topbar__item-text"><a class="topbar__link" href="#">Contacts</a></div><div class="topbar__item-text"><a class="topbar__link" href="#">Track Order</a></div>
                </div>
            </div>
            <div class="header__topbar-end-bg"></div>
            <div class="header__topbar-end">
                <div class="topbar topbar--spaceship-end">
                    <div class="topbar__item-button">
                        <a href="#" class="topbar__button">
                            <span class="topbar__button-label">FAQ</span>
                        </a>
                    </div>
                    <div class="topbar__item-button">
                        <a href="#" class="topbar__button">
                            <span class="topbar__button-label">Compare</span>
                        </a>
                    </div>
                    <div class="topbar__menu">
                            <button class="topbar__button topbar__button--has-arrow topbar__menu-button" type="button">
                                <span class="topbar__button-label">Quick Links</span>
                                <span class="topbar__button-arrow"><svg width="7px" height="5px">
                                        <path d="M0.280,0.282 C0.645,-0.084 1.238,-0.077 1.596,0.297 L3.504,2.310 L5.413,0.297 C5.770,-0.077 6.363,-0.084 6.728,0.282 C7.080,0.634 7.088,1.203 6.746,1.565 L3.504,5.007 L0.262,1.565 C-0.080,1.203 -0.072,0.634 0.280,0.282 Z" />
                                    </svg>
                                </span>
                            </button>
                            <div class="topbar__menu-body">
                                <a class="topbar__menu-item" href="#"><span>Category</span></a><a class="topbar__menu-item" href="#"><span>Product</span></a>
                            </div>
                        </div>
                </div>
            </div>
            <div class="header__navbar">
                <div class="header__navbar-departments">
                    <div class="departments">
                        <button class="departments__button" type="button">
                            <span class="departments__button-icon"><svg width="16px" height="12px">
                                    <path d="M0,7L0,5L16,5L16,7L0,7ZM0,0L16,0L16,2L0,2L0,0ZM12,12L0,12L0,10L12,10L12,12Z" />
                                </svg>
                            </span>
                            <span class="departments__button-title">Menu</span>
                            <span class="departments__button-arrow"><svg width="9px" height="6px">
                                    <path d="M0.2,0.4c0.4-0.4,1-0.5,1.4-0.1l2.9,3l2.9-3c0.4-0.4,1.1-0.4,1.4,0.1c0.3,0.4,0.3,0.9-0.1,1.3L4.5,6L0.3,1.6C-0.1,1.3-0.1,0.7,0.2,0.4z" />
                                </svg>
                            </span>
                        </button>
                        <div class="departments__menu">
                            <div class="departments__arrow"></div>
                            <div class="departments__body">
                                <ul class="departments__list">
                                    <li class="departments__list-padding" role="presentation"></li>
                                    <li class="departments__item">
                                            <a href="#" class="departments__item-link">
                                                Headlights & Lighting
                                            </a>
                                        </li><li class="departments__item">
                                            <a href="#" class="departments__item-link">
                                                Fuel System & Filters
                                            </a>
                                        </li><li class="departments__item">
                                            <a href="#" class="departments__item-link">
                                                Body Parts & Mirrors
                                            </a>
                                        </li><li class="departments__item">
                                            <a href="#" class="departments__item-link">
                                                Interior Accessories
                                            </a>
                                        </li><li class="departments__item">
                                            <a href="#" class="departments__item-link">
                                                Tires & Wheels
                                            </a>
                                        </li><li class="departments__item">
                                            <a href="#" class="departments__item-link">
                                                Engine & Drivetrain
                                            </a>
                                        </li><li class="departments__item">
                                            <a href="#" class="departments__item-link">
                                                Oils & Lubricants
                                            </a>
                                        </li><li class="departments__item">
                                            <a href="#" class="departments__item-link">
                                                Tools & Garage
                                            </a>
                                        </li>
                                    <li class="departments__list-padding" role="presentation"></li>
                                </ul>
                                <div class="departments__menu-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header__navbar-menu">
                    <div class="main-menu">
                        <ul class="main-menu__list">
                            <li class="main-menu__item main-menu__item--submenu--menu ">
<a href="#" class="main-menu__link">
    Home
</a>
</li><li class="main-menu__item main-menu__item--submenu--menu ">
<a href="#" class="main-menu__link">
    Blog
</a>
</li><li class="main-menu__item main-menu__item--submenu--menu ">
<a href="#" class="main-menu__link">
    Catalog
</a>
</li><li class="main-menu__item main-menu__item--submenu--menu main-menu__item--has-submenu">
<a class="main-menu__link">
    Pages
    <svg width="7px" height="5px">
        <path d="M0.280,0.282 C0.645,-0.084 1.238,-0.077 1.596,0.297 L3.504,2.310 L5.413,0.297 C5.770,-0.077 6.363,-0.084 6.728,0.282 C7.080,0.634 7.088,1.203 6.746,1.565 L3.504,5.007 L0.262,1.565 C-0.080,1.203 -0.072,0.634 0.280,0.282 Z" />
    </svg>
</a>
<div class="main-menu__submenu"><ul class="menu"><li class="menu__item"><a href="#" class="menu__link">Components</a></li><li class="menu__item"><a href="#" class="menu__link">Typography</a></li></ul></div>
</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="header__logo">
                <a href="#" class="logo">
                    <div class="logo__slogan">
                        Auto parts for Cars, trucks and motorcycles
                    </div>
                    <div class="logo__image">
                        <!-- logo -->
                        <svg width="168" height="26">
                            <path class="logo__part-primary" d="M50,26h-5c-1.1,0-2-0.9-2-2V2c0-1.1,0.9-2,2-2h5c6.6,0,12,5.4,12,12v2C62,20.6,56.6,26,50,26z M57,12
c0-3.9-3.1-7-7-7h-0.8C48.5,5,48,5.5,48,6.2v13.6c0,0.7,0.5,1.2,1.2,1.2H50c3.9,0,7-3.1,7-7V12z M38.5,26h-13h-2
c-0.8,0-1.5-0.7-1.5-1.5v-2v-9v-2v-8v-2C22,0.7,22.7,0,23.5,0h2h13C39.3,0,40,0.7,40,1.5v2C40,4.3,39.3,5,38.5,5H27v5h9.5
c0.8,0,1.5,0.7,1.5,1.5v2c0,0.8-0.7,1.5-1.5,1.5H27v6h11.5c0.8,0,1.5,0.7,1.5,1.5v2C40,25.3,39.3,26,38.5,26z M18.8,23.8
c0.6,1-0.1,2.3-1.3,2.3h-2.3c-0.5,0-1-0.3-1.3-0.8L9.7,18H5v6.5C5,25.3,4.3,26,3.5,26h-2C0.7,26,0,25.3,0,24.5v-23
C0,0.7,0.7,0,1.5,0H10c5,0,9,4,9,9c0,3.2-1.7,6.1-4.3,7.7L18.8,23.8z M10,5H6C5.5,5,5,5.4,5,6v6c0,0.6,0.4,1,1,1h4c2.2,0,4-1.8,4-4
S12.2,5,10,5z"></path>
                            <path class="logo__part-secondary" d="M166.5,8h-2.3c-0.6,0-1.1-0.4-1.4-1c-0.5-1.2-2-2-3.8-2c-2.2,0-4,1.3-4,3c0,0.9,0.6,1.8,1.5,2.3
c0.2,0.1,0.5,0.3,0.7,0.4c0.9,0.3,1.2,1.3,0.7,2.1l-1,1.7c-0.4,0.7-1.2,0.9-1.9,0.6c-1.2-0.5-2.3-1.3-3.1-2.2c-1.2-1.4-2-3.1-2-5
c0-4.4,4-8,9-8c4.3,0,8,2.6,8.9,6.2C168.2,7.1,167.4,8,166.5,8z M151.5,18h2.3c0.6,0,1.1,0.4,1.4,1c0.5,1.2,2,2,3.8,2
c2.2,0,4-1.3,4-3c0-0.9-0.6-1.8-1.5-2.3c-0.2-0.1-0.5-0.3-0.7-0.4c-0.9-0.3-1.2-1.3-0.7-2.1l1-1.7c0.4-0.6,1.2-0.9,1.9-0.6
c1.2,0.5,2.3,1.3,3.1,2.2c1.2,1.4,2,3.1,2,5c0,4.4-4,8-9,8c-4.3,0-8-2.6-8.9-6.2C149.8,18.9,150.6,18,151.5,18z M146.5,5H140v19.5
c0,0.8-0.7,1.5-1.5,1.5h-2c-0.8,0-1.5-0.7-1.5-1.5V5h-6.5c-0.8,0-1.5-0.7-1.5-1.5v-2c0-0.8,0.7-1.5,1.5-1.5h18
c0.8,0,1.5,0.7,1.5,1.5v2C148,4.3,147.3,5,146.5,5z M125.8,23.8c0.6,1-0.2,2.3-1.3,2.3h-2.3c-0.5,0-1-0.3-1.3-0.8l-4.2-7.3H112v6.5
c0,0.8-0.7,1.5-1.5,1.5h-2c-0.8,0-1.5-0.7-1.5-1.5v-23c0-0.8,0.7-1.5,1.5-1.5h8.5c5,0,9,4,9,9c0,3.2-1.7,6.1-4.3,7.7L125.8,23.8z
    M117,5h-4c-0.5,0-1,0.4-1,1v6c0,0.6,0.4,1,1,1h4c2.2,0,4-1.8,4-4S119.2,5,117,5z M103.8,26h-2.3c-0.7,0-1.4-0.4-1.6-1.1l-2.4-6.7
c0-0.1-0.1-0.1-0.2-0.1h-7.5c-0.1,0-0.2,0.1-0.2,0.1l-2.4,6.7c-0.2,0.7-0.9,1.1-1.6,1.1h-2.3c-0.8,0-1.4-0.8-1.1-1.6l8.3-23.3
C90.7,0.4,91.3,0,92,0H95c0.7,0,1.4,0.4,1.6,1.1l8.3,23.3C105.2,25.2,104.6,26,103.8,26z M95.5,12.7l-1.8-4.9
c-0.1-0.2-0.3-0.2-0.4,0l-1.8,4.9c0,0.1,0.1,0.3,0.2,0.3h3.5C95.4,13,95.5,12.9,95.5,12.7z M83.9,10.2c0,0.2-0.1,0.4-0.1,0.6
c0,0.2-0.1,0.4-0.1,0.6c-0.1,0.5-0.3,1.1-0.6,1.6c-0.1,0.1-0.1,0.3-0.2,0.4c-0.1,0.1-0.1,0.2-0.2,0.4c-0.2,0.4-0.5,0.7-0.8,1.1
c-0.1,0.1-0.2,0.2-0.3,0.3c-0.1,0.1-0.2,0.2-0.3,0.3c-0.5,0.5-1.1,0.9-1.7,1.3c-1.4,0.8-3,1.3-4.7,1.3h-5v6.5c0,0.8-0.7,1.5-1.5,1.5
h-2c-0.8,0-1.5-0.7-1.5-1.5v-23C65,0.7,65.7,0,66.5,0H75c1.7,0,3.3,0.5,4.7,1.3c0.6,0.4,1.2,0.8,1.7,1.3c0.1,0.1,0.2,0.2,0.3,0.3
c0.1,0.1,0.2,0.2,0.3,0.3c0.3,0.3,0.5,0.7,0.8,1.1c0.1,0.1,0.1,0.2,0.2,0.3C83,4.8,83.1,5,83.1,5.1c0.2,0.5,0.4,1,0.6,1.6
c0,0.2,0.1,0.4,0.1,0.6c0,0.2,0.1,0.4,0.1,0.6C83.9,8,84,8.2,84,8.4c0,0.2,0,0.4,0,0.6s0,0.4,0,0.6C84,9.8,83.9,10,83.9,10.2z M75,5
h-4c-0.6,0-1,0.4-1,1v6c0,0.6,0.4,1,1,1h4c2.2,0,4-1.8,4-4S77.2,5,75,5z"></path>
                        </svg>
                        <!-- logo / end -->
                    </div>
                </a>
            </div>
            <div class="header__search">
                <div class="search">
                    <form class="search__body" id="search_form" action="http://redparts.webps.pp.ua/shop-search-results.html" method="get">
                        <div class="search__shadow"></div>
                        <input class="search__input" type="text" autocomplete="off" name="search" id="search_desktop" value="" placeholder="Enter Keywords or Part Number">
                        <button class="search__button search__button--start" type="button">
                            <span class="search__button-icon"><svg width="20" height="20">
                                    <path d="M6.6,2c2,0,4.8,0,6.8,0c1,0,2.9,0.8,3.6,2.2C17.7,5.7,17.9,7,18.4,7C20,7,20,8,20,8v1h-1v7.5c0,0.8-0.7,1.5-1.5,1.5h-1
c-0.8,0-1.5-0.7-1.5-1.5V16H5v0.5C5,17.3,4.3,18,3.5,18h-1C1.7,18,1,17.3,1,16.5V16V9H0V8c0,0,0.1-1,1.6-1C2.1,7,2.3,5.7,3,4.2
C3.7,2.8,5.6,2,6.6,2z M13.3,4H6.7c-0.8,0-1.4,0-2,0.7c-0.5,0.6-0.8,1.5-1,2C3.6,7.1,3.5,7.9,3.7,8C4.5,8.4,6.1,9,10,9
c4,0,5.4-0.6,6.3-1c0.2-0.1,0.2-0.8,0-1.2c-0.2-0.4-0.5-1.5-1-2C14.7,4,14.1,4,13.3,4z M4,10c-0.4-0.3-1.5-0.5-2,0
c-0.4,0.4-0.4,1.6,0,2c0.5,0.5,4,0.4,4,0C6,11.2,4.5,10.3,4,10z M14,12c0,0.4,3.5,0.5,4,0c0.4-0.4,0.4-1.6,0-2c-0.5-0.5-1.3-0.3-2,0
C15.5,10.2,14,11.3,14,12z" />
                                </svg>
                            </span>
                        </button>
                        <button class="search__button search__button--end" type="submit">
                            <span class="search__button-icon"><svg width="20" height="20">
                                    <path d="M19.2,17.8c0,0-0.2,0.5-0.5,0.8c-0.4,0.4-0.9,0.6-0.9,0.6s-0.9,0.7-2.8-1.6c-1.1-1.4-2.2-2.8-3.1-3.9C10.9,14.5,9.5,15,8,15
c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7c0,1.5-0.5,2.9-1.3,4c1.1,0.8,2.5,2,4,3.1C20,16.8,19.2,17.8,19.2,17.8z M8,3C5.2,3,3,5.2,3,8
c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5C13,5.2,10.8,3,8,3z" />
                                </svg>
                            </span>
                        </button>
                        <div class="search__box"></div>
                        <div class="search__decor">
                            <div class="search__decor-start"></div>
                            <div class="search__decor-end"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="header__indicators">
                <div class="indicator">
                    <a href="#" class="indicator__button">
                        <span class="indicator__icon">
                            <svg width="32" height="32">
                                <path d="M23,4c3.9,0,7,3.1,7,7c0,6.3-11.4,15.9-14,16.9C13.4,26.9,2,17.3,2,11c0-3.9,3.1-7,7-7c2.1,0,4.1,1,5.4,2.6l1.6,2l1.6-2
C18.9,5,20.9,4,23,4 M23,2c-2.8,0-5.4,1.3-7,3.4C14.4,3.3,11.8,2,9,2c-5,0-9,4-9,9c0,8,14,19,16,19s16-11,16-19C32,6,28,2,23,2L23,2
z" />
                            </svg>
                        </span>
                    </a>
                </div>
                
                <div class="indicator">
                    <a href="#" class="indicator__button">
                        <div id="msMiniCart" class="">
<div class="empty">
    <span class="indicator__icon">
                            <svg width="32" height="32">
                                <circle cx="10.5" cy="27.5" r="2.5" />
                                <circle cx="23.5" cy="27.5" r="2.5" />
                                <path d="M26.4,21H11.2C10,21,9,20.2,8.8,19.1L5.4,4.8C5.3,4.3,4.9,4,4.4,4H1C0.4,4,0,3.6,0,3s0.4-1,1-1h3.4C5.8,2,7,3,7.3,4.3
l3.4,14.3c0.1,0.2,0.3,0.4,0.5,0.4h15.2c0.2,0,0.4-0.1,0.5-0.4l3.1-10c0.1-0.2,0-0.4-0.1-0.4C29.8,8.1,29.7,8,29.5,8H14
c-0.6,0-1-0.4-1-1s0.4-1,1-1h15.5c0.8,0,1.5,0.4,2,1c0.5,0.6,0.6,1.5,0.4,2.2l-3.1,10C28.5,20.3,27.5,21,26.4,21z" />
                            </svg>
                            <span class="indicator__counter ms2_total_count">0</span>
                        </span>
                        <span class="indicator__title">Cart</span>
                        
</div>
<div class="not_empty">
    <span class="indicator__icon">
                            <svg width="32" height="32">
                                <circle cx="10.5" cy="27.5" r="2.5" />
                                <circle cx="23.5" cy="27.5" r="2.5" />
                                <path d="M26.4,21H11.2C10,21,9,20.2,8.8,19.1L5.4,4.8C5.3,4.3,4.9,4,4.4,4H1C0.4,4,0,3.6,0,3s0.4-1,1-1h3.4C5.8,2,7,3,7.3,4.3
l3.4,14.3c0.1,0.2,0.3,0.4,0.5,0.4h15.2c0.2,0,0.4-0.1,0.5-0.4l3.1-10c0.1-0.2,0-0.4-0.1-0.4C29.8,8.1,29.7,8,29.5,8H14
c-0.6,0-1-0.4-1-1s0.4-1,1-1h15.5c0.8,0,1.5,0.4,2,1c0.5,0.6,0.6,1.5,0.4,2.2l-3.1,10C28.5,20.3,27.5,21,26.4,21z" />
                            </svg>
                            <span class="indicator__counter ms2_total_count">0</span>
                        </span>
                        <span class="indicator__title">Cart</span>
                        
</div>
</div>
                    </a>
                    
                </div>
            </div>
        </div>
    </header>
    <!-- site__header / end -->
    <!-- site__body -->
    <div class="site__body">
        <div class="block post-view">
            <div class="post-view__header post-header post-header--has-image">
                <div class="post-header__image" style="background-image: url('frontend/images/posts/post-1-1903x500.jpg');"></div>
                <div class="post-header__body">
                    <div class="post-header__categories">
                        <ul class="post-header__categories-list">
                            <li class="post-header__categories-item">
                                <a href="#" class="post-header__categories-link">Lastest News</a>
                            </li>
                        </ul>
                    </div>
                    <h1 class="post-header__title">A Variety Of Other Academic And Non-Academic Approaches Have Been Explored</h1>
                    <div class="post-header__meta">
                        <ul class="post-header__meta-list">
                            <li class="post-header__meta-item">By <a href="#" class="post-header__meta-link">Nancy Elizabeth</a></li>
                            <li class="post-header__meta-item">September 10, 2020</li>
                        </ul>
                    </div>
                </div>
                <div class="decor post-header__decor decor--type--bottom">
                    <div class="decor__body">
                        <div class="decor__start"></div>
                        <div class="decor__end"></div>
                        <div class="decor__center"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="post-view__body">
                    <div class="post-view__item post-view__item-sidebar">
                                        
                        <div class="card widget widget-about-us">
                                <h4 class="widget__header">About Blog</h4>
                                <div class="widget-about-us__body">
                                    <div class="widget-about-us__text">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt, erat in malesuada aliquam, est erat faucibus purus, eget viverra nulla sem vitae neque. Quisque id sodales libero.
                                    </div>
                                    <div class="widget-about-us__social-links social-links">
                                        <ul class="social-links__list">
                                            <li class="social-links__item social-links__item--instagram">
                                                <a  href="https://instagram.com/" target="_blank">
                                                    <i class="widget-social__icon fab fa-instagram"></i>
                                                </a>
                                            </li><li class="social-links__item social-links__item--twitter">
                                                <a  href="https://twitter.com/" target="_blank">
                                                    <i class="widget-social__icon fab fa-twitter"></i>
                                                </a>
                                            </li><li class="social-links__item social-links__item--youtube">
                                                <a  href="https://youtube.com/" target="_blank">
                                                    <i class="widget-social__icon fab fa-youtube"></i>
                                                </a>
                                            </li><li class="social-links__item social-links__item--facebook">
                                                <a  href="https://facebook.com/" target="_blank">
                                                    <i class="widget-social__icon fab fa-facebook"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        
                        <div class="card widget widget-categories">
                            <div class="widget__header">
                                <h4>Categories</h4>
                            </div>
                            <ul class="widget-categories__list widget-categories__list--root" data-collapse data-collapse-opened-class="widget-categories__item--open">
                                                                    <li class="widget-categories__item" data-collapse-item>
                                    <a class="widget-categories__link" href="search-results57d9.html?tag=Study">Study</a>
                                </li>
                                <li class="widget-categories__item" data-collapse-item>
                                    <a class="widget-categories__link" href="search-results8061.html?tag=Philosophy">Philosophy</a>
                                </li>
                                <li class="widget-categories__item" data-collapse-item>
                                    <a class="widget-categories__link" href="search-results7a77.html?tag=Logic">Logic</a>
                                </li>
                                <li class="widget-categories__item" data-collapse-item>
                                    <a class="widget-categories__link" href="search-results6b9e.html?tag=Ethernal">Ethernal</a>
                                </li>
                                <li class="widget-categories__item" data-collapse-item>
                                    <a class="widget-categories__link" href="search-resultsf344.html?tag=Circuits">Circuits</a>
                                </li>
                                <li class="widget-categories__item" data-collapse-item>
                                    <a class="widget-categories__link" href="search-results6998.html?tag=Engeneering">Engeneering</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card widget widget-posts">
                            <div class="widget__header">
                                <h4>Latest Posts</h4>
                            </div>
                            <ul class="widget-posts__list">
                                <li class="widget-posts__item">
                                    <div class="widget-posts__image">
                                        <a href="#">
                                            <img src="frontend/images/cache/post-2-730x485.6778a7314e783f2a5238e4e4602823aa47.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="widget-posts__info">
                                        <div class="widget-posts__name">
                                            <a href="#">Engineers Use Many Methods To Minimize Logic Functions</a>
                                        </div>
                                        <div class="widget-posts__date">November 16, 2020</div>
                                    </div>
                                </li>
<li class="widget-posts__item">
                                    <div class="widget-posts__image">
                                        <a href="#">
                                            <img src="frontend/images/cache/post-8-730x485.6778a7314e783f2a5238e4e4602823aa47.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="widget-posts__info">
                                        <div class="widget-posts__name">
                                            <a href="#">An Advantage Of Digital Circuits When Compared To Analog Circuits</a>
                                        </div>
                                        <div class="widget-posts__date">November 16, 2020</div>
                                    </div>
                                </li>
<li class="widget-posts__item">
                                    <div class="widget-posts__image">
                                        <a href="#">
                                            <img src="frontend/images/cache/post-7-730x485.6778a7314e783f2a5238e4e4602823aa47.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="widget-posts__info">
                                        <div class="widget-posts__name">
                                            <a href="#">Many Inquiries Outside Of Academia Are Philosophical In The Broad Sense</a>
                                        </div>
                                        <div class="widget-posts__date">November 16, 2020</div>
                                    </div>
                                </li>
<li class="widget-posts__item">
                                    <div class="widget-posts__image">
                                        <a href="#">
                                            <img src="frontend/images/cache/post-6-730x485.6778a7314e783f2a5238e4e4602823aa47.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="widget-posts__info">
                                        <div class="widget-posts__name">
                                            <a href="#">Logic Is The Study Of Reasoning And Argument Part 1</a>
                                        </div>
                                        <div class="widget-posts__date">November 16, 2020</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="widget-newsletter widget">
                                <h4 class="widget-newsletter__title">Newsletter</h4>
                                <div class="widget-newsletter__text">
                                    Enter your email address below to subscribe to our newsletter and keep up to date with the latest news, discounts and special offers.
                                </div>
                                <form class="widget-newsletter__form ajax_form" method="post" action="http://redparts.webps.pp.ua/a-variety-of-other-academic-and-non-academic-approaches-have-been-explored.html" name="subscribe">
                                    <input type="text" name="nospam:blank" value="" style="display:none;" />
                                    <label for="widget-newsletter-email" class="sr-only">Email Address</label>
                                    <input id="widget-newsletter__email" type="text" class="form-control" placeholder="Email Address" name="email" value="" required>
                                    <input type="submit" class="widget-newsletter__button" type="submit" name="subscribe" value="Subscribe">
                                
<input type="hidden" name="af_action" value="ae633570412615e87f2e87188821fa8f" />
</form>
                            </div>
                        <div class="card widget-tags widget">
                            <div class="widget__header">
                                <h4>Tags Cloud</h4>
                            </div>
                            <div class="widget-tags__body tags">
                                <div class="tags__list">
                                    <a href="search-results8061.html?tag=Philosophy">Philosophy</a>
<a href="search-results6b9e.html?tag=Ethernal">Ethernal</a>
<a href="search-resultsae5e.html?tag=Education">Education</a>
<a href="search-results54a0.html?tag=Exploring">Exploring</a>
<a href="search-results3a1a.html?tag=Specialization">Specialization</a>
<a href="search-resultsfa54.html?tag=Germany">Germany</a>
<a href="search-resultsf344.html?tag=Circuits">Circuits</a>
<a href="search-resultse988.html?tag=Engineers">Engineers</a>
<a href="search-results36c5.html?tag=Logic%20Functions">Logic Functions</a>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    
                    <div class="post-view__item post-view__item-post">
                        <div class="post-view__card post">
                            <div class="post__body typography">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec facilisis neque ut purus fermentum, ac pretium nibh facilisis. Vivamus venenatis viverra iaculis. Suspendisse tempor orci non sapien ullamcorper dapibus. Suspendisse at velit diam. Donec pharetra nec enim blandit vulputate.</p>
                            </div>
                            <div class="post__footer">
                                <div class="post__tags tags tags--sm">
                                    <div class="tags__list">
                                        <a href="search-results466e.html?tag=Education&amp;key=tags">Education</a><a href="search-results2fcd.html?tag=Exploring&amp;key=tags">Exploring</a><a href="search-resultsfcb6.html?tag=Ethernal&amp;key=tags">Ethernal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-view__card">
                                <h2 class="post-view__card-title">Comments (0)</h2>
                                    <div class="post-view__card-body comments-view">
                                        <ol class="comments-list comments-list--level--0 comments-view__list">
                                            
                                        </ol>
                                    </div>
                                </div><div class="post-view__card">
                            <h2 class="post-view__card-title">Write A Comment</h2>
                            <form class="post-view__card-body" id="comment-form" method="post">
                                <input type="hidden" name="thread" value="resource-47"/>
                                <input type="hidden" name="parent" value="0"/>
                                <input type="hidden" name="id" value="0"/>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="comment-first-name">Your Name</label>
                                        <input type="text" class="form-control" name="name" value="" placeholder="Your Name">
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label for="comment-email">Email Address</label>
                                        <input type="email" class="form-control" id="review-email" placeholder="Email Address" name="email" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment-content">Comment</label>
                                    <textarea class="form-control" id="comment-content" rows="6" id="review-text" rows="6" name="text"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="comment-captcha" id="comment-captcha">Enter the amount 3 + 2</label>
                                    <input type="text" name="captcha" value="" id="comment-captcha" class="form-control" />
                                    <span class="error"></span>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary mt-md-4 mt-2">Post Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-space block-space--layout--before-footer"></div>
    </div>
    <!-- site__body / end -->
</x-frontend-layout>
