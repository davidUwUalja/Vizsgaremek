<script setup>
import { useRouter } from 'vue-router';
import { useUserStore } from '@stores/UserDatasStore.mjs';
import { onMounted } from 'vue';

const router = useRouter();
const userStore = useUserStore();

onMounted(async () => {
  if (!userStore.user) {
    await userStore.fetchUser();
  }

  const role = userStore.user?.role;

  if (role === 'admin') {
    router.replace({ name: 'adminSettings' });
  } else if (role === 'customer') {
    router.replace({ name: 'userSettings' });
  } else {
    router.replace({ name: 'login' });
  }
});
</script>

<template>
  <div class="text-center mt-10 text-gray-500">
    Átirányítás folyamatban...
  </div>
</template>

<route lang="json">
{
  "name": "settings",
  "meta": {
    "title": "Átirányítás beállítás oldalra"
  }
}
</route>
