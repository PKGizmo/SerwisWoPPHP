<?php

declare(strict_types=1);

namespace App\Konfig;

use Framework\App;
use App\Kontrolery\{
    GlownaKontroler,
    AutorKontroler,
    RejestracjaKontroler,
    LoginKontroler,
    KontoKontroler,
    BlogKontroler,
    ArtykulKontroler,
    PoRejestracjiKontroler,
    WeryfikacjaKontroler
};
use App\ProgramyPosredniczace\{
    ZalogowanieWymaganePP,
    TylkoNiezalogowanyPP,
    TylkoAdministratorPP
};

function zarejestrujTrase(App $app)
{
    //Dodajemy trasy do routera
    $app->get('/', [GlownaKontroler::class, 'glowna']);
    $app->get('/autor', [AutorKontroler::class, 'autor']);
    $app->get('/rejestracja', [RejestracjaKontroler::class, 'rejestracjaSzablon'])->dodajPPTrasie(TylkoNiezalogowanyPP::class);
    $app->post('/rejestracja', [RejestracjaKontroler::class, 'rejestracja'])->dodajPPTrasie(TylkoNiezalogowanyPP::class);
    $app->get('/login', [LoginKontroler::class, 'loginSzablon'])->dodajPPTrasie(TylkoNiezalogowanyPP::class);
    $app->post('/login', [LoginKontroler::class, 'login'])->dodajPPTrasie(TylkoNiezalogowanyPP::class);
    $app->get('/wyloguj', [RejestracjaKontroler::class, 'wyloguj'])->dodajPPTrasie(ZalogowanieWymaganePP::class);
    $app->get('/konto', [KontoKontroler::class, 'kontoSzablon'])->dodajPPTrasie(ZalogowanieWymaganePP::class);
    $app->get('/blog', [BlogKontroler::class, 'blogSzablon']);
    $app->get('/napisz_artykul', [ArtykulKontroler::class, 'napiszArtykul'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->post('/napisz_artykul', [ArtykulKontroler::class, 'zapiszArtykul'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->get('/edytuj_artykul/{link_a_rok}/{link_a_miesiac}/{link_a_tytul}/', [ArtykulKontroler::class, 'edytujArtykul'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->get('/blog/{link_a_rok}/{link_a_miesiac}/{link_a_tytul}/', [BlogKontroler::class, 'czytajArtykul']);
    $app->get('/poRejestracji', [PoRejestracjiKontroler::class, 'poRejestracjiSzablon']);
    $app->get('/weryfikacja', [WeryfikacjaKontroler::class, 'weryfikacjaSzablon']);
    $app->post('/nadpisz_artykul/{id}', [ArtykulKontroler::class, 'aktualizuj_artykul'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->get('/edytuj_kategorie', [KontoKontroler::class, 'kategorieSzablon'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->post('/zapisz_kategorie', [KontoKontroler::class, 'zapiszKategorie'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->post('/dodaj_kategorie', [KontoKontroler::class, 'dodajKategorie'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->post('/awatar', [KontoKontroler::class, 'awatar'])->dodajPPTrasie(ZalogowanieWymaganePP::class);
    $app->post('/napisz_komentarz/{id_artykulu}/{id_komentarza}/', [ArtykulKontroler::class, 'napiszKomentarz'])->dodajPPTrasie(ZalogowanieWymaganePP::class);
    $app->post('/zatwierdz_komentarz/{id_artykulu}/{id_komentarza}/', [ArtykulKontroler::class, 'zatwierdzKomentarz'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->post('/anuluj_komentarz/{id_artykulu}/{id_komentarza}/', [ArtykulKontroler::class, 'anulujKomentarz'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->get('/przeglad_uzytkownikow', [KontoKontroler::class, 'przegladUzytkownikowSzablon'])->dodajPPTrasie(TylkoAdministratorPP::class);
    $app->get('/blog/{link_arch_rok}/', [BlogKontroler::class, 'archiwumSzablon']);
    $app->get('/blog/{link_arch_rok}/{link_arch_miesiac}/', [BlogKontroler::class, 'archiwumSzablon']);
    $app->get('/kategoria/{kat_id}/', [BlogKontroler::class, 'kategoriaSzablon']);
}
