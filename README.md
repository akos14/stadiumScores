
# Eötvös Loránd Stadion
Az Eötvös Loránd Stadion szeretne megjelenni az interneten is, ehhez szeretnének egy weboldalt, ahol megjelennek a náluk játszott meccsek, illetve szeretnék, hogy a rajongók tudják követni kedvenceik eredményeit. Ennek a megvalósításához szükségük van a segítségedre.

## Feladatok
### Előkészületek
- Az alkalmazásban szükség lesz tárolni csapatokat, meccseket és felhasználókat. A lehetséges tárolási formáról lentebb, a segítség részben lehet olvasni.
- Az adatok közé előre fel kell venni csapatokat és közöttük meccseket. A meccsek némelyikét már lejátszották, azaz van eredményük, másik részét még nem, de már be van ütemezve egy adott dátumra. Mivel új csapat és meccs felvétele nem lesz feladat, ezért tesztelhető mennyiségű adattal töltsétek fel az adatfájlokat!
- A felhasználók közé fel kell venni egy admin felhasználót. A belépési adatai rögzítettek, ld. az Admin funkcióknál leírtakat.
### Listaoldal
- A listaoldalon, avagy a főoldalon statikus szöveggel jelenjen meg egy cím és egy rövid ismertetés.
- A főoldal elérhető azonosítatlan felhasználók számára, akik szabadon tudják böngészni az itt megjelenő tartalmakat.
- A listaoldalon legyenek kilistázva a rendszerben létező csapatok.
- A csapatokhoz tartozzon egy link, ami a csapatrészletek oldalra vezet.
- A listaoldalon legyen kilistázva a legutóbbi 5 lejátszott meccs.
### Csapatrészletek
- A csapatrészletek oldalon jelenjen meg az adott csapat neve, összes meccse (ki-kivel, mikor) és a lejátszott meccseknél az eredmények is.
- A meccsek eredménye legyen zöld színű, ha a csapat nyert, piros színű, ha a csapat vesztett, sárga döntetlen esetén.
- A meccslista alatt jelenjenek meg a csapathoz írt hozzászólások (ki, mit, mikor írt).
- Legyen lehetőség hozzászólást írni. Üresen nem fogadjuk el.
- Ha nem vagyunk bejelentkezve, a hozzászólás írás legyen letiltva és jelezze a rendszer, hogy be kell jelentkeznünk ehhez a funkcióhoz.
### Hitelesítési oldalak
- A főoldalról legyen lehetőség elérni a bejelentkező és regisztrációs oldalt.
- Regisztráció során meg kell adni a felhasználói nevet, az email címét és a jelszót kétszer. Mind kötelező, az email címnek email formátumúnak kell lennie, a jelszóknak pedig egyeznie kell.
- Regisztrációs hiba esetén jelenjenek meg hibaüzenetek! Az űrlap pedig legyen állapottartó! Sikeres regisztráció után kerüljünk a bejelentkező oldalra!
- A bejelentkezés során a felhasználói névvel és jelszóval tudjuk azonosítani magunkat.
- A bejelentkezés során előforduló hibákat az űrlap fölött jelezd! Sikeres belépés után kerüljünk a főoldalra!

### Admin funckiók
- Legyen egy speciális felhasználó, az admin (email: admin@elstadion.hu, jelszó: admin), aki a következő funkciókat éri el:
- A csapatrészletek oldalon a meccslista bejegyzéseit szerkeszteni tudja. Pl. minden meccs mellett megjelenik egy módosító link, amelyen keresztül a meccs részleteit, dátum és eredmény, meg lehet változtatni. Az eredményt akár törölni is lehet. Az űrlap validálása, hibák kiírása és állapottartása elvárt. Ezt a módosító oldalt csak az admin felhasználó érheti el. Siker esetén a csapatrészletek oldalra kerüljünk vissza!
- A csapatrészletek oldalon bármelyik hozzászólást törölheti.
### Plusz funckiók
- A felhasználó megjelölhet csapato(ka)t kedvencként, így a bejelentkezés után a főoldalon a kedvenc csapat(ok) meccsei látszódjanak csak a legutóbbi 5 meccs közt. A csapatok oldalán látszódjon, hogy hányan jelölték őket kedvencnek. A kedvenc jelölés meg is szüntethető.
- A listaoldalon AJAX segítségével lehessen betölteni további meccseredményeket (ha vannak), figyelembe véve a kedvencnek jelölést, ha létezik az a funkció.
- Az űrlapokon a hibaüzenetek a megfelelő űrlapmezők mellett jelenjenek meg.
- 
### További elvárások és segítség
Fontos az igényes megjelenés. Ez nem feltétlenül jelenti egy agyon csicsázott oldal elkészítését, de azt igen, hogy 1024x768 felbontásban az oldal jól jelenjen meg. Ehhez lehet minimalista designt is alkalmazni, lehet különböző háttérképekkel és grafikus elemekkel felturbózott saját CSS-t készíteni, de lehet bármilyen CSS keretrendszer segítségét is igénybe venni.

Adatok
A feladatban négyféle adat van: csapatok, meccsek, hozzászólások és felhasználók. A csapatoknak tárolni kell a nevét és a képviselt várost. A meccseknél tárolni kell, hogy melyik csapatok játszották és milyen eredményt értek el. A felhasználóknak a nevét, email címét és jelszavát. A hozzászólások tárolását megoldhatod úgy, hogy tárolod a csapatnál egy belső tömbben, de úgy is, hogy egy külön tömbben vezeted a beérkezett hozzászólásokat, jelezve, hogy melyik csapathoz tartoznak. Az Pl. az alábbi egy lehetséges tárolás (itt a hozzászólások egy külön tömbben vannak):

```
$teams = [
    'teamid1' => [
        'id' => 'teamid1',
        'name' => 'Team #1',
        'city' => 'City #1'
    ],
    'teamid2' => [
        'id' => 'teamid2',
        'name' => 'Team #2',
        'city' => 'City #2'
    ]
];
$matches = [
    'matchid1' => [
        'id' => 'matchid1',
        'home' => [
            'id' => 'teamid1',
            'score' => '2'
        ],
        'away' => [
            'id' => 'teamid2',
            'score' => '1'
        ],
        'date' => '2021-11-11'
    ]
];
$users = [
    'userid1' => [
        'id' => 'userid1',
        'username' => 'user1',
        'email' => 'email1'
    ],
    'userid2' => [
        'id' => 'userid2',
        'username' => 'user2',
        'email' => 'email1'
    ]
];
$comments = [
    'commentid1' => [
        'author' => 'userid1',
        'text' => 'Hajrá fiúk!',
        'teamid' => 'teamid1',
    ],
    'commentid2' => [
        'author' => 'userid2',
        'text' => 'Jó volt a legutóbbi meccs!',
        'teamid' => 'teamid1',
    ],
];
```
