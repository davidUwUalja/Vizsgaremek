<template>
  <aside class="w-1/4 bg-white shadow-md p-6">
    <h2 class="text-lg font-bold mb-4">Szűrők</h2>

    <!-- Material Filter -->
    <div class="mb-4">
      <h3 class="font-semibold mb-2">Anyag</h3>
      <div class="flex flex-col space-y-2">
        <label>
          <input type="checkbox" class="mr-2" />
          Fa
        </label>
        <label>
          <input type="checkbox" class="mr-2" />
          Fém
        </label>
        <label>
          <input type="checkbox" class="mr-2" />
          Műanyag
        </label>
      </div>
    </div>

    <!-- Price Filter -->
    <div>
      <h3 class="font-semibold mb-2">Ár</h3>
      <input
        type="range"
        min="0"
        max="10000"
        step="500"
        class="w-full"
      />
      <div class="flex justify-between text-sm text-gray-500">
        <span>0 Ft</span>
        <span>10,000 Ft</span>
      </div>
    </div>
  </aside>
</template>

<script>
export default {
  name: 'FilterPanel',
};
</script>
