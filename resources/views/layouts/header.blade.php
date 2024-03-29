<!-- Top Menu 1 -->
<section class="w3l-top-menu-1">
    <div class="top-hd">
        <div class="container">
            <header class="row top-menu-top">
                <div class="accounts col-md-9 col-6">
                    <li class="top_li"><span class="fa fa-phone"></span><a href="tel:{{ config('phone') }}">{{ config('phone') }}</a> </li>
                    <li class="top_li1"><span class="fa fa-envelope-o"></span> <a href="mailto:{{ config('email') }}" class="mail"> {{ config('email') }}</a>	</li>
                </div>

            </header>
        </div>
    </div>
</section>
<!-- //Top Menu 1 -->
<section class="w3l-bootstrap-header">
    <nav class="navbar navbar-expand-lg navbar-light py-lg-2 py-2">
        <div class="container">
{{--            <a class="navbar-brand" href="index.html"><span class="fa fa-pencil-square-o "></span>РКЦ-Консалтинг Сервис</a>--}}
          <a class="navbar-brand" href="/">
              <img src="{{asset('assets/images/logo.png')}}" alt="{{ config('company_name') }}" title="{{ config('company_name') }}" style="height:35px;" />
          </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fa fa-bars"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    @if(isset($pages))
                    @foreach($pages as $page)
                    <li class="nav-item">
                            <a class="nav-link" href="/{{ $page->url }}">{{ $page->name }}</a>
                    </li>
                    @endforeach
                    @endif
                </ul>
{{--                <form action="search-results.html" class="form-inline position-relative my-2 my-lg-0">--}}
{{--                    <input class="form-control search" type="search" placeholder="Search here..." aria-label="Search" required="">--}}
{{--                    <button class="btn btn-search position-absolute" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button>--}}
{{--                </form>--}}
            </div>
        </div>
    </nav>
</section>
