<script type="text/javascript">
    function ustaw_klase_sticky() {
        let navY = $('#main-menu').offset().top;

        stickyNav = function() {
            let scrollY = $(window).scrollTop();

            if (scrollY > navY) {
                $('#main-menu').addClass('sticky');
            } else {
                $('#main-menu').removeClass('sticky');
            }
        };

        stickyNav();

        $(window).scroll(function() {
            stickyNav();
        });

    }
</script>

<div id="main-menu">
    <ol>
        <li><a href="/">Główna</a>
            <ul>
                <li><a href="/#wop-main-test">Test</a></li>
                <li><a href="/#wop-main-wywiad">Wywiad</a></li>
                <li><a href="/#wop-main-info">Info</a></li>
                <li><a href="/#wop-main-fakty">Fakty</a></li>
                <li><a href="/#wop-main-objawy">Objawy</a></li>
                <li><a href="/#wop-main-opinie">Opinie</a></li>
            </ul>
        </li>
        <li><a href="/blog"><i class="icon-doc-text"></i>Blog</a></li>
        <li><a href="/">Uzależnienie</a></li>
        <li><a href="/">Program WoP</a></li>
        <li><a href="/">Forum</a></li>
        <li><a href="/autor">Autor</a></li>
        <?php if (isset($_SESSION['uzytkownik'])) : ?>
            <li><a href="/konto">Konto</a></li>
            <li><a href="/wyloguj">Wyloguj</a></li>
        <?php else: ?>
            <li><a href="/login">Zaloguj</a></li>
            <li><a href="/rejestracja">Załóż konto</a></li>
        <?php endif; ?>

    </ol>
</div>