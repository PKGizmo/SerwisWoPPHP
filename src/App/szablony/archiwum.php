<?php include $this->ustanow("czesci/_header.php"); ?>


<body>
    <a class="scrollup"><i class="icon-up-open"></i></a>
    <?php include $this->ustanow("czesci/_logoNazwa.php"); ?>
    <h1>Archiwum bloga</h1>
    <!--<h2>Wzbogacenie serwisu Wolność od Porno</h2>-->
    </div>
    <?php include $this->ustanow("czesci/_onLoad.php"); ?>
    <?php include $this->ustanow("czesci/_stickyMenu.php"); ?>


    <div class="blog-main">
        <div class="blog-main-lista">

            <h1>Lista artykułów z
                <?php if (isset($miesiacArch)) $naglowek =  e($miesiacArch) . "-" . e($rokArch);
                else $naglowek = e($rokArch);
                echo e($naglowek); ?> roku:</h1>

            <?php foreach ($artykuly as $artykul) : ?>

                <div class="blog-artykul-lista">
                    <div class="blog-artykul-naglowek">
                        <div class="blog-artykul-naglowek-tytul">
                            <a href="/blog/<?php echo e($artykul['link']); ?>">
                                <?php if ($artykul['stan'] === 1) : ?>
                                    <?php echo "[Szkic]"; ?>
                                <?php elseif ($artykul['stan'] === 3) : ?>
                                    <?php echo "[Premium]"; ?>
                                <?php endif; ?>
                                <?php echo e($artykul['tytul']); ?>
                            </a>
                        </div>
                        <div class="blog-artykul-naglowek-data">Napisany: <?php echo e($artykul['sformatowana_data']); ?></div>
                        <div class="blog-artykul-naglowek-autor">Autor: <?php echo e($artykul['imie_autora']); ?></div>
                        <div class="blog-artykul-naglowek-kategorie">Kategorie:
                            <?php $i = 0;
                            $ilosc_kategorii = count($artykul['kategorie']);
                            foreach ($artykul['kategorie'] as $kat) {
                                if ($i + 1 === $ilosc_kategorii) {
                                    echo e($kat['nazwa']) . ".";
                                } else {
                                    echo e($kat['nazwa']) . ", ";
                                }
                                $i++;
                            } ?></div>
                        <div class="blog-artykul-naglowek-liczba-komentarzy">Liczba komentarzy:
                            <?php echo e($artykul['ilosc_komentarzy']); ?></div>

                    </div>
                    <div class="blog-artykul-obraz">

                    </div>
                    <div class="blog-artykul-streszczenie">
                        <?php echo e($artykul['streszczenie']); ?>
                    </div>
                    <div class="blog-artykul-stopka">
                        <a href="/blog/<?php echo e($artykul['link']); ?>">
                            Przeczytaj artykuł
                        </a>
                    </div>
                </div>

            <?php endforeach; ?>


            <div class="blog-main-nawigacja-naglowek">
                <h1>Nawigacja:</h1>
            </div>

            <div class="blog-main-nawigacja">
                <h1>
                    <?php if ($biezacaStrona > 1): ?>
                        <a href="/blog/archiwum?<?php echo e($kwerendaDlaPoprzedniejStrony); ?>"><i class="icon-left-dir blog-naw-lewo"></i></a>
                    <?php endif; ?>

                    <?php foreach ($linkiStrony as $nrStrony => $poszukiwanie) : ?>
                        <a class=<?php echo $nrStrony + 1 === $biezacaStrona ? "blog-naw-nr-strony-aktualna" : "blog-naw-nr-strony"; ?> href="/blog/archiwum?<?php echo e($poszukiwanie) ?>">
                            <?php echo $nrStrony + 1; ?>
                        </a>
                    <?php endforeach; ?>

                    <?php if ($biezacaStrona < $ostatniaStrona): ?>
                        <a href="/blog/archiwum?<?php echo e($kwerendaDlaNastepnejStrony); ?>"><i class="icon-right-dir blog-naw-prawo"></i></a>
                    <?php endif; ?>
                </h1>
            </div>

        </div>
        <?php include $this->ustanow("czesci/_blogMenuBoczne.php"); ?>
    </div>

    <?php include $this->ustanow("czesci/_footer.php"); ?>