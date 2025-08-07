<?php include $this->ustanow("czesci/_header.php"); ?>

<body>
    <?php include $this->ustanow("czesci/_stickyMenu.php"); ?>
    <div class="edytuj-kategorie-main">
        <h1>Edytuj kategorie:</h1>
        <form action="/zapisz_kategorie" method="POST">
            <?php include $this->ustanow("czesci/_csrf.php"); ?>
            <div class="edytuj-kategorie-lista">
                <?php $i = count($kategorie);

                foreach ($kategorie as $kat) : ?>
                    <?php echo e($kat['id']) . ". " ?>
                    <input type="text" name="nazwa<?php echo e($kat['id']); ?>" value="<?php echo e($kat['nazwa']); ?>" class="edytuj-kategorie-kat">
                    <br>
                    <?php if (array_key_exists('nazwa' . e($kat['id']), $bledy)) : ?>
                        <div class="blad-formularza">
                            <?php foreach ($bledy['nazwa' . e($kat['id'])] as $blad) echo e($blad) . "<br>"; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
            <button type="submit" class="blog-przycisk blog-przycisk-edytuj">Zapisz</button>
        </form>

        <div style="margin-top: 32px;"></div>

        <form action="/dodaj_kategorie" method="POST">
            <?php include $this->ustanow("czesci/_csrf.php"); ?>
            <div class="edytuj-kategorie-lista">
                <?php echo e($i + 1) . ". " ?>
                <input type="hidden" name="kat_id" value="<?php echo e($i + 1); ?>">
                <input type="text" name="nazwa" class="edytuj-kategorie-kat">
                <?php if (array_key_exists('nazwa', $bledy)) : ?>
                    <div class="blad-formularza">
                        <?php foreach ($bledy['nazwa'] as $blad) echo e($blad) . "<br>"; ?>
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="blog-przycisk blog-przycisk-edytuj">Dodaj</button>
        </form>

        <div style="margin-top: 32px;"></div>

    </div>

    <?php include $this->ustanow("czesci/_footer.php"); ?>