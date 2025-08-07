CREATE TABLE IF NOT EXISTS uzytkownicy(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    imie varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    haslo varchar(255) NOT NULL,
    wiek tinyint(3) unsigned NOT NULL,
    pochodzenie varchar(255) NOT NULL,
    social_media_url varchar(255) NOT NULL,
    typ_konta tinyint(1) unsigned NOT NULL DEFAULT 1,
    aktywne tinyint(1) NOT NULL DEFAULT 0,
    data_utworzenia_konta datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    data_modyfikacji_konta datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY(id),
    UNIQUE KEY (email),
    FOREIGN KEY (typ_konta) REFERENCES typy_kont(id)
);

CREATE TABLE IF NOT EXISTS typy_kont(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    typ varchar(255) NOT NULL,
    opis_typu_konta varchar(255) NOT NULL,
    uprawnienia varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

/*INSERT INTO typy_kont(id, typ, opis_typu_konta, uprawnienia) 
VALUES (1, 1, "Administrator", "Całkowite");
INSERT INTO typy_kont(typ, opis_typu_konta, uprawnienia) 
VALUES (2, 2, "Normalne. Umożliwia czytanie i komentowanie dużej części artykułów.", "Podstawowe");
INSERT INTO typy_kont(typ, opis_typu_konta, uprawnienia) 
VALUES (3, 3, "Rozszerzone. Umożliwia czytanie i komentowanie wszystkich artykułów. Wymaga comiesięcznej opłaty w celu przedłużenia",
 "Rozszerzone");*/

CREATE TABLE IF NOT EXISTS artykuly(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    id_autora bigint(20) unsigned NOT NULL,
    tytul varchar(255) NOT NULL,
    streszczenie varchar(255) NOT NULL,
    tresc MEDIUMTEXT NOT NULL,
    typ tinyint(1) NOT NULL,
    data_utworzenia datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    data_modyfikacji datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    link varchar(255) NOT NULL,
    stan tinyint(1) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(id_autora) REFERENCES uzytkownicy(id),
    UNIQUE KEY(link)
);

CREATE TABLE IF NOT EXISTS komentarze(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    id_uzytkownika bigint(20) unsigned NOT NULL,
    id_artykulu bigint(20) unsigned NOT NULL,
    id_komentarza bigint(20) unsigned NOT NULL DEFAULT 0,
    stan tinyint(1) unsigned DEFAULT 0,
    tresc MEDIUMTEXT NOT NULL,
    data_utworzenia datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    data_modyfikacji datetime NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id),
    FOREIGN KEY(id_uzytkownika) REFERENCES uzytkownicy(id)
);

CREATE TABLE IF NOT EXISTS kategorie_opisy(
    id tinyint(2) unsigned NOT NULL,
    nazwa varchar(255) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY (nazwa)
);

CREATE TABLE IF NOT EXISTS kategorie(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    id_artykulu bigint(20) unsigned NOT NULL,
    kategoria tinyint(2) unsigned NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(id_artykulu) REFERENCES artykuly(id),
    FOREIGN KEY(kategoria) REFERENCES kategorie_opisy(id)
);

CREATE TABLE IF NOT EXISTS aktywacja_konta(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    id_uzytkownika bigint(20) unsigned NOT NULL,
    token varchar(255) NOT NULL,
    aktywowano tinyint(1) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY(id_uzytkownika) REFERENCES uzytkownicy(id)
);

CREATE TABLE IF NOT EXISTS obrazy_blog(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    oryginalna_nazwa_pliku varchar(255) NOT NULL,
    nowa_nazwa_pliku varchar(255) NOT NULL,
    typ_mediow varchar(255) NOT NULL,
    id_artykulu bigint(20) unsigned NOT NULL,
    czy_glowny tinyint(1) unsigned NOT NULL DEFAULT 1,
    sciezka varchar(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(id_artykulu) REFERENCES artykuly(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS obrazy_uzytkownikow(
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    id_uzytkownika bigint(20) unsigned NOT NULL,
    oryginalna_nazwa_pliku varchar(255) NOT NULL,
    nowa_nazwa_pliku varchar(255) NOT NULL,
    typ_mediow varchar(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY(id_uzytkownika) REFERENCES uzytkownicy(id) ON DELETE CASCADE
);


INSERT INTO kategorie_opisy VALUES(1, "Uzależnienie");
INSERT INTO kategorie_opisy VALUES(2, "Umysł");
INSERT INTO kategorie_opisy VALUES(3, "Seria: Wzorce");
INSERT INTO kategorie_opisy VALUES(4, "Emocje");
INSERT INTO kategorie_opisy VALUES(5, "Seksualność");


