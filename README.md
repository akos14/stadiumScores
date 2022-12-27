Az Eötvös Loránd Stadion szeretne megjelenni az interneten is, ehhez szeretnének egy weboldalt, ahol megjelennek a náluk játszott meccsek, illetve szeretnék, hogy a rajongók tudják követni kedvenceik eredményeit. Ennek a megvalósításához szükségük van a segítségedre.

Feladatok
Előkészületek
Az alkalmazásban szükség lesz tárolni csapatokat, meccseket és felhasználókat. A lehetséges tárolási formáról lentebb, a segítség részben lehet olvasni.
Az adatok közé előre fel kell venni csapatokat és közöttük meccseket. A meccsek némelyikét már lejátszották, azaz van eredményük, másik részét még nem, de már be van ütemezve egy adott dátumra. Mivel új csapat és meccs felvétele nem lesz feladat, ezért tesztelhető mennyiségű adattal töltsétek fel az adatfájlokat!
A felhasználók közé fel kell venni egy admin felhasználót. A belépési adatai rögzítettek, ld. az Admin funkcióknál leírtakat.
Listaoldal
A listaoldalon, avagy a főoldalon statikus szöveggel jelenjen meg egy cím és egy rövid ismertetés.
A főoldal elérhető azonosítatlan felhasználók számára, akik szabadon tudják böngészni az itt megjelenő tartalmakat.
A listaoldalon legyenek kilistázva a rendszerben létező csapatok.
A csapatokhoz tartozzon egy link, ami a csapatrészletek oldalra vezet.
A listaoldalon legyen kilistázva a legutóbbi 5 lejátszott meccs.
Csapatrészletek
A csapatrészletek oldalon jelenjen meg az adott csapat neve, összes meccse (ki-kivel, mikor) és a lejátszott meccseknél az eredmények is.
A meccsek eredménye legyen zöld színű, ha a csapat nyert, piros színű, ha a csapat vesztett, sárga döntetlen esetén.
A meccslista alatt jelenjenek meg a csapathoz írt hozzászólások (ki, mit, mikor írt).
Legyen lehetőség hozzászólást írni. Üresen nem fogadjuk el.
Ha nem vagyunk bejelentkezve, a hozzászólás írás legyen letiltva és jelezze a rendszer, hogy be kell jelentkeznünk ehhez a funkcióhoz.
Hitelesítési oldalak
A főoldalról legyen lehetőség elérni a bejelentkező és regisztrációs oldalt.

Regisztráció során meg kell adni a felhasználói nevet, az email címét és a jelszót kétszer. Mind kötelező, az email címnek email formátumúnak kell lennie, a jelszóknak pedig egyeznie kell.

Regisztrációs hiba esetén jelenjenek meg hibaüzenetek! Az űrlap pedig legyen állapottartó! Sikeres regisztráció után kerüljünk a bejelentkező oldalra!

A bejelentkezés során a felhasználói névvel és jelszóval tudjuk azonosítani magunkat.

A bejelentkezés során előforduló hibákat az űrlap fölött jelezd! Sikeres belépés után kerüljünk a főoldalra!

Admin funckiók
Legyen egy speciális felhasználó, az admin (email: admin@elstadion.hu, jelszó: admin), aki a következő funkciókat éri el:
A csapatrészletek oldalon a meccslista bejegyzéseit szerkeszteni tudja. Pl. minden meccs mellett megjelenik egy módosító link, amelyen keresztül a meccs részleteit, dátum és eredmény, meg lehet változtatni. Az eredményt akár törölni is lehet. Az űrlap validálása, hibák kiírása és állapottartása elvárt. Ezt a módosító oldalt csak az admin felhasználó érheti el. Siker esetén a csapatrészletek oldalra kerüljünk vissza!
A csapatrészletek oldalon bármelyik hozzászólást törölheti.
Plusz funckiók
A felhasználó megjelölhet csapato(ka)t kedvencként, így a bejelentkezés után a főoldalon a kedvenc csapat(ok) meccsei látszódjanak csak a legutóbbi 5 meccs közt. A csapatok oldalán látszódjon, hogy hányan jelölték őket kedvencnek. A kedvenc jelölés meg is szüntethető.
A listaoldalon AJAX segítségével lehessen betölteni további meccseredményeket (ha vannak), figyelembe véve a kedvencnek jelölést, ha létezik az a funkció.
Az űrlapokon a hibaüzenetek a megfelelő űrlapmezők mellett jelenjen megek.
További elvárások és segítség
Fontos az igényes megjelenés. Ez nem feltétlenül jelenti egy agyon csicsázott oldal elkészítését, de azt igen, hogy 1024x768 felbontásban az oldal jól jelenjen meg. Ehhez lehet minimalista designt is alkalmazni, lehet különböző háttérképekkel és grafikus elemekkel felturbózott saját CSS-t készíteni, de lehet bármilyen CSS keretrendszer segítségét is igénybe venni.

Az űrlapok <form> elemeinek attribútumai közé vegyük fel a novalidate attribútumot is, hogy kikapcsoljuk a böngésző validálását!

