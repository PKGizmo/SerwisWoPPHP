<?php include $this->ustanow("czesci/_header.php"); ?>

<script type="text/javascript">
    let ktory_slajd = 0;

    window.onload = ustaw_strone_glowna;

    function ustaw_strone_glowna() {

        //schowaj_slajdy_testu();
        const testSlidesContainer = document.getElementById("wop-main-test-slajdy-container");
        const testSlide = document.querySelector('.wop-main-test-slajd');
        const testPrevButton = document.getElementById('test-slide-arrow-prev');
        const testNextButton = document.getElementById('test-slide-arrow-next');

        testNextButton.addEventListener("click", (event) => {
            const slideWidth = testSlide.clientWidth;
            testSlidesContainer.scrollLeft += slideWidth;

            if (ktory_slajd < 5) ktory_slajd++;
            //sprawdzamy i podajemy wynik testu
            if (ktory_slajd == 5) {
                let wynik = 0;
                let tresc = '';
                let wynikslajdow = document.getElementsByClassName("wop-main-test-button");

                for (let i = 0; i < 8; i++)
                    if (wynikslajdow[i].checked) wynik += parseInt(wynikslajdow[i].value);

                if (wynik == 0) tresc = 'Gratulacje!<br/>Prawdopodobnie nie grozi Ci uzależnienie! Ale uważaj,<br/>bo ta choroba dotyka każdego!'
                else if (wynik == 1) tresc = 'Nie jest tragicznie ale miej się na baczności!<br/>To już pierwsze symptomy uzależnienia!'
                else if (wynik == 2) tresc = 'Ojoj!'
                else if (wynik == 3) tresc = 'Ojoj!'
                else tresc = 'Ojoj!'
                document.getElementById('wop-test-main-wynik').innerHTML = tresc;
            }
        });

        testPrevButton.addEventListener("click", () => {
            const slideWidth = testSlide.clientWidth;
            testSlidesContainer.scrollLeft -= slideWidth;
            if (ktory_slajd > 0) ktory_slajd--;
        });

        const opinieSlidesContainer = document.getElementById("wop-main-opinie-slajdy-container");
        const opinieSlide = document.querySelector('.wop-main-opinie-slajd');
        const opiniePrevButton = document.getElementById('opinie-slide-arrow-prev');
        const opinieNextButton = document.getElementById('opinie-slide-arrow-next');

        opinieNextButton.addEventListener("click", (event) => {
            const slideWidth = opinieSlide.clientWidth;
            opinieSlidesContainer.scrollLeft += slideWidth;
        });

        opiniePrevButton.addEventListener("click", () => {
            const slideWidth = opinieSlide.clientWidth;
            opinieSlidesContainer.scrollLeft -= slideWidth;
        });

        ustaw_klase_sticky();

        $(window).scrollTop($(location.hash).offset().top);


        /*let navY = $('#main-menu').offset().top;

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
        });*/

    }

    function sprawdz_czas() {
        let czas = parseInt(0);
        let czas2 = parseInt(0);
        let czasTyg = parseInt(document.getElementById("czas-tyg").value);
        let czasSr = parseInt(document.getElementById("czas-czas").value);
        let czasLata = parseInt(document.getElementById("czas-lata").value);
        let czasZd = parseInt(document.getElementById("czas-zdrowie").value);
        let czasFantazje = parseInt(document.getElementById("czas-fantazje").value);
        let czasStres = parseInt(document.getElementById("czas-stres").value);

        czas = Math.ceil(czasLata * 365 * (czasSr * (czasTyg / 7)));
        czas2 = czasLata * 365 * (czasZd + czasFantazje + czasStres);
        let czas_wynik = document.getElementById("czas-wynik");
        czas_wynik.innerHTML = 'W swoim życiu poświęciłeś na pornografię <span style="color:red;">' + czas + '</span> GODZIN(Y)!<br/>Na regenerację, fantazje, stres i inne negatywne postawy straciłeś <span style="color:red;">' + czas2 + '</span> godzin(y)!<br/><br/><h2 style="font-size:25px;">Podpowiedź - pomnóż też czas spędzony na porno, cierpienie oraz na regenerację razy tyle ile zarabiasz za godzinę...</h2>';
        document.getElementById("czas-sprawdz").style.display = 'none';
    }
</script>

