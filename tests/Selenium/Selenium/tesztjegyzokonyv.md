# 📝 Tesztjegyzőkönyv

**Tesztelés dátuma:** 2025-04-30  
**Tesztelő:** [PetzDavid]  
**Tesztkörnyezet:**  
- URL: `http://frontend.vm1.test/`  
- Böngésző: Google Chrome (ChromeDriver)  
- Framework: MSTest + Selenium WebDriver  

---

## Tesztesetek összegzése

### LandingPage tesztek

| Teszteset neve                     | Leírás                                                                                           | Eredmény  |
|:----------------------------------|-----------------------------------------------------------|
| `TestLandingPageHeadlineVisible`  | Ellenőrzi, hogy a főcím (`Üdvözlünk Webshopunkban!`) megjelenik-e a landing oldalon.              | Sikeres |
| `TestVasarlasButtonNavigation`    | Ellenőrzi, hogy a `Vásárlás` gombra kattintva a `/productList` oldalra navigál-e.                 | Sikeres |
| `TestBlogButtonNavigation`        | Ellenőrzi, hogy a `Blog megtekintése` gombra kattintva a `/blogpage` oldalra navigál-e.           | Sikeres |
| `TestFeatureBoxesAreVisible`      | Ellenőrzi, hogy pontosan 3 feature box jelenik meg, és a címsorok megfelelnek a várt szövegnek.   | Sikeres |

### BlogPage tesztek

| Teszteset neve                     | Leírás                                                                                            | Eredmény  |
|:----------------------------------|------------------------------------------------------------|
| `TestBlogHeaderIsVisible`         | Ellenőrzi, hogy a blog oldal főcíme (`Blog`) látható-e.                                            | Sikeres |
| `TestBlogSectionsExist`           | Ellenőrzi, hogy legalább 2 blogbejegyzés szekció van-e megjelenítve.                               | Sikeres |
| `TestCommentFormSubmission`       | Ellenőrzi, hogy a komment űrlap sikeresen beküldhető és megjelenik-e az oldalon.                   | Sikeres |

---

## Teszt részletei

### 🔹 LandingPage tesztek

#### `TestLandingPageHeadlineVisible`
- **Cél:** A főcím megjelenésének ellenőrzése a landing oldalon.
- **Elvárt eredmény:** A `h1` elem szövege `Üdvözlünk Webshopunkban!` és látható.
- **Tényleges eredmény:** Megjelenik, a teszt sikeres.

#### `TestVasarlasButtonNavigation`
- **Cél:** Vásárlás gombra kattintás után a `/productList` oldal betöltése.
- **Elvárt eredmény:** Az oldal URL-je tartalmazza a `/productList` útvonalat.
- **Tényleges eredmény:** Navigáció megtörténik, URL ellenőrzés sikeres.

#### `TestBlogButtonNavigation`
- **Cél:** Blog megtekintése gombra kattintás után a `/blogpage` oldal betöltése.
- **Elvárt eredmény:** Az oldal URL-je tartalmazza a `/blogpage` útvonalat.
- **Tényleges eredmény:** Navigáció megtörténik, URL ellenőrzés sikeres.

#### `TestFeatureBoxesAreVisible`
- **Cél:** Feature boxok száma és címei ellenőrzése.
- **Elvárt eredmény:**  
  - 3 db feature box jelenik meg.  
  - Címsorok: `Kézzel készített`, `Fenntartható anyagok`, `Gyors kiszállítás`.
- **Tényleges eredmény:**  
  - 3 db box megjelenik.  
  - Címsorok pontosan megegyeznek az elvárttal.

---

### 🔹 BlogPage tesztek

- URL: `http://frontend.vm1.test/blogPage`  

#### `TestBlogHeaderIsVisible`
- **Cél:** Ellenőrizni, hogy a `Blog` főcím megjelenik-e a blog oldalon.
- **Elvárt eredmény:** A `h1` elem szövege `Blog` és látható.
- **Tényleges eredmény:** Megjelenik, a teszt sikeres.

#### `TestBlogSectionsExist`
- **Cél:** Legalább 2 blogbejegyzés szekció meglétének ellenőrzése.
- **Elvárt eredmény:** Legalább 2 szekció jelenjen meg.
- **Tényleges eredmény:** Legalább 2 szekció megjelenik, a teszt sikeres.

#### `TestCommentFormSubmission`
- **Cél:** Komment űrlap sikeres kitöltése és beküldése.
- **Elvárt eredmény:**  
  - Név és üzenet megadása után a komment megjelenik az oldalon.
  - A név és üzenet szövege pontosan látszik.
- **Tényleges eredmény:**  
  - Komment sikeresen megjelenik.
  - A `Teszt Elek` név és `Ez egy automata teszt üzenet.` szöveg pontosan szerepel.