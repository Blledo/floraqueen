<template>
  <section class="product-list">
      <template v-for="product in products" :key="product.id">
            <ProductListItem :product="product" />
      </template>
  </section>
</template>

<script>
import ProductListItem from '@/components/ProductListItem/ProductListItem';

export default {
    name: "ProductList",
    components: {
        ProductListItem
    },
    props: {
        products: {
            type: Array,
            default: () => []
        }
    },  
    data() {
        return {

        }
    }
}
</script>

<style lang="css">
    .product-list { 
        display: grid;
        grid-template-columns: calc(100% - 15px);
        grid-gap: 20px;
        padding: 20px;
        width: 100%;
    }

    @media (min-width: 450px) {
        .product-list {
            grid-template-columns: repeat(auto-fit, calc(50% - 11px));
        }
    }

    @media (min-width: 720px) {
        .product-list {
            grid-template-columns: repeat(auto-fit, calc(33% - 12px));
        }
    }

    @media (min-width: 1200px) {
        .product-list {
            grid-template-columns: repeat(auto-fit, calc(25% - 20px));
        }
    }
</style>