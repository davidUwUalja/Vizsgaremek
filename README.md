# Vizsgaremek
# Online Webshop Projekt

Ez a projekt egy modern online webshop fejlesztését célozza, amelyet **Vue.js**, **Laravel**, és **C# API** technológiák segítségével valósítunk meg. A cél egy reszponzív, könnyen használható webáruház, amely lehetővé teszi a termékek böngészését, kosárba helyezését, és rendelés leadását.

---

## 📋 Tartalomjegyzék

1. [Áttekintés](#áttekintés)
2. [Funkcionális követelmények](#funkcionális-követelmények)
3. [Technológiai választás és eszközök](#technológiai-választás-és-eszközök)
4. [Szoftverarchitektúra](#szoftverarchitektúra)
5. [Munkamegosztás](#munkamegosztás)
6. [Fejlesztési ütemterv](#fejlesztési-ütemterv)

---

## 🌟 Áttekintés

Ez a projekt egy teljes funkcionalitású webshopot biztosít, amely tartalmazza a következő alapvető funkciókat:
- Termékek megjelenítése és szűrése.
- Kosár kezelés (termékek hozzáadása, eltávolítása, mennyiség módosítása).
- Rendelés leadása és nyomon követése.
- Adminisztrátori felület a termékek és rendelések kezelésére.
- Reszponzív felhasználói felület asztali és mobil eszközökhöz.

---

## ⚙️ Funkcionális követelmények

1. **Felhasználói regisztráció és bejelentkezés**:
   - JWT alapú autentikáció.
   - Profil szerkesztése és jelszókezelés.

2. **Termékek kezelése**:
   - Böngészés és szűrés kategóriák, ár és egyéb tulajdonságok alapján.
   - Termékek részletes adatai (név, ár, leírás, képek).

3. **Kosár kezelés**:
   - Dinamikusan frissülő kosár a termékekkel.
   - Kosár tartalmának módosítása a felületen.

4. **Rendeléskezelés**:
   - Rendelések leadása.
   - Adminisztrátori felületen állapotkövetés.

5. **Adminisztrátori funkciók**:
   - Termékek CRUD műveletei (létrehozás, megtekintés, frissítés, törlés).
   - Rendelések kezelése.

---

## 🛠️ Technológiai választás és eszközök

### **Frontend**
- **Vue.js**: Felhasználói felület fejlesztése.
- **TailwindCSS**: Modern és reszponzív dizájn kialakítása.
- **Vue Router**: Navigáció kezelése.
- **Vuex**: Állapotkezelés (pl. kosár adatok, felhasználói adatok).

### **Backend**
- **Laravel**: Alkalmazás logikája, adatbázis-kezelés, és adminisztrációs funkciók.
- **C# API**: RESTful API fejlesztése a frontend és backend kommunikációhoz.

### **Adatbázis**
- **MySQL/MariaDB**: Adattárolás a felhasználók, termékek, kosarak és rendelések számára.

---

## 🏗️ Szoftverarchitektúra

### **Frontend (Vue.js)**
- A termékek megjelenítése és szűrése.
- Kosár kezelése Vuex segítségével.
- Felhasználók regisztrációja és bejelentkezése.
- Reszponzív dizájn TailwindCSS-sel.

### **Backend (Laravel)**
- Felhasználók kezelése (regisztráció, bejelentkezés, adminisztráció).
- Termékek kezelése (CRUD műveletek).
- Rendelések nyomon követése.

### **API (C#)**
- RESTful API végpontok a kosár, termékek, és rendelések kezelésére.
- JSON formátumú adatcsere a frontend és backend között.

---

## 👥 Munkamegosztás

1. **Frontend fejlesztés (Vue.js)**:
   - Navigációs rendszer kialakítása (Vue Router).
   - Termékek, kosár és szűrési funkciók implementálása.
   - TailwindCSS alapú reszponzív dizájn.

2. **Backend fejlesztés (Laravel)**:
   - Autentikáció és felhasználókezelés.
   - Termékek CRUD műveleteinek megvalósítása.
   - Rendelések adatkezelése és állapotkövetése.

3. **API fejlesztés (C#)**:
   - RESTful végpontok létrehozása a frontendhez.
   - Kosár és rendelés adatkezelése az API-n keresztül.

4. **Tesztelés**:
   - Frontend és backend funkciók unit tesztjei.
   - Integrációs tesztek a RESTful API-hoz.

---

## 📅 Fejlesztési ütemterv

1. **Első szakasz - Tervezés és alapok** *(1 hét)*
   - API és adatbázis struktúra megtervezése.
   - Alap frontend és backend beállítása.

2. **Második szakasz - Backend és API fejlesztés** *(2 hét)*
   - Laravel alapú backend fejlesztés.
   - RESTful API megvalósítása C#-ban.

3. **Harmadik szakasz - Kosár és rendeléskezelés** *(2 hét)*
   - Kosár funkciók implementálása frontend és backend között.
   - Rendeléskezelés és adminisztráció.

4. **Negyedik szakasz - Tesztelés és dokumentáció** *(1 hét)*
   - Funkciók tesztelése és hibajavítás.
   - Részletes dokumentáció készítése.

---

## 📄 Dokumentáció

A teljes dokumentáció tartalmazza:
- **Adatbázis modell**: Diagram és exportfájl.
- **Forráskód**: GitHub repository-n keresztül elérhető.
- **Telepítési útmutató**: Lépésről lépésre bemutatja a szoftver telepítését.
- **Tesztelési eredmények**: Részletes jelentés a tesztek eredményeiről.

---

## ✨ Licenc

Ez a projekt a [MIT licenc](LICENSE) alatt érhető el.

---

## 💻 Fejlesztők

- **Név 1** – *Frontend fejlesztés*
- **Név 2** – *Backend fejlesztés*
- **Név 3** – *API fejlesztés*

---

Köszönjük, hogy megnézted a projektünket! 🚀
