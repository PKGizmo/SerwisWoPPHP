<?php

declare(strict_types=1);

namespace App\ProgramyPosredniczace;

use Framework\Kontrakty\PPInterfejs;
use Framework\Wyjatki\WyjatkiWalidacji;

class WyjatkiWalidacjiPP implements PPInterfejs
{
    public function przetwarzaj(callable $nastepny)
    {
        try {
            $nastepny();
        } catch (WyjatkiWalidacji $w) {
            $stareDaneFormularza = $_POST;

            $wylaczonePola = ['haslo', 'potwierdzHaslo'];
            $sformatowaneDaneFormularza = array_diff_key(
                $stareDaneFormularza,
                array_flip($wylaczonePola)
            );

            $_SESSION['bledy'] = $w->bledy;
            $_SESSION['stareDaneFormularza'] = $sformatowaneDaneFormularza;

            $odeslanie = $_SERVER['HTTP_REFERER'] ?? '/';

            przekierujDo($odeslanie);
        }
    }
}
