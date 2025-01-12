<template>
  <aside class="w-1/4 bg-white shadow-md p-6">
    <h2 class="text-lg font-bold mb-4">Szűrők</h2>

    <div class="mb-4">
      <h3 class="font-semibold mb-2">Anyag</h3>
      <div class="flex flex-col space-y-2">
        <label>
          <input
            type="checkbox"
            class="mr-2"
            value="Fa"
            @change="updateMaterialFilter"
          />
          Fa
        </label>
        <label>
          <input
            type="checkbox"
            class="mr-2"
            value="Fém"
            @change="updateMaterialFilter"
          />
          Fém
        </label>
        <label>
          <input
            type="checkbox"
            class="mr-2"
            value="Műanyag"
            @change="updateMaterialFilter"
          />
          Műanyag
        </label>
      </div>
    </div>

    <div>
      <h3 class="font-semibold mb-2">Ár</h3>
      <input
        type="range"
        min="0"
        max="10000"
        step="500"
        class="w-full"
        v-model="priceFilter"
        @input="updatePriceFilter"
      />
      <div class="flex justify-between text-sm text-gray-500">
        <span>0 Ft</span>
        <span>{{ priceFilter }} Ft</span>
      </div>
    </div>

    <button
      @click="$emit('close')"
      class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
    >
      Bezárás
    </button>
  </aside>
</template>

<script>
export default {
  name: "FilterPanel",
  data() {
    return {
      selectedMaterials: [],
      priceFilter: 10000,
    };
  },
  methods: {
    updateMaterialFilter(event) {
      const material = event.target.value;
      if (event.target.checked) {
        this.selectedMaterials.push(material);
      } else {
        this.selectedMaterials = this.selectedMaterials.filter(
          (m) => m !== material
        );
      }
      this.$emit("filter-change", {
        materials: this.selectedMaterials,
        price: this.priceFilter,
      });
    },
    updatePriceFilter() {
      this.$emit("filter-change", {
        materials: this.selectedMaterials,
        price: this.priceFilter,
      });
    },
  },
};
</script>
