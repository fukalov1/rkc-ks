<section class="w3l-footer-29-main">
    <div class="footer-29">
        <div class="container">
            <div class="d-grid grid-col-4 footer-top-29">
                <div class="footer-list-29 footer-1">
                    <h6 class="footer-title-29">Контакты</h6>
                    <ul>
                        <li><p><span class="fa fa-map-marker"></span> {{ config('address') }}</p></li>
                        <li><a href="tel:+7-800-999-800"><span class="fa fa-phone"></span> {{ config('phones') }}</a></li>
                        <li><a href="mailto:{{ config('email') }}" class="mail"><span class="fa fa-envelope-open-o"></span> {{ config('email') }}</a></li>
                    </ul>
                </div>
                <div class="footer-list-29 footer-2">
                    <ul>
                        <h6 class="footer-title-29">Быстрые ссылки</h6>
                        <li><a href="customer">Личный кабинет</a></li>

                    </ul>
                </div>
                <div class="footer-list-29 footer-4">
                    <ul>
                        <h6 class="footer-title-29">Меню</h6>
                        @if(isset($pages))
                        @foreach($pages as $page)
                            <li><a href="/{{ $page->url }}"> {{ $page->name }}</a></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="d-grid grid-col-2 bottom-copies">
                <p class="copy-footer-29">© {{ date('Y', time())  }} ООО “РКЦ-Консалтинг Сервис”. Все права защищены.</p>
                <ul class="list-btm-29">
                    <li><a href="#link">Персональные данные</a></li>
                    <li><a href="#link">Пользовательское соглашение</a></li>

                </ul>
            </div>
        </div>
    </div>
    <!-- move top -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-angle-up"></span>
    </button>
    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").style.display = "block";
            } else {
                document.getElementById("movetop").style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    <!-- /move top -->
</section>
