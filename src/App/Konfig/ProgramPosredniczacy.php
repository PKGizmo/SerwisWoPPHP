<?php

declare(strict_types=1);

namespace App\Konfig;

use Framework\App;
use App\ProgramyPosredniczace\{
    DaneSzablonowPP,
    WyjatkiWalidacjiPP,
    SesjePP,
    FlashPP,
    CsrfDowodPP,
    OchronaCsrfPP,
};

function zarejestrujProgramPosredniczacy(App $app)
{
    $app->dodajProgramPosredniczacy(OchronaCsrfPP::class);
    $app->dodajProgramPosredniczacy(CsrfDowodPP::class);
    $app->dodajProgramPosredniczacy(DaneSzablonowPP::class);
    $app->dodajProgramPosredniczacy(WyjatkiWalidacjiPP::class);
    $app->dodajProgramPosredniczacy(FlashPP::class);
    $app->dodajProgramPosredniczacy(SesjePP::class);
}
