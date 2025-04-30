# Webshop Project

A modern, Vue.js alapú webáruház projekt, mely TailwindCSS-sel, Pinia Store-okkal és vue-i18n nemzetköziesítéssel készült.

---

## Tartalomjegyzék

- [Technológiák](#technológiák)
- [Projekt struktúra](#projekt-struktúra)
- [Telepítés](#telepítés)
- [Futtatás](#futtatás)
- [Főbb komponensek](#főbb-komponensek)
  - [Landing Page](#landing-page)
  - [Product List](#product-list)
  - [Product Detail](#product-detail)
  - [Blog oldalak](#blog-oldalak)
  - [Kapcsolat sablon](#kapcsolat-sablon)
  - [Felhasználói nézet](#felhasználói-nézet)
  - [Admin nézet](#admin-nézet)
  - [AuthModal](#authmodal)
  - [Kosár és Checkout](#kosár-és-checkout)
- [Állapotkezelés (Pinia)](#állapotkezelés-pinia)
- [Internacionalizáció (vue-i18n)](#internacionalizáció-vue-i18n)
- [Stílusok (TailwindCSS)](#stílusok-tailwindcss)
- [Fejlesztői tippek](#fejlesztői-tippek)

---

## Technológiák

- **Vue 3** (Composition API & `<script setup>`)
- **Vue Router** (dinamikus rute-ok)
- **Pinia** (globális állapotkezelés)
- **vue-i18n** (magyar és angol lokalizáció)
- **TailwindCSS** (utility-first CSS)
- **Axios / http util** (API hívásokhoz)

---

## Projekt struktúra

```
src/
├─ components/       # Újrafelhasználható UI komponensek
├─ layouts/          # Oldal sablonok (BaseLayout)
├─ pages/            # Oldal komponensek (Landing, ProductList, stb.)
├─ stores/           # Pinia store-ok
├─ locales/          # i18n fordítások
└─ utils/            # http, segédfüggvények
```

---

## Telepítés

```bash
# klónozd a repót
git clone https://github.com/felhasznalo/webshop.git
cd webshop

# függőségek telepítése
npm install
```

---

## Futtatás

```bash
npm run dev
# Böngészőben: http://localhost:3000
```

---

## Főbb komponensek

### Landing Page

**Fájltípus:** `src/pages/index.vue`

```vue
<template>
  <BaseLayout>
    <!-- középre igazított üdvözlő panel -->
  </BaseLayout>
</template>
```

- **BaseLayout**: az oldalak közös fejlécét és láblécét tartalmazza.
- **Nyelvvezérlés**: `{{$t('welcome')}}` fordítási kulcsokkal.

---

### Product List

**Fájltípus:** `src/pages/productList.vue`

```vue
<template>
  <!-- termékeket megjelenítő rács és szűrő panel -->
</template>
<script setup>
import { ref, computed, onMounted } from 'vue';
import { useProductStore } from '@stores/ProductDatasStore';

const productStore = useProductStore();
const products = computed(() => productStore.products);
</script>
```

- **Szűrés**: oldalsó filter panel `showFilter` változóval.
- **Toast üzenetek**: vásárláskor visszajelzés.
- **Rács**: reszponzív gridClasses.

---

### Product Detail

**Fájltípus:** `src/pages/product/[id].vue`

```vue
<template>
  <!-- kiválasztott termék részletei gombokkal -->
</template>
<script>
export default {
  methods: {
    handleAddToCart(prod) { /* kosárba tesz */ }
  },
  created() {
    this.product = this.$store.getById(this.$route.params.id);
  }
};
</script>
```

- **Dinamikus route**: `[id].vue`.
- **Pinia**: `productStore.getLocalizedField` név, leírás, ár lokalizálása.

---

### Blog oldalak

#### BlogPage
```vue
<template>
  <!-- lista cikkekről és "Read More" linkek -->
</template>
```

#### BlogDetailsPage
```vue
<template>
  <!-- teljes cikk tartalom publikálási dátummal -->
</template>
```

- **Állapot**: `showDetails` modálisnézet.

---

### Kapcsolat sablon

**Fájltípus:** `src/pages/contact.vue`

```vue
<form @submit.prevent="sendMessage">
  <input v-model="name" required />
  <input v-model="email" required />
  <textarea v-model="message" required />
  <button type="submit">{{ $t('submitButton') }}</button>
</form>
```

- **API**: `http.post('/contact', data)`.
- **Visszajelzés**: `successMessage`, `errorMessage`.

---

### Felhasználói nézet (UserSettings)

**Fájltípus:** `src/pages/userSettings.vue`

```vue
<template>
  <table>
    <tr><td>Név:</td><td>{{ user.name }}</td></tr>
  </table>
</template>
<script setup>
const user = useUserStore().user;
</script>
```

- **Rendelések**: `/orders` lekérés és szűrés a user email, név alapján.

---

### Admin nézet (AdminSettings)

**Fájltípus:** `src/pages/adminSettings.vue`

```vue
<template>
  <section>
    <!-- Üzenetek és megrendelések kezelése táblázatokkal -->
  </section>
</template>
```

- **Jogosultság**: csak `admin` szerepkörrel elérhető.
- **Műveletek**: rendelés státusz változtatása, új termék feltöltése.

---

### AuthModal

**Fájltípus:** `src/components/AuthModal.vue`

```vue
<template>
  <div v-if="isOpen">
    <form @submit.prevent="isLogin ? login() : register()">
      <!-- name/email/password mezők -->
    </form>
  </div>
</template>
```

- **Átmenet**: login/register váltása `toggleMode`.
- **Token kezelés**: `localStorage.setItem('token', ...)` + `userStore.fetchUser()`.

---

### Kosár és Checkout

**Fájlok:** `CartPanel.vue`, `CartCheckout.vue`

```vue
<CartPanel :isOpen="cartOpen" @close="cartOpen=false" />
<CartCheckout :totalPrice="sum" @close="checkoutOpen=false" />
```

- **Form validáció**: név, email, cím, kártya adatok regex ellenőrzéssel.
- **Árváltás**: `selectedCurrency` váltáskor `exchangeRate`-tel.

---

## Állapotkezelés (Pinia)

- **ProductDatasStore**: termékek listázása, kosár, wishlist.
- **UserDatasStore**: felhasználói adatok, tokenes fetch.
- **OrderDatasStore**: megrendelések CRUD.

```js
// példa store
export const useProductStore = defineStore('product', {
  state: () => ({ products: [] }),
  actions: {
    addToCart(product) { /*...*/ }
  }
});
```

---

## Internacionalizáció (vue-i18n)

- **Konfiguráció**: `I18n.js` init magyar (`hu`) és angol (`en`).
- **Használat**: `$t('kulcs')` fordítások.

```js
const i18n = createI18n({ locale: 'hu', messages });
```

---

## Stílusok (TailwindCSS)

- **Utility-first**: `flex`, `grid`, `p-4`, `bg-yellow-50`.
- **Reszponzív**: `md:`, `hover:`, `transition-all`.

---

## Fejlesztői tippek

- Kövesd a `Composition API` minta használatát.
- Tartsd karban az i18n kulcsokat, külön fájlokban.
- Használj Pinia pluginokat (pl. persist), ha szükséges.
- Teszteld le a reszponzív grid viselkedését különböző képernyőszélességeken.

---

*Jó munkát a fejlesztéshez!*

