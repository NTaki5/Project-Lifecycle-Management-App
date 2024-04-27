# Project-Lifecycle-Management-App
Államvizsga

Az applikacio egy olyan felulet ami lehetoseget biztosit felregisztralo cegeknek, hogy projekteket hozzanak letre es hogy meghivjak a projekthez tartozo klienseket a feluletre. Ezaltal letrejon egy “szoba” a ceg es a kliens kozott, amely elosegiti a kommunikaciot, a relevans dokumentumok tarolasat es az ugyfelszolgalati folyamatokat.

Egy web alapu alkalmazasrol van szo, hogy barki szamara elerheto legyen anelkul, hogy valamit le kellene tolteni. Javasolt technologiak: Angular 15, Java Spring Boot, PostgreSQL Adatbazis

A rendszert ket nagy reszre osszuk logikai szempontbol: **cegek modul es kliens modul**.

**Funkció lista**
**Cegek modul**
    A ceg fel tud regisztralni a platformra, amennyiben kitolti a kotelezo ceges adatokat.
    A ceg felregisztralasakor letrejon egy Admin felhasznalo is, aki ezutan email cim es jelszo alapjan barmikor be tud jelentkezni az aplikacioba
    A felhasznaloknak van “Elfelejtettem a jelszavam” lehetoseguk is, amely altal ujra tudjak allitani a jelszavukat
    Bejelentkezes utan az admin felhasznalo egy “Dashboardot” lat a legrelevansabb informaciokkal, mint peldaul projektek, felhasznalok, ujdonsagok
    Az admin felhasznalo meg tudja hivni a kollegait a feluletre, akik egy email ertesitesen keresztul aktivalni tudjak a felhasznaloikat es be tudnak jelentkezni.
    A ceg adminja projekteket tud letrehozni, amelynek megadja a nevet, idotartamat es kivalassza a projekthez relevans munkatarsakat.
    A ceg adminja egy letrehozott projekthez tud kuldeni meghivot a kliensnek es ezaltal letrejon a “szoba” a ceg es a kliens kozott
    A projektnek van egy hirfolyam/feed resze ahol ugy a ceg munkatarsai, mint a kliens meg tud nyitni egy bizonyos beszelgetesi temat, ami alatt majd hozzaszolasok formalyaban tudnak kommunikalni a felhasznalok
    A projekthez fel lehet tolteni a szukseges dokumentumokat: szerzodesek, csatolmanyok, arculati kezikonyv, arajanlatok, szamlak, szamlaszam kivonatok es egyeb dokumentumok. A PDF es kep dokumentumokat meg lehet nyitni egy kattintassal, a tobbit pedig le lehet tolteni.
    A ceg munkatarsai latjak to-do lista formalyaban a bugokat amiket a kliens letrehozott egy statussal es egy prioritassal es egy opcionalis hataridovel
    A ceg munkatarsai tudjak modositani a feladat allapotat: folyamatban/befejezve, stb.
    
**Kliens modul**
    A kliens az emailes meghivoban szereplo utasitasok alapjan tudja aktivalni felhasznalojat
    A kliens bejelentkezes utan meg tudja nezni a projekteket amikhez hozza lett adva a feluleten keresztul
    A kliens be tud lepni egy projekt belso oldalara, ahol eler minden informaciot a projektrol, hozzafer es fel tud tolteni dokumentumokat, tud uj temakat nyitni es letre tud hozni feladatokat
    A kliens letre tud hozni uj funkcio kereseket vagy bugokat egy projekten belul, ami majd megjelenik egy lista nezetben a ceg munkatarsainak. Uj dokumentum feltoltesekor vagy uj feladat letrehozasakor a projekt tagjai emailes ertesitesben reszesulnek.

