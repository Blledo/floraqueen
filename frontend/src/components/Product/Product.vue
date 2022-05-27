<template>
  <div class="product-detail">
    <template v-if="product">
      <section class="product-detail-left">
        <div class="product-detail-carrousel">
          <ul>
            <li
              v-for="(img, i) in product_images"
              :key="i"
              :class="image_selected == i ? 'active' : ''"
              @click="selectImage(i)"
            >
              <img :src="img" />
            </li>
          </ul>
        </div>
        <figure class="product-detail-image">
          <picture>
            <img :src="product_images[image_selected]" :alt="product.name" />
          </picture>
        </figure>
      </section>
      <section class="product-detail-right">
        <div class="product-detail-title">
          {{ product.name }}
        </div>
        <div class="product-detail-price">
          {{ price_base }}<sup>{{ price_decimal }}</sup>
        </div>
        <div class="product-detail-action">
          <button class="add-cart-btn">Add to Cart</button>
        </div>
      </section>
    </template>
  </div>
</template>

<script>
export default {
  name: "Product",
  props: {
    product: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      image_selected: 0,
    };
  },
  computed: {
    price_base() {
      if (this.product.price != null || this.product.price != undefined) {
        let parts = this.product.price.split(".");

        return parts.length > 0 ? parts[0] : "00";
      }

      return "";
    },
    price_decimal() {
      if (this.product.price != null || this.product.price != undefined) {
        let parts = this.product.price.split(".");

        return parts.length > 1 ? parts[1] : "00";
      }

      return "";
    },
    product_images() {
      return Array.isArray(this.product.image)
        ? this.product.image
        : [this.product.image];
    },
  },
  methods: {
    selectImage(index) {
      this.image_selected = index;
    },
  },
};
</script>

<style lang="css">
.product-detail {
  display: grid;
  grid-template-columns: 100%;
  grid-gap: 0px;
}

.product-detail-left {
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  justify-items: center;
  padding: 20px;
}

.product-detail-image {
  margin: 0px;
  background-color: #fef4f5;
  border-radius: 5px;
}

.product-detail-image picture {
  padding: 5px 5px 1px;
  display: block;
}

.product-detail-image img {
  width: 100%;
  height: 100%;
}

.product-detail-carrousel {
  order: 1;
  margin-top: 20px;
}

.product-detail-carrousel img {
  width: 100%;
  display: block;
  height: 60px;
}

.product-detail-carrousel ul {
  text-align: left;
}

.product-detail-carrousel li {
  border: 1px solid rgba(247, 135, 56, 0.2);
  cursor: pointer;
  margin-bottom: 10px;
  display: inline-block;
}

.product-detail-carrousel li.active {
  border: 1px solid rgba(247, 135, 56, 0.8);
}

.product-detail-right {
  padding: 0px 15px;
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
}

.product-detail-title {
  color: rgba(247, 135, 56, 0.5);
  font-size: 2.2rem;
  font-weight: 500;
  margin-bottom: 20px;
  text-align: left;
}

.product-detail-price {
  font-size: 2rem;
  font-weight: 400;
  color: #3c4849;
  margin-bottom: 20px;
  text-align: left;
}

.product-detail-price sup {
  font-size: 1.1rem;
  font-weight: 500;
  color: #3c4849;
  margin-left: 2px;
}

.product-detail-action {
  width: 100%;
  flex-grow: 2;
  display: flex;
  align-items: flex-end;
}

.add-cart-btn {
  margin: 0px;
  background-color: rgba(247, 135, 56, 0.8);
  color: #fff;
  border-radius: 5px;
  transition: background-color 0.2s ease-in-out;
  padding: 20px;
  text-transform: uppercase;
  font-size: 1.1rem;
  font-weight: 500;
  border: none;
  width: 100%;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
}

.add-cart-btn:hover {
  background-color: rgba(247, 135, 56, 1);
}

@media (min-width: 530px) {
  .product-detail-image img {
    width: auto;
    height: 100%;
  }
}

@media (min-width: 720px) {
  .product-detail {
    grid-template-columns: repeat(auto-fit, calc(50% - 40px));
    grid-gap: 40px;
  }

  .product-detail-left {
    display: grid;
    grid-template-columns: 20% calc(80% - 20px);
    grid-gap: 20px;
    justify-items: center;
    padding: 20px;
  }

  .product-detail-carrousel {
    order: 0;
    margin-top: 0px;
  }

  .product-detail-carrousel img {
    height: auto;
  }

  .product-detail-image img {
    width: 100%;
    height: auto;
  }
}

@media (min-width: 1200px) {
  .product-detail-left {
    padding: 0px;
  }
}
</style>
