<?php

declare(strict_types=1);

namespace Framework;

use Framework\Kontrakty\RegulyInterfejs;
use Framework\Wyjatki\WyjatkiWalidacji;

class Walidator
{
    private array $reguly = [];

    public function dodaj(string $alias, RegulyInterfejs $regula)
    {
        $this->reguly[$alias] = $regula;
    }

    public function waliduj(array $daneFormularza, array $pola)
    {
        $bledy = [];

        foreach ($pola as $poleFormularza => $reguly) {
            foreach ($reguly as $regula) {
                $parametryReguly = [];


                if (str_contains($regula, ':')) {
                    [$regula, $parametryReguly] = explode(':', $regula, 2);
                    $parametryReguly = explode(',', $parametryReguly);
                }

                $regulaWalidatora = $this->reguly[$regula];

                if ($regulaWalidatora->waliduj($daneFormularza, $poleFormularza, $parametryReguly)) {
                    continue;
                }
                $bledy[$poleFormularza][] = $regulaWalidatora->wiadomoscWalidacji(
                    $daneFormularza,
                    $poleFormularza,
                    $parametryReguly
                );
            }
        }

        if (count($bledy)) {
            throw new WyjatkiWalidacji($bledy);
        }
    }
}
