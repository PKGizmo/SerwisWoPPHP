<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title><?php echo e($tytul); ?> - serwis Wolność od Porno</title>
    <meta name="description" content="Uwolnij się od niewoli uzależnienia!">
    <meta name="keywords" content="pornografia uzależnienie nałóg masturbacja">
    <meta name="author" content="Piotr 'Kruk' Karwacki">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="/assets/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="/assets/css/fontello.css" rel="stylesheet" type="text/css" />
    <script src="http://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/assets/jquery.scrollTo.min.js"></script>

</head>

<script type="text/javascript">
    let stickyNav;

    jQuery(function($) {
        //zresetowanie scrolla
        //$.scrollTo(0);

        //$('#link3').click(function() { $.scrollTo($('#maskicrt'), 500); });
        $('.scrollup').click(function() {
            $.scrollTo($('body'), 1000);
        });
    });

    //pokaż przycisk podczas przewijania
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) $('.scrollup').fadeIn();
        else $('.scrollup').fadeOut();
    });
</script>