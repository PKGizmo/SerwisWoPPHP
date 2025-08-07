<?php include $this->ustanow("czesci/_header.php"); ?>
<?php include $this->ustanow("czesci/_logoNazwa.php"); ?>
</div>
<?php include $this->ustanow("czesci/_stickyMenu.php"); ?>
<?php include $this->ustanow("czesci/_onLoad.php"); ?>

<main>
    <a class="scrollup"><i class="icon-up-open"></i></a>
    <section>
        <div class="wop-rejestracja-naglowek">
            <span>Rejestracja w serwisie WoP</span>
        </div>
        <form method="POST">
            <?php include $this->ustanow("czesci/_csrf.php"); ?>
            <div class="register-body">

                <h1>Imię/pseudonim</h1>
                <input value="<?php echo e($stareDaneFormularza['imie'] ?? ''); ?>" name="imie" type="text" class="register-input" />
                <?php if (array_key_exists('imie', $bledy)) : ?>
                    <div class="blad-formularza">
                        <?php foreach ($bledy['imie'] as $blad) echo e($blad) . "<br>"; ?>
                    </div>
                <?php endif; ?>

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

                <h1>Powtórz hasło</h1>
                <input name="potwierdzHaslo" type="password" class="register-password" />
                <?php if (array_key_exists('potwierdzHaslo', $bledy)) : ?>
                    <div class="blad-formularza">
                        <?php foreach ($bledy['potwierdzHaslo'] as $blad) echo e($blad) . "<br>"; ?>
                    </div>
                <?php endif; ?>

                <h1>Wiek</h1>
                <input value="<?php echo e($stareDaneFormularza['wiek'] ?? ''); ?>" name="wiek" type="number" class="register-input" />
                <?php if (array_key_exists('wiek', $bledy)) : ?>
                    <div class="blad-formularza">
                        <?php foreach ($bledy['wiek'] as $blad) echo e($blad) . "<br>"; ?>
                    </div>
                <?php endif; ?>

                <h1>Pochodzenie</h1>
                <select name="pochodzenie" class="register-select">
                    <option value="Polska">Polska</option>
                    <option value="USA" <?php if (array_key_exists('pochodzenie', $stareDaneFormularza)) : ?>
                        <?php echo $stareDaneFormularza['pochodzenie'] === "USA" ? 'selected' : ''; ?>
                        <?php endif; ?>>USA</option>
                    <option value="InneEuropa" <?php if (array_key_exists('pochodzenie', $stareDaneFormularza)) : ?>
                        <?php echo $stareDaneFormularza['pochodzenie'] === "InneEuropa" ? 'selected' : ''; ?>
                        <?php endif; ?>>Inne z Europy</option>
                    <option value="Inne">Inne</option>
                </select>
                <?php if (array_key_exists('pochodzenie', $bledy)) : ?>
                    <div class="blad-formularza">
                        <?php foreach ($bledy['pochodzenie'] as $blad) echo e($blad) . "<br>"; ?>
                    </div>
                <?php endif; ?>

                <h1>Link do social mediów</h1>
                <h5>(Opcjonalny)</h5>
                <input value="<?php echo e($stareDaneFormularza['socialMediaURL'] ?? ''); ?>" name="socialMediaURL" type="text" placeholder="http://www.adres.pl" class="register-input" />
                <?php if (array_key_exists('socialMediaURL', $bledy)) : ?>
                    <div class="blad-formularza">
                        <?php foreach ($bledy['socialMediaURL'] as $blad) echo e($blad) . "<br>"; ?>
                    </div>
                <?php endif; ?>

                <label>
                    <div class="register-checkbox">
                        <input <?php echo $stareDaneFormularza['regulamin'] ?? false ? 'checked' : ''; ?> name="regulamin" class="register-checkbox-checkbox" type="checkbox" />
                        <h2>Akceptuję regulamin serwisu WoP.</h2>
                    </div>
                    <?php if (array_key_exists('regulamin', $bledy)) : ?>
                        <div class="blad-formularza">
                            <?php foreach ($bledy['regulamin'] as $blad) echo e($blad) . "<br>"; ?>
                        </div>
                    <?php endif; ?>
                </label>

                <label>
                    <div class="register-checkbox">
                        <input <?php echo $stareDaneFormularza['zasady'] ?? false ? 'checked' : ''; ?> name="zasady" class="register-checkbox-checkbox" type="checkbox" />
                        <h2>Akceptuję zasady bloga WoP.</h2>
                    </div>
                    <?php if (array_key_exists('zasady', $bledy)) : ?>
                        <div class="blad-formularza">
                            <?php foreach ($bledy['zasady'] as $blad) echo e($blad) . "<br>"; ?>
                        </div>
                    <?php endif; ?>
                </label>

                <button class="register-submit" type="submit">
                    Załóż konto
                </button>
            </div>

        </form>
    </section>
</main>

<?php include $this->ustanow("czesci/_footer.php"); ?>