<?php include $this->ustanow("czesci/_header.php"); ?>

<body>
    <?php include $this->ustanow("czesci/_logoNazwa.php"); ?>
    </div>
    <?php include $this->ustanow("czesci/_stickyMenu.php"); ?>
    <?php include $this->ustanow("czesci/_onLoad.php"); ?>
    <main>
        <section>
            <div class="wop-rejestracja-naglowek">
                <span>Logowanie w serwisie WoP</span>
            </div>
            <form method="POST">
                <?php include $this->ustanow("czesci/_csrf.php"); ?>
                <div class="register-body">
                    <h1>Adres e-mail</h1>
                    <input value="<?php echo e($stareDaneFormularza['email'] ?? ''); ?>" name="email" type="email" placeholder="konto@domena.pl" class="register-input" />
                    <?php if (array_key_exists('email', $bledy)) : ?>
                        <div class="blad-formularza">
                            <?php foreach ($bledy['email'] as $blad) echo e($blad) . "<br>"; ?>
                        </div>
                    <?php endif; ?>

                    <h1>Hasło</h1>
                    <input name="haslo" type="password" class="register-password" />
                    <?php if (array_key_exists('haslo', $bledy)) : ?>
                        <div class="blad-formularza">
                            <?php foreach ($bledy['haslo'] as $blad) echo e($blad) . "<br>"; ?>
                        </div>
                    <?php endif; ?>


                    <button class="register-submit margin-top-32" type="submit">
                        Zaloguj się
                    </button>
                </div>

            </form>
        </section>
    </main>

    <?php include $this->ustanow("czesci/_footer.php"); ?>