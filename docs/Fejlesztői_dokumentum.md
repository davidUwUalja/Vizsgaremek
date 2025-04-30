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
- [Backend dokumentáció](#backend-dokumentáció) 

---

## Technológiák

- **Vue 3** (Composition API & `<script setup>`)
- **Vue Router** (dinamikus rute-ok)
- **Pinia** (globális állapotkezelés)
- **vue-i18n** (magyar és angol lokalizáció)
- **TailwindCSS** (utility-first CSS)
- **Axios / http util** (API hívásokhoz)

---

## Telepítés

```bash
# klónozd a repót
git clone https://github.com/davidUwUalja/Vizsgaremek
cd Vizsgaremek


## Futtatás

```bash
npm run dev
# Böngészőben: http://frontend.vm1.test
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

## Backend dokumentáció 

Köszönöm a részletes kódot! A megadott backend alapú Laravel rendszeredhez elkészítettem egy modern, esztétikus, jól strukturált és kóddal alátámasztott `README.md` fejlesztői dokumentációt. Az alábbi tartalom megfelel a következő elvárásoknak:

- Minden komponens külön magyarázattal és példakóddal szerepel.
- A design letisztult markdown formátumban épül fel.
- A dokumentáció követi a REST architektúra alapelveit.
- Az engedélyezések, middleware-ek, modellek és validációk is bemutatásra kerülnek.

---



# 🛠️ Laravel REST API Backend – Fejlesztői Dokumentáció

Ez a dokumentáció a Laravel alapú RESTful API rendszered fejlesztői áttekintése. A rendszer több entitást kezel (Felhasználó, Termék, Megrendelés, Üzenet), valamint jogosultságkezelést, middleware-eket, validációt és erőforrásokat használ modern Laravel architektúrában.

---

## 📁 Felépítés

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
```

---

## 🔐 Autentikáció és Regisztráció

A felhasználók az alábbi végpontokkal tudnak regisztrálni vagy bejelentkezni:

```php
Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'authenticate']);
```

#### Regisztrációs Validáció

```php
public function rules(): array {
    return [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ];
}
```

---

## 👤 Felhasználó Kezelés

A felhasználók lekérdezése és módosítása történhet az alábbi végpontokon keresztül:

```php
Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::put('/user', [UserController::class, 'update'])->middleware('can:update,user');
Route::delete('/user/{user}', [UserController::class, 'delete'])->middleware('role:admin');
```

📌 **Jogosultságkezelés például:**

```php
Gate::define('update-user', [UserPolicy::class, 'update']);
```

---

## 📦 Termékek API

A termékek CRUD műveletei az alábbi útvonalakon érhetők el:

```php
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
```

🧪 **Validáció például:**

```php
'price_hu' => 'required|numeric|min:0',
'image_url' => 'nullable|string',
```

---

## 📝 Kapcsolat (Contact) API

Lehetővé teszi az üzenetek küldését és listázását:

```php
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/contact', [ContactController::class, 'index']);
```

---

## 🛒 Megrendelések

A `StoreOrderRequest` és `OrderController` biztosítja a teljes megrendelési folyamat kezelését.

```php
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
```

### Megrendelés tábla felépítése

```php
$table->foreignId('user_id')->constrained('users');
$table->string('status')->default('pending');
```

---

## 📦 Rendelési tételek

A `OrderItemController` az egyes tételek kezeléséért felel:

```php
Route::post('/order-items', [OrderItemController::class, 'store']);
Route::put('/order-items/{id}', [OrderItemController::class, 'update']);
```

---

## 🧱 Migrációk példák

```php
Schema::create('contacts', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->text('message');
    $table->timestamps();
});
```

---

## 🧬 Seederek

Kezdeti adatok betöltése:

```php
$this->call([
    AdminUserSeeder::class,
    ProductSeeder::class,
]);
```

---

## 🧩 Middleware & Role-kezelés

Role-alapú jogosultság kezelés egyedi middleware-rel:

```php
$router->aliasMiddleware('role', RoleMiddleware::class);
```

---

## 📚 Resource-ok

Egységes JSON-válaszok biztosítása:

```php
class ProductResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'name_hu' => $this->name_hu,
            'price_hu' => $this->price_hu,
            ...
        ];
    }
}
```

---

## ✅ Tesztelési javaslatok (pl. Postman)

### Példa: Bejelentkezés

```json
POST /api/login
{
  "email": "admin@admin.com",
  "password": "adminpwd"
}
```

### Példa: Termék létrehozása

```json
POST /api/products
Authorization: Bearer <token>
{
  "name_hu": "Új Termék",
  "price_hu": 9999
}


