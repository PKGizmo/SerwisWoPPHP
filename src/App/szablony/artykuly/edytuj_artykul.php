<?php include $this->ustanow("czesci/_header.php"); ?>

<body>
    <?php include $this->ustanow("czesci/_stickyMenu.php"); ?>
    <?php include $this->ustanow("czesci/_onLoad.php"); ?>
    <main>
        <a class="scrollup"><i class="icon-up-open"></i></a>
        <h1>Edytuj artykuł</h1>
        <form enctype="multipart/form-data" action="/nadpisz_artykul/<?php echo e($artykul['id']); ?>" method="POST">
            <?php include $this->ustanow("czesci/_csrf.php"); ?>
            <h3>Tytuł</h3>
            <input value="<?php echo e($artykul['tytul'] ?? ''); ?>" name="tytul" type="text" class="artykul-edytuj-tekst artykul-edytuj-tytul" />
            <?php if (array_key_exists('tytul', $bledy)) : ?>
                <div class="blad-formularza">
                    <?php foreach ($bledy['tytul'] as $blad) echo e($blad) . "<br>"; ?>
                </div>
            <?php endif; ?>

            <h3>Link</h3>
            <input value="<?php echo e($artykul['link'] ?? ''); ?>" name="link" type="text" class="artykul-edytuj-tekst artykul-edytuj-tytul" />
            <?php if (array_key_exists('link', $bledy)) : ?>
                <div class="blad-formularza">
                    <?php foreach ($bledy['link'] as $blad) echo e($blad) . "<br>"; ?>
                </div>
            <?php endif; ?>

            <fieldset class="artykul-edytuj-fieldset">
                <legend>Kategorie</legend>
                <?php $i = 0; ?>
                <?php foreach ($kategorieWszystkie as $kat): ?>

                    <label>
                        <input type="checkbox" name="kat[]" value="<?php echo e($i); ?>"

                            <?php foreach ($kategorie as $kkat)
                                if ($kkat['kategoria'] == $i + 1) echo 'checked'; ?>

                            <?php if (array_key_exists('kat', $stareDaneFormularza)) : ?>
                            <?php foreach ($stareDaneFormularza['kat'] as $skat) if ($skat == $i + 1) echo 'checked'; ?>
                            <?php endif; ?>>
                        <?php echo e($kategorieWszystkie[$i]['nazwa']); ?>
                    </label>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </fieldset>
            <?php if (array_key_exists('kat', $bledy)) : ?>
                <div class="blad-formularza">
                    <?php foreach ($bledy['kat'] as $blad) echo e($blad) . "<br>"; ?>
                </div>
            <?php endif; ?>

            <fieldset name="stan" class="artykul-edytuj-fieldset">
                <legend>Stan artykułu</legend>
                <label>
                    <input type="radio" value="1" name="stan" checked
                        <?php if (array_key_exists('stan', $artykul)) : ?>
                        <?php if ($artykul['stan'] == 1) : echo 'checked' ?? ''; ?>
                        <?php endif; ?>
                        <?php endif; ?>> Szkic </label>
                <label>
                    <input type="radio" value="2" name="stan"
                        <?php if (array_key_exists('stan', $artykul)) : ?>
                        <?php if ($artykul['stan'] == 2) : echo 'checked' ?? ''; ?>
                        <?php endif; ?>
                        <?php endif; ?>> Publiczny </label>
                <label><input type="radio" value="3" name="stan"
                        <?php if (array_key_exists('stan', $artykul)) : ?>
                        <?php if ($artykul['stan'] == 3) : echo 'checked' ?? ''; ?>
                        <?php endif; ?>
                        <?php endif; ?>>
                    Premium </label>
            </fieldset>

            <h3>Data aktualizacji</h3>
            <input name="data" class="artykul-edytuj-tekst artykul-edytuj-data" type="datetime-local" value="<?php echo e($artykul['data_utworzenia'] ?? ''); ?>" />
            <?php if (array_key_exists('data', $bledy)) : ?>
                <div class="blad-formularza">
                    <?php foreach ($bledy['data'] as $blad) echo e($blad) . "<br>"; ?>
                </div>
            <?php endif; ?>

            <div class="margin-top-32"></div>

            <div class="artykul-edytuj-zdjecie">
                <label for="artykul-edytuj-zdjecie-przycisk">Zdjęcie do artykułu</label>
                <div>
                    <h1><?php if (isset($obraz['oryginalna_nazwa_pliku'])) {
                            echo
                            "<div><img src=" . e($obraz['sciezka_pelna']) . "></div>" . $obraz['oryginalna_nazwa_pliku'];
                        } ?></h1>
                </div>
                <div><input type="file" class="artykul-edytuj-zdjecie-przycisk" name="obraz" accept="image/x-png,image/gif,image/jpg, image/jpeg">
                </div>
            </div>
            <?php if (array_key_exists('obraz', $bledy)) : ?>
                <div class="blad-formularza">
                    <?php foreach ($bledy['obraz'] as $blad) echo e($blad) . "<br>"; ?>
                </div>
            <?php endif; ?>

            <h3>Streszczenie</h3>
            <textarea name="streszczenie" class="artykul-edytuj-tekst artykul-edytuj-streszczenie" rows="6"><?php echo e($artykul['streszczenie'] ?? ''); ?></textarea>
            <?php if (array_key_exists('streszczenie', $bledy)) : ?>
                <div class="blad-formularza">
                    <?php foreach ($bledy['streszczenie'] as $blad) echo e($blad) . "<br>"; ?>
                </div>
            <?php endif; ?>

            <h3>Treść</h3>
            <textarea name="tresc" class="artykul-edytuj-tekst artykul-edytuj-tresc" rows="25"><?php echo e($artykul['tresc'] ?? ''); ?></textarea>
            <?php if (array_key_exists('tresc', $bledy)) : ?>
                <div class="blad-formularza">
                    <?php foreach ($bledy['tresc'] as $blad) echo e($blad) . "<br>"; ?>
                </div>
            <?php endif; ?>

            <div class="margin-top-32"></div>

            <?php if (isset($_SESSION['uzytkownik'])) : ?>
                <?php if ($_SESSION['uprawnienia'] === 1) : ?>
                    <button type="submit" class="blog-przycisk blog-przycisk-edytuj">Aktualizuj artykuł</button>
                <?php endif; ?>
            <?php endif; ?>

            <div class="margin-top-32"></div>



        </form>
    </main>
    <?php include $this->ustanow("czesci/_footer.php"); ?>