<form action="" novalidate>
</form>
Adatok
A feladatban négyféle adat van: csapatok, meccsek, hozzászólások és felhasználók. A csapatoknak tárolni kell a nevét és a képviselt várost. A meccseknél tárolni kell, hogy melyik csapatok játszották és milyen eredményt értek el. A felhasználóknak a nevét, email címét és jelszavát. A hozzászólások tárolását megoldhatod úgy, hogy tárolod a csapatnál egy belső tömbben, de úgy is, hogy egy külön tömbben vezeted a beérkezett hozzászólásokat, jelezve, hogy melyik csapathoz tartoznak. Az Pl. az alábbi egy lehetséges tárolás (itt a hozzászólások egy külön tömbben vannak):

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
A fejlesztés lépésekre bontása
Szeretnénk azoknak is segítséget nyújtani, akiknek nehezebb egy nagyobb feladatot átlátni, megtervezni. Lehet az egész feladatot előre megtervezni, és utána fejleszteni, de az alábbi lépések kisebb részfeladatok megoldásánál is használhatók:

Készítsd el a fejlesztendő alkalmazás statikus HTML prototípusát! Azaz első lépésben csak HTML és CSS segítségével tervezd meg a listaoldalt, a csapat oldalt, stb. Vannak olyan oldalak, ahol vannak feltételes információk, mint pl. a csapatok listája vagy a hozzászólások. Ezeket is tervezd meg, majd később PHP-val eltünteted. A CSS-t is ki tudod próbálni statikusan, pl. a listaoldalon, hogy az eredmények hogyan jelenjenek meg, ezt statikusan beégetheted. Az egyes oldalakat linkekkel kötheted össze.
Gondold át, hogy milyen adatokra lesz szükséged. Mit kell tárolni, azokban milyen mezőket?
Hol tárolod a felhasználókat?
Hol tárolod a meccseket és csapatokat?
Hogyan tárolod azt, hogy valamelyik csapathoz ki mit szólt hozzá?
Gondold át, hogy az előbb átgondolt adatszerkezetekből hogyan tudod az oldalaid számára a megfelelő adatokat kinyerni? Készíts ezekhez egy-egy függvényt, de sokkal jobb, ha ezeket az adott Storage osztály metódusaiként implementálod.
Hogy kapod vissza a legutóbbi 5 meccset?
Hogy kapod vissza egy csapat meccseit?
Egy adott meccshez tartozó hozzászólásokat?
stb.
Űrlapoknál két utat kell bejárni:
siker esetén mi történjen
hibát hogyan érzékelem, hogyan jelenítem meg, hogyan lesz űrlap állapottartó.
Pontozás
A feladat megoldásával 20 pont szerezhető. Vannak minimum elvárások, melyek teljesítése nélkül a beadandó nem elfogadható. A plusz feladatokért további 5 pont szerezhető. Azaz ha valaki mindent megcsinál a beadandóra 25 pontot kaphat.

Minimálisan teljesítendő (enélkül nem fogadjuk el, 5 pont)
Főoldal: megjelenik
Főoldal: összes csapat listázása (1 pont)
Főoldal: a csapatokra kattintva a megfelelő csapatrészletek oldalra jutunk (1)
Főoldal: összes meccs listázása (0,5 pont)
Csapatrészletek: Megjelenik a csapat neve (0,5 pont)
Csapatrészletek: Az adott csapathoz tartozó meccsek megjelennek eredménnyel és eredmény nélkül (1 pont)
Csapatrészletek: Megjelennek a csapathoz írt hozzászólások: ki, mikor, mit írt (1 pont)
Az alap feladatok (15 pont)
Főoldal: Legutóbbi 5 meccs listázása (1 pont)
Csapatrészletek: ahol van eredmény, a csapatnév zöld, ha nyertek, piros, ha vesztettek, sárga döntetlennél (0,5 pont)
Csapatrészletek: Új hozzászólás bejelentkezés nélkül le van tilva (0,5 pont)
Csapatrészletek: Új hozzászólás bejelentkezés után elérhető (0,5 pont)
Csapatrészletek: Új hozzászólás üresen hibát ad (0,5 pont)
Csapatrészletek: Új hozzászólás sikeresen elmentődik (1 pont)
Regisztrációs űrlap: Megfelelő elemeket tartalmazza (0,5 pont)
Regisztrációs űrlap: Hibás esetek kezelése, hibaüzenet, állapottartás (1,5 pont)
Regisztrációs űrlap: Sikeres regisztráció (0,5 pont)
Bejelentkezés: Hibás esetek kezelése (1 pont)
Bejelentkezés: Sikeres bejelentkezés (1 pont)
Admin: Be lehet jelentkezni az admin felhasználó adataival (0,5 pont)
Admin: meccseredmény módosítása csak admin felhasználóval érhető el (0,5 pont)
Admin: meccseredmény módosítása: hibakezelés, állapottartás, sikeres mentés (3 pont)
Admin: hozzászólás törlése csak admin felhasználóval érhető el (0,5 pont)
Admin: hozzászólás törlése sikeres (1 pont)
Igényes kialakítás (1 pont)
1 hét késés (-6 pont)
1 hétnél több késés (nincs elfogadva a beadandó, nincs jegy)
Plusz feladatok (plusz 5 pont)
Főoldal: AJAX-al következő 5 meccs eredményének megjelenítése (2,5 pont)
Csapatrészletek: kedvencnek jelölés (1 pont)
Főoldal: főoldalon kiemelve jelennek meg a kedvencek meccsei (1 pont)
Űrlapok: Az űrlapoknál a hibaüzenetek a megfelelő űrlapmezők mellett jelennek meg (0,5 pont)
