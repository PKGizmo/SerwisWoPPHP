<?php

declare(strict_types=1);

namespace App\Uslugi;

use Framework\BazaDanych;
use Framework\Wyjatki\WyjatkiWalidacji;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UslugaMaila
{
    public function __construct(private BazaDanych $db) {}

    private function wygenerujToken($dl = 32)
    {
        return substr(md5(openssl_random_pseudo_bytes(20)), -$dl);
    }

    public function wyslijMailaAktywacyjnegoKonta(array $daneFormularza, int $id_uzytkownika)
    {
        $output = '';

        $emailUzytkownika = $daneFormularza['email'];
        //$haslo = $daneFormularza['haslo'];
        //$haslo = password_hash($daneFormularza['haslo'], PASSWORD_BCRYPT, ['cost' => 12]);

        $token = $this->wygenerujToken(10);
        $tokenHash = password_hash($token, PASSWORD_BCRYPT, ['cost' => 12]);

        $zapytanie = $this->db->zapytanie("INSERT INTO aktywacja_konta(id_uzytkownika, token) 
        VALUES(:id_uzytkownika, :token)", [
            'id_uzytkownika' => $id_uzytkownika,
            'token' => $token
        ]);

        $mail = new PHPMailer(true);

        try {
            $mail->setFrom('wolnoscodporno@gmail.com', 'Serwis Wolność od Porno');
            $mail->CharSet = 'UTF-8';
            $mail->addAddress($emailUzytkownika);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; //gethostbyname('smtp.gmail.com');
            $mail->SMTPAuth = true;

            $mail->Port = 465;
            $mail->SMTPDebug = 2;
            //$mail->SMTPSecure = 'tls';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "test@gmail.com";
            $mail->Password = "test";

            $mail->isHTML(true);
            $mail->Subject = '[Serwis WoP] - Aktywacja konta';
            $mail->Body = '<div style="font-size:32px;">Aktywuj swoje konto klikając na poniższy link:</div>
            <div style="font-size:48px"><a href="http://serwiswop.local/weryfikacja?email=' . $emailUzytkownika . '&token=' . $tokenHash . '">Aktywacja konta</a></div>
            <br><br>Wiadomość automatyczna. Proszę na nią nie odpowiadać!';

            $mail->send();

            $output = 'Wysłano mail z linkiem aktywacyjnym!';
        } catch (Exception $e) {
            $output = $mail->ErrorInfo;
        }
    }
}
