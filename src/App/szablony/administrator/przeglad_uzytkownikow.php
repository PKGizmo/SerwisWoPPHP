<?php include $this->ustanow("czesci/_header.php"); ?>

<body>
    <?php include $this->ustanow("czesci/_stickyMenu.php"); ?>
    <div>
        <h1>Przegląd użytkowników</h1>
        <?php foreach ($uzytkownicy as $uzytkownik) : ?>
            <h2><?php echo e($uzytkownik['id']) . "<br>" . e($uzytkownik['imie']) . "<br>" . e($uzytkownik['email']) ?>
            </h2>
        <?php endforeach; ?>

    </div>

    <?php include $this->ustanow("czesci/_footer.php"); ?>