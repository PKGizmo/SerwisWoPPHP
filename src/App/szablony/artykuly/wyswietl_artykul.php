<?php include $this->ustanow("czesci/_header.php"); ?>
<?php include $this->ustanow("czesci/_logoNazwa.php"); ?>
</div>
<?php include $this->ustanow("czesci/_stickyMenu.php"); ?>

<?php include $this->ustanow("czesci/_onLoad.php"); ?>
<?php include $this->ustanow("czesci/_csrf.php"); ?>

<script type="text/javascript">
    function pokaz(przycisk) {
        $aktualneId = przycisk.id.slice(5);
        $pokazId = "pokaz-" + $aktualneId;

        var x = document.getElementById($pokazId);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
</div>

<body>
    <main>
        <div class="header">
            <?php if (isset($_SESSION['uzytkownik'])) : ?>
                <?php if ($_SESSION['uprawnienia'] === 1) : ?>
                    <a href="/edytuj_artykul/<?php echo e($artykul['link']); ?>" class="blog-przycisk blog-przycisk-edytuj">Edytuj artykuł</a>
                <?php endif; ?>
            <?php endif; ?>
            <div class="blog-main">
                <div class="blog-artykul-lista blog-main-lista">
                    <a class="scrollup"><i class="icon-up-open"></i></a>
                    <div class="blog-artykul-naglowek">
                        <div class="blog-artykul-naglowek-tytul">
                            <a href="/blog/<?php echo e($artykul['link']); ?>">
                                <?php echo e($artykul['tytul']); ?>
                            </a>
                            <div class="blog-artykul-obraz blog-artykul-obraz-wymiar-artykul">
                                <?php if ($artykul['obraz']) : ?>
                                    <img class="blog-obraz" src="<?php echo e($artykul['obraz']['sciezka_pelna']); ?>"
                                        alt="<?php echo e($artykul['tytul']) ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div style="display:flex; justify-content:center;">
                            <div class="blog-artykul-naglowek-data">Napisany: <?php echo e($artykul['sformatowana_data']); ?></div>
                            <div class="blog-artykul-naglowek-liczba-komentarzy">&nbsp;| Liczba komentarzy: <a href="#artykul-kom-go">
                                    <?php echo e($artykul['ilosc_komentarzy']);
                                    if (isset($_SESSION['uzytkownik'])) {
                                        if ($_SESSION['uprawnienia'] === 1) {
                                            echo "<div style='display: inline-block; color:grey;'>&nbsp;(" . e($artykul['ilosc_komentarzy_szkic']) . ")</div>";
                                        }
                                    }
                                    ?>
                                </a> </div>
                            <div class="blog-artykul-naglowek-autor">&nbsp;| Autor: <?php echo e($imie_autora); ?></div>
                        </div>
                        <div class="blog-artykul-naglowek-kategorie">Kategorie:
                            <?php $i = 0;

                            $ilosc_kategorii = count($artykul[0]['kategorie']);

                            foreach ($artykul[0]['kategorie'] as $kat) {
                                if ($i + 1 === $ilosc_kategorii) {
                                    echo e($kat['nazwa']) . ".";
                                } else {
                                    echo e($kat['nazwa']) . ", ";
                                }
                                $i++;
                            } ?></div>

                    </div>

                    <article>
                        <div class="blog-artykul-tresc">
                            <?php echo e($artykul['tresc']); ?>
                        </div>
                    </article>

                    <?php if (isset($_SESSION['uprawnienia'])) : ?>
                        <button onclick="pokaz(this)" id="klik-0" class="komentarz-przycisk">Skomentuj artykuł</button>
                        <form action="/napisz_komentarz/<?php echo e($artykul['id']); ?>/0" method="POST">
                            <?php include $this->ustanow("czesci/_csrf.php"); ?>
                            <div id="pokaz-0" class="nowy-komentarz-main" style="display:none;">
                                <input value="<?php echo e($_SESSION['uzytkownik']); ?>" name="id_komentujacego" type="hidden" />
                                <textarea name="tresc" type="text" class="nowy-komentarz-tresc" rows="4"></textarea>
                                <button type="submit" class="komentarz-przycisk">Napisz komentarz</button>
                            </div>
                        </form>
                    <?php endif; ?>
                    <div class="artykul-dyskusja" id="artykul-kom-go">
                        <h1>Dyskusja:</h1>
                    </div>
                    <div class="komentarz-lista">
                        <?php $ikom = 0; ?>
                        <?php foreach ($tabelaPoziomow as $p) : ?>
                            <?php
                            for ($i = 0; $i < count($komentarze); $i++) {
                                if ($p['id'] === $komentarze[$i]['id']) {
                                    $kom = $komentarze[$i];
                                }
                            } ?>

                            <?php $ikom++; ?>
                            <?php $tloSzkicu = '';
                            //Sprawdzamy czy komentarz nie został zatwierdzony
                            if ($kom['stan'] === 0)
                                $tloSzkicu = 'background-color: grey;';
                            ?>
                            <div class="komentarz-main" style="<?php echo e($tloSzkicu) ?> width: <?php echo e(1536 - (int)(($p['poziom'] + 2) * 32)); ?>px; margin-left: <?php echo e($p['poziom'] * 32); ?>px;">
                                <?php if ($kom['stan'] === 0)
                                    echo "SZKIC";
                                ?>
                                <div class="komentarz-naglowek">
                                    <?php $typK = '';
                                    $border = 'border: solid 4px white;';
                                    if ($kom['typ_konta'] === 1)
                                        $border = 'border: solid 4px #FFB100;';
                                    elseif ($kom['typ_konta'] === 3)
                                        $border = 'border: solid 4px #00a233;';

                                    if ($kom['awatar']) {
                                        $awatar = "/assets/images/uzytkownicy/{$kom['id_uzytkownika']}/{$kom['awatar']}";
                                        echo "<div class='kom-ikona-awatar' style='float:left; {$border}'><img src={$awatar}></div>";
                                    }
                                    if (($autor['id'] === $kom['id_uzytkownika']) && $kom['typ_konta'] === 1) {
                                        $typK = "<div class='admin-span'>Autor/admin</div>";
                                    }
                                    if ($kom['typ_konta'] === 3) {
                                        $typK = "<div class='premium-span'>Premium</div>";
                                    }
                                    echo "<div style='float:left;'>Id: " . e($kom['id']) . " | " . e($kom['imie']) . " " . $typK . " | Napisany: " . e($kom['data_utworzenia']);

                                    if ($kom['id_komentarza'] <> 0) {
                                        $idAutoraOdp = $kom['id_komentarza'];
                                        echo "<br>Odpowiedź na komentarz o Id: " . e($kom['id_komentarza']) . ", autora: ";
                                        for ($x = 0; $x < count($komentarze); $x++) {
                                            if ($komentarze[$x]['id'] === $idAutoraOdp) {
                                                echo e($komentarze[$x]['imie']);
                                            }
                                        }
                                    }
                                    echo "</div><div style='clear:both;'></div>" ?>
                                </div>
                                <div class="komentarz-tresc">
                                    <?php echo e($kom['tresc']); ?>
                                </div>
                            </div>

                            <?php if (isset($_SESSION['uprawnienia'])) : ?>
                                <div class="przyciski-komentarza">
                                    <button onclick="pokaz(this)" id="klik-<?php echo e($ikom); ?>" class="komentarz-przycisk">Odpowiedz</button>
                                    <form action="/napisz_komentarz/<?php echo e($artykul['id']) . "/" . e($kom['id']); ?>" method="POST">
                                        <?php include $this->ustanow("czesci/_csrf.php"); ?>
                                        <div id="pokaz-<?php echo e($ikom); ?>" class="nowy-komentarz-main" style="display:none;">
                                            <input value="<?php echo e($_SESSION['uzytkownik']); ?>" name="id_komentujacego" type="hidden" />
                                            <textarea type="text" name="tresc" class="nowy-komentarz-tresc" rows="4"></textarea>
                                            <button type="submit" class="komentarz-przycisk">Napisz odpowiedź</button>
                                        </div>
                                    </form>
                                    <?php if ($kom['stan'] === 0) : ?>
                                        <form action="/zatwierdz_komentarz/<?php echo e($artykul['id']) . "/" . e($kom['id']); ?>" method="POST">
                                            <?php include $this->ustanow("czesci/_csrf.php"); ?>
                                            <button type="submit" class="komentarz-przycisk">Zatwierdź komentarz</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($kom['stan'] === 1) : ?>
                                        <form action="/anuluj_komentarz/<?php echo e($artykul['id']) . "/" . e($kom['id']); ?>" method="POST">
                                            <?php include $this->ustanow("czesci/_csrf.php"); ?>
                                            <button type="submit" class="komentarz-przycisk">Anuluj komentarz</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php $wciecie = 0; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php include $this->ustanow("czesci/_blogMenuBoczne.php"); ?>
            </div>
        </div>
    </main>
    <?php include $this->ustanow("czesci/_footer.php"); ?>