<body>

    <?php include $this->ustanow("czesci/_logoNazwa.php"); ?>
    <h2>Korzystanie z pornografii może prowadzić do uzależnienia!</h2>
    <h3>Sprawdź czy ten problem dotyczy także Ciebie</h3>
    </div>

    <?php include $this->ustanow("czesci/_stickyMenu.php"); ?>

    <main>
        <a class="scrollup"><i class="icon-up-open"></i></a>
        <article>
            <div class="wop-main-zapis">
                <div class="wop-main-youtube">
                    <h1>Film Youtube</h1>
                </div>
                <div class="wop-main-formularz">
                    <h2>Zapisz się na Newsletter!</h2>
                </div>
                <div style="clear:both;"></div>
            </div>
        </article>
        <div id="wop-main-test" class="wop-main-rozdzielacz"></div>
        <article>
            <div class="wop-main-naglowek">
                <span>Test uzależnienia od pornografii</span>
            </div>
            <div class="wop-main-test">
                <h2>Sprawdź poziom zaawansowania swojego uzależnienia!</h2>
                <section id="wop-main-test-slajdy-wrapper">
                    <ul id="wop-main-test-slajdy-container">

                        <button class="slide-arrow" id="test-slide-arrow-prev">&#8249;</button>
                        <button class="slide-arrow" id="test-slide-arrow-next">&#8250;</button>

                        <li class="wop-main-test-slajd">
                            <h1><i class="icon-doc-text"></i><br /><br />Aby poznać stopień zagrożenia uzależnieniem od pornografii, odpowiedz na 4 następujące pytania</h1>
                            <h2>(kliknij strzałkę w prawo)</h2>
                        </li>
                        <li class="wop-main-test-slajd">
                            <h1>Czy poświęcam pornografii więcej czasu, niż bym chciał?<br /><br /></h1>
                            <fieldset>
                                <div>
                                    <label><input type="radio" value="1" name="WoP-Test-Main-Pyt1" class="wop-main-test-button" checked> Tak </label>
                                </div>
                                <div>
                                    <label><input type="radio" value="0" name="WoP-Test-Main-Pyt1" class="wop-main-test-button"> Nie </label>
                                </div>
                            </fieldset>
                            <div class="wop-main-test-slajdy-ids">
                                <i class="icon-circle"></i>
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle-empty"></i>
                            </div>
                        </li>
                        <li class="wop-main-test-slajd">
                            <h1>Czy oglądając pornografię mam problemy z zakończeniem<br />tej czynności?</h1>
                            <fieldset>
                                <div>
                                    <label><input type="radio" value="1" name="WoP-Test-Main-Pyt2" class="wop-main-test-button" checked> Tak </label>
                                </div>
                                <div>
                                    <label><input type="radio" value="0" name="WoP-Test-Main-Pyt2" class="wop-main-test-button"> Nie </label>
                                </div>
                            </fieldset>
                            <div class="wop-main-test-slajdy-ids">
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle"></i>
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle-empty"></i>
                            </div>
                        </li>
                        <li class="wop-main-test-slajd">
                            <h1>Czy przez pornografię zacząłem zaniedbywać któryś z obszarów<br />mojego życia?</h1>
                            <fieldset>
                                <div>
                                    <label><input type="radio" value="1" name="WoP-Test-Main-Pyt3" class="wop-main-test-button" checked> Tak </label>
                                </div>
                                <div>
                                    <label><input type="radio" value="0" name="WoP-Test-Main-Pyt3" class="wop-main-test-button"> Nie </label>
                                </div>
                            </fieldset>
                            <div class="wop-main-test-slajdy-ids">
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle"></i>
                                <i class="icon-circle-empty"></i>
                            </div>
                        </li>
                        <li class="wop-main-test-slajd">
                            <h1>Czy problemy występujące w jakiejś sferze mojego życia są powodem sięgania po pornografię?</h1>
                            <fieldset>
                                <div>
                                    <label><input type="radio" value="1" name="WoP-Test-Main-Pyt4" class="wop-main-test-button" checked> Tak </label>
                                </div>
                                <div>
                                    <label><input type="radio" value="0" name="WoP-Test-Main-Pyt4" class="wop-main-test-button"> Nie </label>
                                </div>
                            </fieldset>
                            <div class="wop-main-test-slajdy-ids">
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle-empty"></i>
                                <i class="icon-circle"></i>
                            </div>
                        </li>
                        <li class="wop-main-test-slajd">
                            <h1 id="wop-test-main-wynik"><i class="icon-doc-text"></i><br /><br />Wynik</h1>
                            <h2>(kliknij strzałkę w prawo)</h2>
                        </li>
                    </ul>
                </section>
            </div>
        </article>
        <div id="wop-main-wywiad" class="wop-main-rozdzielacz"></div>

        <article>
            <div class="wop-main-naglowek">
                <span>WYSŁUCHAJ WYWIADU</span>
            </div>
            <div class="wop-main-wywiad">

            </div>
        </article>
        <div id="wop-main-info" class="wop-main-rozdzielacz"></div>
        <article>
            <div class="wop-main-naglowek">
                <span>ILE CZASU POŚWIĘCONE NA PORNOGRAFIĘ TO JUŻ ZA DUŻO?</span>
            </div>
            <div class="article-body">
                <div class="wop-main-czas-naglowek">
                    <h1>Najpierw kilka informacji</h1>
                </div>
                <h2 class="h2-2">Każde obejrzane zdjęcie czy scena seksualna są przyczyną generowania w mózgu impulsu seksualnego. Jest to impuls bardzo silny. Jest nagły, trochę jakbyś siedział apatycznie na krześle i nagle ktoś wbił Ci szpilkę w tyłek. Wyobraź sobie, że każdy taki impuls jest jak szpilka wbita w mózg.<br /><br />

                    Innym porównaniem impulsów seksualnych jest jakby każdorazowo ktoś coraz głośniej krzyczał Ci do ucha. Co byś wtedy zrobił? Zasłonił uszy, by ograniczyć natężenie hałasu, zgadza się? Mózg robi to samo. Ale robi to poprzez usuwanie połączeń między neuronami. W ten sposób ogranicza siłę przepływających sygnałów. Mózg niszczy sam siebie, by ograniczyć to "zakrzykiwanie" impulsami seksualnymi.<br /><br />

                    Jest to jedną z przyczyn, dla których uważamy oglądanie pornografii za wspaniałe. Bo przestajemy "słyszeć" to co się nam nie podoba. Cena tego jest jedna ogromna. Zabijamy się z uśmiechem na ustach. Przestajemy zdawać sobie sprawę z emocji, którymi bezustannie i tak się kierujemy, budujemy o nie percepcje siebie, ludzi i całego świata, a także potrzebujemy ich do życia, by mieć energię. A naszym głównym celem jest "pozbywanie" się ich. Jednocześnie cały czas je potępiamy i zmagamy się z nimi ale nazywamy to sobie "stresem" i potem próbujemy się "odstresowywać", leczymy się na depresję i bierzemy środki "antydepresyjne". Koszmar.<br /><br />

                    W tym czasie choroba się pogłębia. Żaden lek nie może jej wyleczyć, a próby zajmowania się konsekwencjami przynoszą coraz słabsze skutki. Wkrótce pojawiają się myśli samobójcze.<br /><br />

                    Ile czasu poświęcone na pornografię to już za dużo? Jest to radykalnie subiektywne ale przyjrzyjmy się faktom.</h2>
            </div>

            <div class="wop-main-czas">
                <div class="wop-main-czas-naglowek">
                    <h1>Sprawdźmy ile czasu poświęciłeś już na pornografię</h1>
                </div>
                <div class="wop-main-czas-kol">
                    <h2>Średnia ilość sesji z porno tygodniowo</h2>
                    <div><input class="czas-pole" id="czas-tyg" value="0"></div>
                </div>
                <div class="wop-main-czas-kol">
                    <h2>Średni czas jednej sesji z porno</h2>
                    <div><input class="czas-pole" id="czas-czas" value="0"></div>
                </div>
                <div class="wop-main-czas-kol">
                    <h2>Od ilu lat oglądasz pornografię?</h2>
                    <div><input class="czas-pole" id="czas-lata" value="0"></div>
                </div>
                <div class="wop-main-czas-kol">
                    <h2>Jak długo cierpisz/dochodzisz do siebie po sesji? [godz.]</h2>
                    <div><input class="czas-pole" id="czas-zdrowie" value="0"></div>
                </div>
                <div class="wop-main-czas-kol">
                    <h2>Średnia ilość czasu dziennie na fantazjowanie [godz.]</h2>
                    <div><input class="czas-pole" id="czas-fantazje" value="0"></div>
                </div>
                <div class="wop-main-czas-kol">
                    <h2>Ile czasu dziennie się zamartwiasz, stresujesz, denerwujesz? [godz.]</h2>
                    <div><input class="czas-pole" id="czas-stres" value="0"></div>
                </div>
                <div style="clear:both;"></div>
                <div class="wop-main-czas-podsumowanie">
                    <h1>Podsumowanie:</h1>
                    <button id="czas-sprawdz" onclick="sprawdz_czas()">Sprawdź!</button>
                    <span id="czas-wynik"></span>
                </div>
            </div>
        </article>
        <div id="wop-main-fakty" class="wop-main-rozdzielacz"></div>
        <article>
            <div class="wop-main-naglowek">
                <span>FAKTY O PORNOGRAFII</span>
            </div>
            <div class="article-body">
                <div class="article-column-1_2">
                    <h1>Czym jest uzależnienie od pornografii?</h1>
                    <h2>Sieć nawyków wynikających z fizycznego przeprogramowania mózgu, które bezustannie nadal przeprogramowują mózg.<br /><br />
                        Pogłębiająca się choroba zmieniająca charakter i upodobania osoby uzależnionej oraz mająca wiele następst na podłożu biologicznym i psychologicznym.</h2>
                </div>
                <div class="article-column-1_2">

                    <h1>Kto jest narażony na uzależnienie się?</h1>
                    <h2>Nieograniczony i darmowy dostęp do porno spowodował, że każdy może się uzależnić, jeśli nie jest tego świadomy.<br /><br />
                        Wiek i płeć nie mają znaczenia. Nie liczy się też iloraz inteligencji, przebiegłość, siła woli i wykształcenie.<br /><br />
                        Najbardziej narażeni są ludzie młodzi oraz bez realnych doświadczeń seksualnych.</h2>
                </div>
                <div style="clear:both;"></div>
                <div class="article-column-1_2">
                    <h1>Jak dochodzi do uzależnienia?</h1>
                    <h2>Uzależnić się można jedynie nie będąc świadomym, że może się to nam przytrafić. Jesteś niewinny swojego uzależnienia!<br /><br />
                        Uzależniasz się stopniowo, tworząc coraz więcej podświadomych nawyków zmieniających Twoje zachowania oraz postrzeganie i uczestniczenie w życiu.<br /><br />
                        Porno zaczyna fizycznie zmieniać Twój mózg!</h2>
                </div>
                <div class="article-column-1_2">

                    <h1>Czy moje uzależnienie jest inne?</h1>
                    <h2>Nie. Miliony osób wyszły z różnych uzależnień. Kluczowe jest zrozumieć oraz uwierzyć, że Ty również możesz pozbyć się tego problemu.<br /><br />
                        Rozwiązanie jest identyczne dla każdego uzależnionego od porno. Nie jesteś pod tym względem wyjątkowy. Jest to dla Ciebie wspaniała wiadomość!</h2>
                </div>
                <div style="clear:both;"></div>
                <div class="article-column-1_2">

                    <h1>Jaka jest skala tego problemu?</h1>
                    <h2>Każdy kiedyś spróbował porno. Bardzo trudno jest określić faktyczną ilość uzależnionych. Jednak biorąc pod uwagę wyniki testu, problem dotyczy OGROMNEJ ilości głównie mężczyzn. Średnia twierdzących odpowiedzi wynosi 3!<br /><br />
                        Każdy sam powinien określić, czy porno stanowi dla niego problem. Jeśli wykonywanie danej czynności bardziej szkodzi niż cokolwiek daje, a mimo to jest kontynuowana to już bardzo poważny znak manifestacji problemu.</h2>
                </div>
                <div class="article-column-1_2">

                    <h1>Jakie są konsekwencje uzależnienia?</h1>
                    <h2>Lista objawów (fizycznych, fizjologicznych i psychicznych) ma ponad 100 punktów. Znajdziesz ją nieco niżej na tej stronie.<br /><br />
                        Uzależnienie jest zamkniętym kołem, które dodatkowo obudowywane jest mechanizmem spirali samozniszczenia. Bez leczenia problem zaczyna coraz silniej niszczyć życie.<br /><br />
                        Fizyczna zmiana mózgu ma realny wpływ na pogorszenie niemal każdego obszaru życia osoby uzależnionej!</h2>
                </div>
                <div style="clear:both;"></div>
                <div class="article-column-1_2">

                    <h1>Jakie są przeszkody w wychodzeniu z tego uzależnienia?</h1>
                    <h2>Przede wszystkim brak świadomości, że jest się uzależnionym (i że w ogóle można być). Wypieranie, ignorowanie, bagatelizowanie problemu to też niezwykle częste sytuacje.<br /><br />
                        Brak wiary, że można diametralnie poprawić jakość swojego życia i cieszyć się nim w pełni już nigdy nie oglądając pornografii.<br /><br />
                        Brak wiedzy o mechanizmach utrzymujących uzależnienie - fizyczne zmiany w mózgu są trwałe, podświadome nawyki, zmaganie się z emocjami to tylko niektóre ze składników wielowarstwowej konstrukcji tej choroby.<br /><br />
                        Szereg mitów, przez które ludzie nie szukają pomocy lub z niej rezygnują. Mówię o tym w darmowych materiałach.</h2>
                </div>
                <div class="article-column-1_2">

                    <h1>Jak rozpoznać osobę uzależnioną od porno?</h1>
                    <h2>Trudność w osiąganiu erekcji jest występującą praktycznie zawsze oznaką częstej i kategorycznie źle wykonywanej masturbacji.<br /><br />
                        Zachowania typu - izolowanie się, regularne przebywanie w zamkniętym pokoju, częste usuwanie historii w przeglądarkach internetowych, łatwe wpadanie w złość, ogólne wahania nastrojów, nagminne zmęczenie, notoryczne bóle głowy, niechęć do brania udziału w rozmaitych aktywnościach grupowych.<br /><br />
                        Nagłe pogorszenie się sprawności, skuteczności, trudności w koncentracji, senność, niechęć do rozmów, unikanie tematu pornografii..<br /><br />
                        Jeśli zauważysz, że z nieznanych powodów psuje się relacja, związek, nawarstwia się liczba nierozwiązanych problemów i spraw, jeśli Twoje reakcje nawet na błahe rzeczy często cechują się niechęcią, gniewem, smutkiem to może stanowić to już efekty silnego uzależnienia!<br /><br /></h2>
                </div>
                <div style="clear:both;"></div>


            </div>

        </article>
        <div id="wop-main-objawy" class="wop-main-rozdzielacz"></div>
        <article>
            <div class="wop-main-naglowek">
                <span>LISTA OBJAWÓW UZALEŻNIENIA OD PORNOGRAFII</span>
            </div>
            <div class="article-body" style="margin-top:100px;">
                <h2>Poniższa lista nie oznacza, że objawy te pasują do każdego uzależnionego, czy uzależniony ma je wszystkie. Sprawdź ile przejawia się ich w Twoim życiu. Jeśli z czasem ich przybywa, to bardzo zły znak. Jeśli posiadasz więcej niż 10, a jeszcze niedawno było ich mniej, zastanów się czy uzależnienie od porno nie zaczyna się manifestować.</h2>

                <div class="article-column-1_2">
                    <ol>
                        <li> Zmniejszające się zainteresowanie prawdziwym seksem.</li>
                        <li>
                            Pogłębiająca się izolacja.</li>
                        <li>
                            Coraz słabsze i krótsze erekcje.</li>
                        <li>
                            Orgazmy dostarczają coraz mniej i krótszej przyjemności.</li>
                        <li>
                            Na wszystkim zaczyna zależeć Ci coraz mniej.</li>
                        <li>
                            Uczucie ciągłego zmęczenia.</li>
                        <li>
                            W głowie czujesz jakby mgłę – nie możesz zebrać myśli, skupić się na czymkolwiek dłuższą chwilę.</li>
                        <li>
                            Lęk przed nawiązaniem kontaktu z innym człowiekiem.</li>
                        <li>
                            Depresja.</li>
                        <li>
                            Uczucie, że coś jest z Tobą bardzo nie w porządku (najprawdopodobniej Twoje otoczenie też to odczuwa).</li>
                        <li>
                            Odpychająca innych, szczególnie kobiety aura zniechęcająca ludzi do przebywania z Tobą.</li>
                        <li>
                            Twoje postrzeganie kobiet, seksu, relacji staje się zaburzone – nie jesteś w stanie pogodzić sprzecznych myśli – kobiety chcą czułości, a może raczej ostrego seksu, a może tylko oddania, seks dla nich nie jest ważny, a może seks jest najważniejszy, bez dobrego seksu na pewno ode mnie odejdzie, nie, kobiety tak naprawdę pogardzają mężczyznami, wykorzystują swój seksapil, by nas ośmieszyć, tak naprawdę grają niedostępne dla mnie a uprawiają seks z jakimiś dupkami, pożądają ogromne i umięśnione penisy mogące je zaspokajać kilka razy dziennie przed godziny, w tych czasach oczekują, że facet będzie je pieprzył jak aktor porno, są bezpruderyjne, oczekują zwierzęcego zachowania, nie dbają o emocje i uczucia, szczególnie moje, chcą kogoś innego niż ja, jestem porażką! Będziesz czuł się coraz bardziej zagubiony i przygnębiony.</li>
                        <li>
                            Częste złe samopoczucie wprowadza Cię w stan myślenia, że gdyby inni dowiedzieli się jak wygląda Twój stan emocjonalny, traktowali by Cię w najlepszym przypadku jak kogoś dziwnego, żałosnego.</li>
                        <li>
                            Przestaniesz praktycznie odczuwać emocje – te dobre i złe, utrzymywać się będzie uczucie apatii, oziębłości, wszystko będzie wydawało się marne, nieciekawe, bezwartościowe (wliczając Ciebie samego – Twoje decyzje, postanowienia, działania, uczucia, emocje, plany, myśli). Przestaniesz czuć ekscytację, pociąg, całą radość z życia.</li>
                        <li>
                            Możesz chcieć uciec od wszystkiego, nie będziesz chciał, żeby ludzie Cię poznawali ze względu jak postrzegasz siebie w środku – czujesz się pusty, boisz się, że ktoś odkryje prawdę.</li>
                        <li>
                            Zaczniesz bać się ludzi, ich pytania o Ciebie będą powodem lęków i niechęci. Będziesz pragnął kontaktu ale jednocześnie unikał go za wszelką cenę.</li>
                        <li>
                            Poczujesz, że nie jesteś odważny, męski, przestaniesz mieć dobre pomysły, nie będzie w Tobie życia, wszyscy inni zdawać się będą, że są całe galaktyki przed Tobą w... życiu, po prostu życiu, Ty nie będziesz w stanie wykrzesać w sobie zwykłego szczerego uśmiechu. Będziesz czuł, że jesteś facetem „bez jaj”.</li>
                        <li>
                            Twoja pamięć będzie niezwykle słaba, możliwe, że będziesz zapominał rzeczy, które miały miejsce godzinę wcześniej, nie będziesz pamiętał co ktoś Ci powiedział, będzie to źródłem stresu, szczególnie wśród kobiet, bo będą myślały, że ich nie słuchałeś, że robiłeś to specjalnie.</li>
                        <li>
                            Będziesz miał ogromne trudności z nauką nowych rzeczy, szczególnie tam, gdzie wymagać będą od Ciebie dotrzymywania terminów (których dotrzymywanie też nie będzie wydawało się dla Ciebie ważne) – praca, spotkania.</li>
                        <li>
                            Twój głos ulegnie zmianie – będzie mniej męski.</li>
                        <li>
                            Twoje ciało będzie wpadało w drgawki.</li>
                        <li>
                            Będziesz miał wahania temperatury.</li>
                        <li>
                            Migreny, bóle różnych części ciała.</li>
                        <li>
                            Ogromne wahania nastrojów (coś jak „szalejące hormony” u kobiet).</li>
                        <li>
                            O problemach w seksie można napisać osobną książkę – seks staje się przeciwieństwem tego, czym powinien być dla Ciebie oraz Twoich partnerek.</li>
                        <li>
                            Przestaniesz odczuwać pożądanie do kobiet. Kiedy nawet poczujesz się napalony, pojawi się ogromny wstyd i będziesz chciał to ukryć (nie da się tego logicznie wytłumaczyć).</li>
                        <li>
                            Zaczniesz ograniczać kontakty z innymi ludźmi, przyjaciółmi, rodziną, nawet własną dziewczyną lub żoną - zaczniesz też ich unikać.</li>
                        <li>
                            Zaczniesz się odżywiać nieregularnie lub w ogóle nie będziesz miał ochoty jeść, stracisz na wadze, może nawet wiele kilogramów (nie, to nie jest zaleta).</li>
                        <li>
                            Odczuwanie przyjemności zarówno na co dzień jak i seksualnej zmniejszy się drastycznie.</li>
                        <li>
                            W grupie będziesz miał kłopoty, by nawiązywać nowe relacje, nie będziesz przebojowy, będziesz odczuwał lęk, że ktoś Cię nie polubi za to jaki teraz jesteś, wszyscy będą w Twoich oczach naturalni, bardziej żywi, interesujący, Ty nie.</li>
                        <li>
                            Będziesz miał problemy z zagospodarowaniem czasu – wszystko będzie się wydawało mało ważne, czas będzie uciekał, a Ty będziesz „kręcił się w kółko” zastanawiając się, co mógłbyś zrobić, ostatecznie nie robiąc nic, ew. będziesz zaczynał robić coś, by za chwilę przerwać i zająć się na moment czymś innym.</li>
                        <li>
                            Życie zacznie wydawać Ci się czymś mało interesującym, sztucznym, ludzie, „którzy żyją” będą Cię drażnić.</li>
                        <li>
                            Twoje poczucie własnej wartości spadnie na poziom tak niski jak nigdy dotąd.</li>
                        <li>
                            Organizm zostanie rozstrojony – pojawią się wzdęcia, zwiększona potliwość, nieregularność wydalania, krosty w różnych miejscach, większa podatność na choroby (najczęściej przeziębienia), w tym możliwość wystąpienia alergii, ciało zacznie wydawać nieprzyjemne zapachy (szczególnie w połączeniu z nieregularnym i słabym odżywianiem), niektórzy opisują ten zapach jako „kocia uryna”. Krocze i okolice zaczną również wydzielać bardzo intensywny i nieprzyjemny zapach.</li>
                        <li>
                            Trudności w osiągnięciu erekcji lub całkowity jej zanik.</li>
                        <li>
                            Zmniejszenie rozmiarów penisa (dosłownie!).</li>
                        <li>
                            Mnóstwo niedostrzegalnych dla Ciebie i podświadomych gestów, zmieniona postawa ciała, sposób poruszania się, mowa ciała, dobór słów przeświadczające innych ludzi o tym, że jesteś nieśmiały, nie masz jaj, masz niskie poczucie własnej wartości (więc nie jesteś wartościowy), nie jesteś męski.</li>
                        <li>
                            Twoja pewność siebie spadnie do takiego stopnia, że codziennie zwykłe czynności wywołają w Tobie falę stresu (np. kupienie pieczywa w sklepie – nie będziesz miał ochoty rozmawiać z ekspedientką).</li>
                        <li>
                            Każdą, najmniejszą nawet krytykę zaczniesz brać do siebie, co jeszcze bardziej obniży Twoje poczucie własnej wartości.</li>
                        <li>
                            Wszystkim będziesz się przejmował, staniesz się bardzo emocjonalny (ale pod względem negatywnych emocji – łatwiejsze wpadanie w złość, strachliwość, itp.).</li>
                        <li>
                            Przestaniesz dostrzegać dobre strony ludzi, będziesz wszędzie widział wady, będziesz cały czas krytykował siebie i innych.</li>
                        <li>
                            Będzie Ci zależało, żeby ludzie doceniali Cię, akceptowali, rozumieli. Każde odstępstwo wywoła złość, zawód, smutek, zmniejszy Twoją pewność siebie.</li>
                        <li>
                            Potrzebujesz coraz więcej, by się podniecić, coraz silniejszej stymulacji, ostrzejszych obrazów, kobiety na co dzień przestają Cię podniecać, przestają Ci się podobać, szukasz w nich tylko wad, by mieć wymówkę do nie nawiązywania relacji pomimo czasem oczywistych sygnałów zainteresowania z jej strony.</li>
                        <li>
                            Będziesz odmawiał seksu, nawet, gdy podejdą do Ciebie i Ci go wprost zaproponują biseksualne kobiety.</li>
                        <li>
                            Przestaniesz postrzegać siebie jako kogoś wartościowego, ciekawego, wartego poznania, Twoje towarzystwo nie będzie dla Ciebie przyjemne jak i Twoje myśli, będziesz uciekał od prawdziwego siebie, uciekniesz w fantazjowanie, wszystko będzie wydawało się ciekawsze i lepsze od Ciebie.</li>
                        <li>
                            Wszystkie czynności zaczną sprawiać Ci trudności, zaczniesz je dłużej wykonywać, może dojść do tego, że ukończenie studiów zajmie Ci dodatkowe 2 lata, a może i więcej.</li>
                        <li>
                            Zwiększy się prokrastynacja, będziesz odkładał sprawy w nieskończoność, nawet te ważne – opłacanie rachunków, sprawy związane z uczelnią, pracą.</li>
                        <li>
                            Przez sposób, w jaki zaczniesz się zachowywać – wyobcowany, przygnębiony, etc. będziesz miał ogromne trudności w utrzymaniu szczęśliwego związku lub w ogóle znalezienie dziewczyny/partnerki, jeśli nie miałeś kogoś przy sobie przez większość czasu to już wiesz dlaczego.</li>
                        <li>
                            Niezależnie ile pracy i wysiłku włożysz w różne czynności, będziesz miał wrażenie, że nic nie osiągasz.</li>
                        <li>
                            Życie będzie się wydawać męczarnią, zmaganiem, walką.</li>
                        <li>
                            Będziesz często nieobecny, myślami dryfować będziesz w świat fantazji, inni będą to widzieć.</li>
                        <li>
                            Nie będziesz się wysypiać, będziesz miał kłopoty z zasypianiem, trwające nawet kilka godzin, przełoży się to też na wory pod oczami, bladość, odwodnienie, podrażnienie skóry (szczególnie okolic intymnych i tych, które golisz), podatność na wysypkę.</li>
                        <li>
                            Będziesz czuł nieodpartą chęć do masturbacji wszędzie aż do osiągnięcia orgazmu – w pracy, w samochodzie, gdziekolwiek, co wywołać może uczucie wstydu i zażenowania.</li>
                        <li>
                            Obniży się Twoja zdolność do podejmowania racjonalnych decyzji.</li>
                        <li>
                            Obniży się Twoja wydajność w pracy, pogorszą się oceny, przestaną Cię obchodzić dobre wyniki, przestaniesz dbać o siebie i innych, Twoja przyszłość przestanie być ważna, zaczniesz zaniedbywać swój wygląd, higienę.</li>
                    </ol>
                </div>

                <div class="article-column-1_2">
                    <ol start="56">
                        <li>
                            Piękne kobiety przestaną Cię podniecać. Będziesz myślał, że są śliczne, że są spełnieniem marzeń ale poza tym nie pojawi się nic więcej, ani erekcja ani fantazje związane z nimi. Pojawi się chęć masturbacji do filmu z aktorkami zbliżonymi urodą i kształtami do tych kobiet. Ale nie z samymi kobietami.</li>
                        <li>Będzie moment, że po masturbacji będziesz czuł duże bóle głowy, żołądka, może się okazać, że potrzebować będziesz nawet kilku dni na regenerację, by normalnie funkcjonować.</li>
                        <li>
                            Zaczniesz funkcjonować jakby porno było jedynym powodem, dla którego wstajesz z łóżka. Gdy nie masz do niego dostępu zaczniesz być rozdrażniony, nie będziesz widział sensu w robieniu czegokolwiek.</li>
                        <li>
                            Będziesz miał trudności w nawiązywaniu i utrzymywaniu kontaktu wzrokowego.</li>
                        <li>
                            Wyrobi Ci się awersja do dotykania innych i bycia dotykanym. Będzie to dla Ciebie nienaturalne, dziwne, dotyk drugiego mężczyzny zacznie być krępujący.</li>
                        <li>
                            Wszystko zacznie mieć podteksty seksualne.</li>
                        <li>
                            Zawsze będziesz myślał o seksie, dążył do żartu na ten temat, wszystko zacznie się obracać wokół seksu.</li>
                        <li>
                            Możliwe, że padniesz w paranoję – każdy nieszkodliwy żart na Twój temat zacznie wydawać Ci się jako osobista obraza, mało co będzie Cię śmieszyć, stracisz poczucie humoru, nawet śmianie będzie dla Ciebie krępujące.</li>
                        <li>
                            Jakakolwiek ekspozycja Ciebie będzie niezwykle krępująca i wstydliwa, kaszlnięcie czy kichnięcie publiczne (np. na zajęciach).</li>
                        <li>
                            Będziesz się męczył, żeby tylko nie przeszkodzić komuś swoim zachowaniem, wszyscy zaczną wydawać Ci się ważniejsi od Ciebie, Twoje dobro przestanie się dla Ciebie liczyć, przestaniesz walczyć o swoje.</li>
                        <li>
                            Zaczniesz tłumić w sobie gniew, agresję, negatywne emocje i zaczniesz być podatny na wybuchy tych emocji z błahych przyczyn. Przestaniesz kontrolować siebie, będziesz chodzącą bombą zegarową. Zaczniesz się bać swoich reakcji. Od konfrontacji nawet najmniejszych problemów będziesz preferował ucieczkę. Każdy problem wyda Ci się niemożliwy do rozwiązania.</li>
                        <li>
                            Pojawią się myśli samobójcze.</li>
                        <li>
                            Zmniejszy się Twoja masa mięśniowa, zwiększy ilość tkanki tłuszczowej (przez zmniejszoną ilość testosteronu w organizmie). Zaczniesz mieć skurcze mięśni, bóle mięśni, może nawet dojść do zwyrodnienia nadgarstka od trzymania myszki w niezmiennej pozycji przez wiele godzin dziennie.</li>
                        <li>
                            Trudno będzie Ci podejmować racjonalne decyzje na najprostsze tematy (czy potrzebuję czegoś?) i decyzje w ogóle (jaki kolor szczoteczki do zębów wybrać?).</li>
                        <li>
                            Jakakolwiek czynność odwlekająca oglądanie pornografii wywoła u Ciebie atak agresji (nawet jeżeli będzie to Twoje dziecko proszące o kilka minut uwagi, np. pomoc w odrabianiu lekcji).</li>
                        <li>
                            Kiedy zaczynasz robić coraz mniej i rzadziej rzeczy własnymi rękoma, np. wolisz zamówisz pizzę niż przygotować sobie obiad, wolisz porozmawiać z kimś na czacie niż spotkać się w 4 oczy.</li>
                        <li>
                            Wokół oczu mogą pojawić Ci się ciemne okręgi (zwane oczami szopa).</li>
                        <li>
                            Będziesz coraz rzadziej wychodził z domu, udanie się w miejsce pełne ludzi będzie bardzo stresujące.</li>
                        <li>
                            Zaczniesz odczuwać przytłaczającą samotność, będziesz odmawiał spotkań ze znajomymi, gdyż jedynym tematem, o którym chciałbyś rozmawiać jest Twój problem (który zdał się wypełniać całe Twoje życie, stał się większą częścią Twojego życia) ale boisz się lub wstydzisz otworzyć przed innymi.</li>
                        <li>
                            Zaczniesz oceniać kobiety jedynie pod względem ich atrybutów fizycznych, reszta przestanie Cię interesować. Będziesz cały czas porównywał je do aktorek porno, co samo w sobie jest bardzo krzywdzące.</li>
                        <li>
                            Oglądanie porno ze scenami heteroseksualnymi może przeobrazić się w zainteresowanie filmami, gdzie penetrowani są mężczyźni przez kobiety transgenderowe z męskimi narządami płciowymi lub innych mężczyzn.</li>
                        <li>
                            Potrzeba coraz silniejszej stymulacji może przerodzić się w potrzebę oglądania pornografii ze zwierzętami, nieletnimi, starszymi osobami oraz innymi ekstremalnymi formami jak np. gwałt, okaleczanie i wiele innych.</li>
                        <li>
                            Krótki orgazm przestanie sprawiać przyjemność, będzie tylko formą chwilowej ulgi w podłym samopoczuciu.</li>
                        <li>
                            Skaleczenia, obtarcia i inne urazy fizyczne będą goić się o wiele wolniej (czasem nawet do kilku miesięcy zamiast tygodni).</li>
                        <li>
                            Sucha skóra, częsta suchość w gardle, napady kaszlu (szczególnie w nocy), suche oczy łatwo podrażniane od słońca, łatwiej pękające naczyńka krwionośne, możliwość pogorszenia wzroku.</li>
                        <li>
                            Nie będziesz czuł się atrakcyjny dla kobiet nawet, gdy zrobisz wszystko, żeby tak się czuć (nowa modna fryzura, eleganckie ubranie, zadbany zarost, paznokcie, oddech, zdrowa cera), twój seksapil będzie zerowy.</li>
                        <li>
                            Wszystko będzie wydawać się nierealne, Ty też, każdy moment nie będzie ważny, życie wydawać się będzie nudnym, starym filmem bez kolorów.</li>
                        <li>
                            Zdjęcie nagiej kobiety będzie bardziej Cię podniecać niż ta kobieta naga koło Ciebie.</li>
                        <li>
                            Może dojść do tego, że będziesz chciał nagrywać seks z kobietą, żeby potem móc oglądać ten film i masturbować się do niego.</li>
                        <li>
                            Może dojść do sytuacji, że zacznie pociągać Cię sama sperma, zacznie podniecać Cię widok ejakulacji, będziesz rozmyślał nad jej smakiem i zapachem, co może doprowadzić, że spróbujesz doprowadzić do orgazmu innego mężczyznę w rzeczywistości, innymi słowy – zaczną pociągać Cię mężczyźni.</li>
                        <li>
                            Trudności i bóle przy oddawaniu moczu, oddawanie moczu dwiema strugami.</li>
                        <li>
                            Bóle pleców, ramion, szyi.</li>
                        <li>
                            Palące końcówki palców, szczególnie kciuków.</li>
                        <li>
                            Krwawiące hemoroidy.</li>
                        <li>
                            Problemy z zasypianiem, bezsenność.</li>
                        <li>
                            Zaczniesz zakochiwać się w obrazkach i filmach, postaciach z filmów animowanych.</li>
                        <li>
                            Potrzeba coraz silniejszej stymulacji objawia się również jako potrzeba coraz mocniejszego ściskania penisa w czasie masturbacji, co może doprowadzić do podrażnień skóry, obtarć i infekcji oraz krwi z moczu.</li>
                        <li>
                            Twoja kobieta stanie się tylko kolejnym narzędziem do masturbacji przy jej pomocy.</li>
                        <li>
                            Spojrzenie w oczach staje się tak samo puste jak umysł, zachowanie, emocje.</li>
                        <li>
                            Nie tylko człowiek odczuwa ciągłe zmęczenie i senność ale również wszelkie, nawet nowe i ekscytujące działania, których się podejmuje nudzą się bardzo szybko, wyczerpują lub człowiek zaczyna ich unikać.</li>
                        <li>
                            Wykonanie telefonu gdziekolwiek będzie bardzo stresujące, będziesz unikał telefonowania, szukał wymówek, by nie musieć kontaktować się z kimkolwiek.</li>
                        <li>
                            Porzucisz hobby, nawet grupowe (jak granie na instrumencie w zespole), przestaną sprawiać Ci przyjemność jaką sprawiały kiedyś.</li>
                        <li>
                            Jeśli straciłeś już lata na to uzależnienie to jeżeli nie podejmiesz działania stracisz kolejne całe lata przy czym problem będzie się pogłębiał.</li>
                        <li>
                            Możesz odczuwać obrzydzenie tym co robisz do samego siebie. Wstręt do samego siebie!</li>
                        <li>
                            Wbrew pozorom coraz silniejsza masturbacja powoduje, że penis staje się zeschnięty, nawet posiniaczony, skóra jest uszkadzana, receptory bodźców zanikają. Jego stan się pogarsza, staje się cieńszy, słabszy. To, co się z nim robi to nie zdrowa stymulacja tylko poniewieranie, robienie krzywdy!</li>
                        <li>
                            Zaczniesz obsesyjnie kontrolować wszystko w swoim życiu do tego stopnia, że zacznie Cię drażnić dowolna zmiana tego, co uważasz za normalne i „takie, jakie powinno być” – nawet pożyczenie członkowi rodziny książki z półki w Twoim pokoju. Brak tej książki będzie Cię drażnił – bo przestanie być „idealnie”.</li>
                        <li>
                            Ataki paniki.</li>
                        <li>
                            Objawy fizyczne takie jak – ucisk w klatce piersiowej, podwyższone ciśnienie krwi, podwyższone tętno, krwawienia z nosa, bolące ścięgna, drżące dłonie, garbienie się, zawroty głowy, pieczenie skóry twarzy.</li>
                        <li>
                            Mogą nawet pojawić się żylaki na penisie.</li>
                        <li>
                            Różne lęki, które w sobie nosimy nasilają się, np. w postaci fobii.</li>
                        <li>
                            Są sytuacje, że rezygnujesz (albo uciekasz) od seksu z kobietą, a potem masturbujesz się fantazjując o tej kobiecie.</li>
                        <li>
                            Mowa staje się niewyraźna, może wystąpić jąkanie.</li>
                        <li>
                            Na całym ciele mogą pojawiać się krosty, na twarzy pryszcze.</li>
                        <li>
                            Płacz, uczucie rozpaczy w losowych momentach, szczególnie wieczorami i w nocy.</li>
                        <li>
                            Napięte mięśnie, napięte całe ciało, częste skurcze (szczególnie łydek i ud).</li>
                        <li>
                            Porno w postaci filmów animowanych zaczyna podniecać bardziej, niż porno z żywymi ludźmi.</li>
                    </ol>
                </div>
                <div style="clear:both;"></div>

            </div>
        </article>
        <div id="wop-main-opinie" class="wop-main-rozdzielacz"></div>
        <article>
            <div class="wop-main-naglowek">
                <span>OPINIE O PROGRAMIE</span>
            </div>
            <div class="article-body" style="margin-top:100px;">
                <section id="wop-main-opinie-slajdy-wrapper">
                    <ul id="wop-main-opinie-slajdy-container">

                        <button class="slide-arrow" id="opinie-slide-arrow-prev">&#8249;</button>
                        <button class="slide-arrow" id="opinie-slide-arrow-next">&#8250;</button>

                        <li class="wop-main-opinie-slajd">
                            <h1>Opinia 1</h1>
                        </li>
                        <li class="wop-main-opinie-slajd">
                            <h1>Opinia 2</h1>

                        </li>
                        <li class="wop-main-opinie-slajd">
                            <h1>Opinia 3</h1>

                        </li>
                        <li class="wop-main-opinie-slajd">
                            <h1>Opinia 4</h1>

                        </li>
                        <li class="wop-main-opinie-slajd">
                            <h1>Opinia 5</h1>

                        </li>
                        <li class="wop-main-opinie-slajd">
                            <h1>Opinia 6</h1>

                        </li>

                    </ul>

                </section>
            </div>
        </article>


    </main>

    <?php include $this->ustanow("czesci/_footer.php"); ?>