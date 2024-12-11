<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aknakereső</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #c0c0c0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .akna-kereso {
            background-color: #e0e0e0;
            border: 2px solid #808080;
            padding: 10px;
            box-shadow: inset -2px -2px #fff, inset 2px 2px #808080;
        }

        .felso-sor {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 5px;
            background: #bdbdbd;
            border: 2px solid #808080;
            box-shadow: inset -2px -2px #fff, inset 2px 2px #808080;
        }

        .felso-sor div {
            font-size: 20px;
            font-weight: bold;
            background: black;
            color: red;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .arc {
            width: 40px;
            height: 40px;
            background: yellow;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            cursor: pointer;
            box-shadow: -2px -2px #fff, 2px 2px #808080;
        }

        .racs {
            display: grid;
            grid-template-columns: repeat(10, 30px);
            gap: 2px;
        }

        .sejto {
            width: 30px;
            height: 30px;
            background-color: #bdbdbd;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #808080;
            box-shadow: inset -2px -2px #fff, inset 2px 2px #808080;
            cursor: pointer;
            font-size: 18px;
        }

        .sejto.felfedve {
            background-color: #e0e0e0;
            box-shadow: none;
        }

        .sejto.akna {
            background-color: red;
        }

        .sejto.zaszlo {
            background-color: #ffcc00;
        }
    </style>
</head>
<body>
    <div class="akna-kereso">
        <div class="felso-sor">
            <div id="akna-szamlalo">010</div> 
            <div class="arc" id="ujra-kezd-gomb">😊</div> 
            <div id="ido-mero">000</div> 
        </div>
        <div class="racs" id="jatekter"></div>
    </div>

    <script>
        const sorok = 10;
        const oszlopok = 10;
        const aknaSzam = 10;
   
        const jatekterElem = document.getElementById('jatekter');
        const aknaSzamlalo = document.getElementById('akna-szamlalo');
        const idoMeroElem = document.getElementById('ido-mero');
        const ujraKezdGomb = document.getElementById('ujra-kezd-gomb');

        let racs = [];
        let felfedettSzam = 0;
        let ido;
        let masodpercek = 0;

        function racsLetrehozas() {
            racs = Array.from({ length: sorok }, () => Array(oszlopok).fill(0));

            let aknakElhelyezve = 0;
            while (aknakElhelyezve < aknaSzam) {
                const sor = Math.floor(Math.random() * sorok);
                const oszlop = Math.floor(Math.random() * oszlopok);

                if (racs[sor][oszlop] === 0) {
                    racs[sor][ oszlop] = 'M';
                    aknakElhelyezve++;

                    for (let dr = -1; dr <= 1; dr++) {
                        for (let dc = -1; dc <= 1; dc++) {
                            const r = sor + dr;
                            const c = oszlop + dc;
                            if (r >= 0 && r < sorok && c >= 0 && c < oszlopok && racs[r][c] !== 'M') {
                                racs[r][c]++;
                            }
                        }
                    }
                }
            }

            jatekterMegjelenitese();
        }

        function jatekterMegjelenitese() {
            jatekterElem.innerHTML = '';
            for (let sor = 0; sor < sorok; sor++) {
                for (let oszlop = 0; oszlop < oszlopok; oszlop++) {
                    const sejto = document.createElement('div');
                    sejto.classList.add('sejto');
                    sejto.dataset.sor = sor;
                    sejto.dataset.oszlop = oszlop;

                    sejto.addEventListener('click', () => {
                        sejtoFelfed(sor, oszlop);
                    });

                    jatekterElem.appendChild(sejto);
                }
            }
        }

        function sejtoFelfed(sor, oszlop) {
            const sejto = racs[sor][oszlop];
            const sejtoElem = document.querySelector(`.sejto[data-sor='${sor}'][data-oszlop='${oszlop}']`);

            if (sejto === 'M') {
                sejtoElem.classList.add('akna');
                clearInterval(ido); // megállítja az időt  ha bombát talál a játékos
                alert('Játék vége! Találtál egy aknát.');
            } else {
                sejtoElem.classList.add('felfedve');
                sejtoElem.textContent = sejto > 0 ? sejto : '';
                felfedettSzam++;

                if (felfedettSzam === sorok * oszlopok - aknaSzam) {
                    clearInterval(ido); // megállítja az időt  ha a játékos nyer
                    alert('Gratulálok! Tisztára takarítottad az aknamezőt.');
                }
            }
        }

        function idoInditas() {
            ido = setInterval(() => {
                masodpercek++;
                idoMeroElem.textContent = masodpercek.toString().padStart(3, '0');
            }, 1000);
        }

        ujraKezdGomb.addEventListener('click', () => {
            clearInterval(ido); 
            masodpercek = 0; 
            idoMeroElem.textContent = '000'; 
            racsLetrehozas(); 
            felfedettSzam = 0; 
            aknaSzamlalo.textContent = aknaSzam.toString().padStart(3, '0'); 
            idoInditas(); 
        });

        idoInditas();
        racsLetrehozas();
    </script>
</body>
</html>
        

<!-- Szabályok
A tábla cellákra van osztva, amelyeken véletlenszerűen helyezkednek el az aknák. A győzelemhez az összes cellát fel kell nyitnod. A cellán lévő szám azt mutatja, hogy hány akna van a szomszédos cellákban. Ezen információ alapján meghatározhatod, mely cellák biztonságosak, és melyek rejtenek aknát. Az aknának vélt cellákat zászlóval jelölheted meg a jobb egérgomb használatával.

Új játékot kezdhetsz a tábla tetején lévő mosolygós arcra kattintva, vagy a space billentyű megnyomásával. A bal sarokban látható a hátralévő aknák száma, a jobb sarokban pedig az időmérő.

Chordolás
Amikor egy szám melletti helyes mennyiségű zászló van, rákattinthatsz a számra, hogy az összes környező cellát kinyisd. Ezt chordolásnak hívják, mert régebbi verziókban ehhez egyszerre kellett két gombot (bal + jobb egérgomb) megnyomni (ez a beállításokban megváltoztatható). A chordolás jelentősen csökkenti a felesleges kattintásokat, és az eredményes játék alapját képezi.

Találgatás nélküli mód (NG)
A játék megtanulásának egyik legjobb módja a találgatás nélküli mód használata. Ebben a módban egy induló helyzet biztosított, és soha nem kell találgatni a tábla befejezéséhez. Ha elakadnál, egy ingyenes segítség gomb található a jobb alsó sarokban. A magasabb nehézségi szintű NG táblák összetettebb logikai minták alkalmazását igénylik. Az Evil nehézségi szint minden játékban legalább egy haladó szituációt tartalmaz.

Zászlók nélküli mód (NF)
Az NF egy olyan játékmód, amelyben nem használsz zászlókat. A játék akkor nyerhető meg, ha az összes nem aknás cellát felfeded, függetlenül attól, hogy az aknák meg vannak-e jelölve. Az NF játékosok ezt a módszert alkalmazzák a kattintások számának csökkentésére.

3BV
A 3BV (Bechtel táblaszámértéke) az a minimális kattintásszám, amely egy tábla befejezéséhez szükséges zászlók használata nélkül. A 3BV segítségével mérhető a tábla relatív nehézsége, valamint a játékos gyorsasága (gyakran 3BV/s formában, azaz másodpercenkénti 3BV értékben fejezve ki).

A túl szerencsés játékok elkerülése érdekében a kezdő, középhaladó és haladó szintekhez tartoznak 3BV-korlátok: 5/30/100. Az ezeknél alacsonyabb 3BV értékű játékok nem kerülnek rögzítésre az időrangsorban. -->
