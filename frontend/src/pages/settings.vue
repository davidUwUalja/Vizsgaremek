<template>
  <div>
    <AdminSettings v-if="isAdmin" />
    <UserSettings v-else-if="isCustomer" />
    <p v-else class="text-center text-gray-500 mt-10">Adatok betöltése...</p>
  </div>
</template>

<script>
import AdminSettings from "@components/layout/AdminSettings.vue";
import UserSettings from "@components/layout/UsersSettings.vue";
import { useUserStore } from "@/stores/UserDatasStore.mjs";
import { computed, onMounted } from "vue";

export default {
  components: {
    AdminSettings,
    UserSettings,
  },
  setup() {
    const userStore = useUserStore();
    const isAdmin = computed(() => userStore.user?.role === "admin");
    const isCustomer = computed(() => userStore.user?.role === "customer");

    onMounted(async () => {
      await userStore.fetchUser();
      console.log("Settings.vue - Felhasználó betöltve:", userStore.user);
    });

    return { isAdmin, isCustomer };
  },
};
</script>
<route lang="json">
  {
      "name": "settings",
      "meta":{
          "title": "Beállítások kezelése "
      }
  }
  </route>
