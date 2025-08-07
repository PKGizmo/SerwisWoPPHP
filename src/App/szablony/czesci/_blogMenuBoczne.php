<script type="text/javascript">
    function arch_rozwin(przycisk) {
        $aktualneId = przycisk.id.slice(10);
        $pokazId = "arch_pokaz-" + $aktualneId;

        $idStrzalkaDol = "arch_strzalka_dol-" + $aktualneId;
        $idStrzalkaGora = "arch_strzalka_gora-" + $aktualneId;

        var strzalkaDol = document.getElementById($idStrzalkaDol);
        var strzalkaGora = document.getElementById($idStrzalkaGora);
        var x = document.getElementById($pokazId);

        if (x.style.display === "none") {
            x.style.display = "block";
            strzalkaGora.style.display = "none";
            strzalkaDol.style.display = "block";
        } else {
            x.style.display = "none";
            strzalkaDol.style.display = "none";
            strzalkaGora.style.display = "block";
        }
    }
</script>

<div class="blog-main-menu-right">

    <div class="blog-menu-boczne-naw">
        <h1 class="blog-menu-boczne-naw-naw">Szukaj:</h1>

        <form method="GET">
            <input value="<?php if (isset($poszukiwanieBok)) echo e($poszukiwanieBok); ?>" name="s" type="text" class="register-input blog-szukaj" placeholder="Wpisz czego szukasz" />
            <button type="submit" class="blog-przycisk-szukaj">
                Szukaj
            </button>
        </form>
    </div>

    <div class="blog-menu-boczne-naw">
        <h1 class="blog-menu-boczne-naw-naw">Kategorie:</h1>
        <?php foreach ($kategorieWszystkie as $kat) : ?>
            <h3 class="blog-menu-boczne-naw-flex">
                <i class="icon-right-dir icon-right-dir-naw"></i>
                <a href="/kategoria/<?php echo e($kat['id']) ?>"><?php echo $kat['nazwa'] ?></a>
            </h3>
        <?php endforeach; ?>
    </div>

    <div class="blog-menu-boczne-naw">
        <h1 class="blog-menu-boczne-naw-naw">Archiwum:</h1>
        <?php

        $lata = array_keys($iloscRok);
        $iloscLat = array_values($iloscRok);
        $miesiace = array_keys($iloscMiesiac);
        $iloscMiesiecy = array_values($iloscMiesiac);
        //dd($miesiac);
        $roki = 0;
        $miesiaci = 0;
        $dalej = 0;

        for ($i = 0; $i < count($iloscLat); $i++) {
            echo "<div onclick='arch_rozwin(this)' id='arch_klik-{$i}' class='blog-menu-boczne-naw-flex'><i id='arch_strzalka_gora-{$i}' class='icon-up-dir'></i><i id='arch_strzalka_dol-{$i}' class='icon-down-dir' style='display:none;'></i><a href='/blog/{$lata[$roki]}'>
        <h1 class='blog-menu-boczne-naw-h1' >" . e($lata[$roki]) . " (" . e($iloscLat[$roki]) . ")</h1></a></div>";
            //Robimy tabelkę miesięcy dla każdego roku - nazwa miesiąca i ilość artykułów w danym miesiącu
            $mm = [];
            for ($j = 0; $j < $iloscLat[$roki]; $j++) {
                $mm[] = $miesiac[$dalej + $j];
            }

            //Ile jest danego miesiąca każdego roku - do sumowania każdego elementu listy miesięcy danego roku
            $ilM = array_count_values($mm);

            //Wszystkie miesiące danego roku
            $mies = array_values($mm);

            //Każdy miesiąc danego roku tylko raz - dla stworzenia listy miesięcy
            $m = array_unique($mies);
            $m = array_values(array_filter($m));
            echo "<div id='arch_pokaz-{$i}' style='display:none;'>";
            for ($j = $dalej; $j < $dalej + count($m); $j++) {
                //dd($dalej + count($m) - 1);

                $obiektDaty   = DateTime::createFromFormat('!m', $m[$j - $dalej]);
                $nazwaMiesiaca = $obiektDaty->format('F'); // March
                echo "<a href='/blog/{$lata[$roki]}/{$m[$j -$dalej]}'>
            <h3>" . $nazwaMiesiaca . " (" . e($ilM[$m[$j - $dalej]]) . ")</h3>
            </a>";
            }
            echo "</div>";
            $dalej += $iloscLat[$roki];
            $roki++;
        }
        ?>
    </div>

</div>