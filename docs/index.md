# Dokumentáció
# Frontend 

## Tartalomjegyzék
1. [Felhasználói dokumentáció](#felhasználói-dokumentáció)
   - [Kosár komponens](#kosár-komponens)
   - [Fizetési komponens](#fizetési-komponens)
   - [Kívánságlista komponens](#kívánságlista-komponens)
2. [Fejlesztői dokumentáció](#fejlesztői-dokumentáció)
   - [Kosár komponens](#kosár-komponens-1)
   - [Fizetési komponens](#fizetési-komponens-1)
   - [Kívánságlista komponens](#kívánságlista-komponens-1)
   - [Rendelési adatok kezelése](#rendelési-adatok-kezelése)

## Felhasználói dokumentáció

### Kosár komponens

A kosár komponens lehetővé teszi a felhasználók számára, hogy megtekinthessék és kezelhessék a vásárlás során kiválasztott termékeket.

#### Funkciók:
- **Kosár megjelenítése**: A kosár ikonjára kattintva megjeleníthető a kosár oldalsávja.
- **Termékek kezelése**: 
  - Termékek mennyiségének növelése/csökkentése a "+" és "-" gombok segítségével.
  - Termékek törlése a kosárból a kuka ikonra kattintva.
- **Árösszesítés**: A kosár jobb alsó részében látható az aktuális összérték.
- **Fizetés**: A "Fizetés" gombra kattintva továbbléphet a fizetési folyamatra.

### Fizetési komponens

A fizetési komponens lehetővé teszi a felhasználók számára a rendelés adatainak megadását és a fizetés végrehajtását.

#### Funkciók:
- **Kapcsolattartási adatok megadása**: Név és email cím.
- **Szállítási adatok megadása**: Utca, város és irányítószám.
- **Fizetési adatok megadása**: 
  - Pénznem választása (HUF vagy USD).
  - Bankkártya adatok (kártyaszám, lejárati dátum, biztonsági kód).
- **Fizetés megerősítése**: A "Megerősítés" gombra kattintva véglegesítheti a rendelést.
- **Fizetés megszakítása**: A "Mégsem" gombra kattintva visszaléphet vásárlás közben.

### Kívánságlista komponens

A kívánságlista komponens lehetővé teszi a felhasználók számára, hogy később megvásárolandó termékeket mentsenek el.

#### Funkciók:
- **Kívánságlista megjelenítés**: A kívánságlista ikonra kattintva megjeleníthető a kívánságlista oldalsávja.
- **Termékek kezelése**:
  - Termék áthelyezése a kosárba az "Kosárba" gomb segítségével.
  - Termék eltávolítása a kívánságlistáról a "Törlés" gomb segítségével.
- **Üres kívánságlista jelzése**: Ha a kívánságlista üres, erről tájékoztatást kap.

## Fejlesztői dokumentáció

### Kosár komponens

A kosár komponens egy Vue 3 alapú oldalsáv, amely a vásárlási kosár tartalmát jeleníti meg és lehetőséget ad a termékek kezelésére.

#### Komponens szerkezet:
- **Template**: 
  - Egy jobbra rögzített oldalsáv, amely az `isOpen` prop alapján nyílik/záródik.
  - Tartalma: fejléc, termékek listája, összesítő és fizetési gomb.
- **Script**:
  - **Props**: 
    - `isOpen`: Boolean - Az oldalsáv nyitott állapotának jelzése.
    - `items`: Array - A kosárban lévő termékek tömbje.
  - **Esemény kezelések**:
    - `@close`: A kosár bezárásának jelzése a szülő komponens felé.
    - `@update-quantity`: Termék mennyiségének módosítása.
    - `@remove-item`: Termék eltávolítása a kosárból.
    - `@checkout`: Fizetési folyamat indítása.
  - **Számított tulajdonságok**:
    - `totalPrice`: A kosárban lévő termékek összértéke.
    - `currencySymbol`: A pénznem jelzése a nyelvi beállítás alapján.
  - **Metódusok**:
    - `getLocalizedField`: Lokalizált termékinformációk lekérése a nyelvi beállítások alapján.
    - `updateQuantity`: Termék mennyiségének módosítása.
    - `removeItem`: Termék eltávolítása.
    - `checkout`: Fizetési folyamat indítása.

#### Stílusok:
- Tailwind CSS osztályok a komponensek stílusozásához.
- Sárga-fehér színséma az oldalsáv megjelenítéséhez.

### Fizetési komponens

A fizetési komponens egy Vue 3 alapú modális ablak, amely a vásárlási folyamat során a fizetési és szállítási adatok megadását teszi lehetővé.

#### Komponens szerkezet:
- **Template**: 
  - Egy központi modális ablak, amely a fizetési folyamatot jeleníti meg.
  - Tartalma: kapcsolattartási adatok, szállítási adatok, fizetési adatok és vezérlőgombok.
- **Script**:
  - **Props**: 
    - `totalPrice`: Number - A kosárban lévő termékek összértéke.
  - **Állapot**:
    - Több ref változó a felhasználói adatok kezelésére.
    - `errors`: Hibaüzenetek.
    - `selectedCurrency`: Kiválasztott pénznem.
    - `convertedPrice`: Az átváltott ár.
  - **Esemény kezelések**:
    - `@close`: A modális ablak bezárásának jelzése.
  - **Számított tulajdonságok**:
    - `currencySymbol`: A pénznem jelzése.
    - `isFormValid`: Az űrlap érvényességének ellenőrzése.
  - **Életciklus hook**:
    - `onMounted`: Kezdeti beállítások és nyelvi eseménykezelő.
  - **Metódusok**:
    - Validációs metódusok az űrlap mezőihez.
    - `convertPrice`: Árkonverzió a kiválasztott pénznem alapján.
    - `confirmPayment`: Fizetés megerősítése és rendelés létrehozása.

#### Validáció:
- Név: Csak betűk és szóközök.
- Email: Érvényes email formátum.
- Város: Csak betűk és szóközök.
- Irányítószám: Pontosan 4 számjegy.
- Kártyaszám: 16 számjegy, 4 számjegyenként csoportosítva.
- Lejárati dátum: MM/YY formátum, ellenőrizve a lejárati dátum érvényességét.
- CVV: 3 számjegy.

### Kívánságlista komponens

A kívánságlista komponens egy Vue 3 alapú oldalsáv, amely a felhasználó által mentett termékeket jeleníti meg.

#### Komponens szerkezet:
- **Template**: 
  - Egy jobbra rögzített oldalsáv, amely az `isOpen` prop alapján nyílik/záródik.
  - Tartalma: fejléc, termékek listája, üres állapot jelzése.
- **Script**:
  - **Props**: 
    - `isOpen`: Boolean - Az oldalsáv nyitott állapotának jelzése.
  - **Állapot**: 
    - A ProductStore-ból származó kívánságlista elemek.
  - **Számított tulajdonságok**:
    - `wishlistItems`: A kívánságlista elemei.
    - `currency`: A pénznem jelzése a nyelvi beállítás alapján.
  - **Metódusok**:
    - `getLocalizedField`: Lokalizált termékinformációk lekérése.
    - `formatPrice`: Árak formázása a nyelvi beállítások alapján.
    - `moveToCart`: Termék áthelyezése a kosárba.
    - `removeItem`: Termék eltávolítása a kívánságlistáról.

### Rendelési adatok kezelése

Az `OrderDatasStore` egy Pinia alapú adatkezelő, amely a rendelési adatok kezelését végzi.

#### Store szerkezet:
- **State**: 
  - `orders`: Rendelések tömbje.
- **Actions**:
  - `createOrder`: Új rendelés létrehozása a backend API-n keresztül.

### Lokalizáció

A projekt többnyelvű támogatással rendelkezik, amely a Vue I18n könyvtárat használja. A komponensek nyelvfüggő szövegeit a `$t()` metódus segítségével jelenítjük meg, amely az aktuális nyelvi beállítások alapján automatikusan betölti a megfelelő fordítást.

### Pénznem kezelés

A pénznemek kezelése a nyelvi beállításhoz kapcsolódik:
- Magyar nyelv esetén: HUF (Ft)
- Angol nyelv esetén: USD ($)

Az árakat a rendszer automatikusan átszámítja a megfelelő pénznemre a beállított átváltási ráta alapján.