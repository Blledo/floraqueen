<template>
  <template v-if="loading"> Cargando... </template>
  <template v-else>
    <ProductList :products="products" />
  </template>
</template>

<script>
import axios from "axios";
import ProductList from "@/components/ProductList/ProductList";

export default {
  name: "ProductListView",
  components: {
    ProductList,
  },
  data() {
    return {
      loading: false,
      error: null,
      products: [],
    };
  },
  methods: {
    async getProducts() {
      this.loading = true;
      try {
        const products = await axios("https://bouquets.herokuapp.com/bouquets");

        this.products = products.data;
        this.loading = false;
      } catch (err) {
        this.products = [];
        this.error = "Ouch! Can't get the products";
        this.loading = false;
      }
    },
  },
  async mounted() {
    await this.getProducts();
  },
};
</script>
