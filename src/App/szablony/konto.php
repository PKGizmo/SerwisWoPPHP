<?php include $this->ustanow("czesci/_header.php"); ?>

<body>
    <?php include $this->ustanow("czesci/_stickyMenu.php"); ?>
    <div class="konto-main">
        <div class="konto-top">
            <?php if ($obraz) : ?>
                <img class="konto-obraz" src="/assets/images/uzytkownicy/<?php echo e($uzytkownik['id']) ?>/<?php echo e($obraz['nowa_nazwa_pliku']); ?>" />
            <?php else: ?>
                <div class="pusty-awatar"></div>
            <?php endif ?>
        </div>

        <h1>Konto: <?php echo $uzytkownik['email']; ?><br>
            Imie: <?php echo $uzytkownik['imie']; ?><br>
            Uprawnienia konta: <?php echo $uprawnienia['opis']; ?></h1>

        <?php if ($_SESSION['uprawnienia'] === 1) : ?>
            <a href="/edytuj_kategorie" class="blog-przycisk blog-przycisk-edytuj">Edytuj kategorie</a>
            <div style="margin-top: 16px;"></div>
            <a href="/przeglad_artykulow" class="blog-przycisk blog-przycisk-edytuj">Przegląd artykułów</a>
            <div style="margin-top: 16px;"></div>
            <a href="/przeglad_komentarzy" class="blog-przycisk blog-przycisk-edytuj">Przegląd komentarzy</a>
            <div style="margin-top: 16px;"></div>
            <a href="/przeglad_uzytkownikow" class="blog-przycisk blog-przycisk-edytuj">Przegląd użytkowników</a>
        <?php endif; ?>

        <div class="konto-dol">
            <div class="konto-dol-kol">
                <form enctype="multipart/form-data" action="/awatar" method="POST">
                    <?php include $this->ustanow("czesci/_csrf.php"); ?>
                    <div class="artykul-edytuj-zdjecie">
                        <label for="artykul-edytuj-zdjecie-przycisk">Awatar użytkownika</label>
                        <div><input type="file" style="width:350px;" class="artykul-edytuj-zdjecie-przycisk" name="obraz" accept="image/x-png,image/gif,image/jpg, image/jpeg">
                        </div>
                    </div>
                    <?php if (array_key_exists('obraz', $bledy)) : ?>
                        <div class="blad-formularza">
                            <?php foreach ($bledy['obraz'] as $blad) echo e($blad) . "<br>"; ?>
                        </div>
                    <?php endif; ?>
                    <button type="submit" style="width:350px;" class="blog-przycisk blog-przycisk-edytuj-konto">Aktualizuj awatar</button>
                </form>
            </div>
            <div class="konto-dol-kol">
                Przegląd komentarzy
            </div>
        </div>
    </div>

    <?php include $this->ustanow("czesci/_footer.php"); ?>