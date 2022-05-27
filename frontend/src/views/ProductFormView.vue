<template>
  <h3 class="title">Create new Product</h3>
  <form class="product-form">
    <div class="product-form-image">
      <div class="input input-file">
        <div class="input">
          <label for="image">Image</label>
          <input
            type="url"
            placeholder="Image URL"
            name="image"
            id="image"
            v-model="formData.image"
          />
        </div>
        <div id="preview">
          <img v-if="formData.image" :src="formData.image" />
        </div>
      </div>
    </div>
    <div class="product-form-info">
      <div class="input">
        <label for="name">Name</label>
        <input
          type="text"
          placeholder="Name"
          name="name"
          id="name"
          v-model="formData.name"
        />
      </div>
      <div class="input">
        <label for="price">Price</label>
        <input
          type="number"
          placeholder="Price"
          name="price"
          id="price"
          step="0.01"
          v-model="formData.price"
        />
      </div>

      <button
        class="primary-btn"
        :disabled="loading"
        @click.prevent="submitProduct"
      >
        Crear
      </button>
    </div>
  </form>
  <Alert ref="alerts" />
</template>

<script>
import axios from "axios";
import Alert from "@/components/Alert/Alert";

export default {
  name: "ProductFormView",
  components: {
    Alert,
  },
  data() {
    return {
      formData: {
        name: "",
        image: null,
        price: 0.0,
      },
      image_url: null,
      loading: false,
    };
  },
  methods: {
    formatPrice(price) {
      return "€" + price;
    },
    async submitProduct() {
      this.loading = true;

      try {
        const formData = {
          name: this.formData.name,
          price: this.formatPrice(this.formData.price),
          image: this.formData.image,
        };

        await axios
          .post("https://bouquets.herokuapp.com/bouquets", formData)
          .then((res) => {
            let alert = {
              message: "Test message",
              color: "success",
              action_text: "View",
              action: () => {
                this.$router.push({
                  name: "Product",
                  params: { id: res.data.id },
                });
              },
            };

            this.$refs.alerts.registerAlert(alert);
          });

        this.loading = false;
      } catch (err) {
        this.error = "Ouch! Can't submit the product";
        this.loading = false;
      }
    },
  },
};
</script>

<style>
.title {
  color: rgba(247, 135, 56, 0.8);
  text-align: left;
  text-transform: uppercase;
  font-size: 2rem;
  margin-bottom: 30px;
  font-weight: 300;
  padding: 0px 20px;
}

.product-form {
  display: grid;
  grid-template-columns: repeat(auto-fit, calc(50% - 30px));
  grid-gap: 60px;
  padding: 20px;
}

#preview {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  position: relative;
}

#preview p {
  border: 1px solid rgba(247, 135, 56, 0.6);
  height: 100%;
  width: 100%;
  padding: 20px;
}

#preview img {
  max-width: 100%;
  max-height: 500px;
}

.remove-image-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  color: rgba(247, 135, 56, 1);
  font-size: 1.5rem;
  font-weight: 400;
  cursor: pointer;
}

.input {
  display: block;
  width: 100%;
  margin-bottom: 20px;
}

.input-file {
  height: 100%;
}

.input label {
  display: block;
  text-align: left;
  font-size: 1.2rem;
  margin-bottom: 10px;
}

.input input {
  display: block;
  text-align: left;
  width: 100%;
}

.input input[type="text"],
.input input[type="number"],
.input input[type="url"] {
  border: 2px solid #ccc;
  border-radius: 3px;
  padding: 10px;
  -moz-user-input: disabled;
}

.input input[type="file"] {
  display: none;
}

.primary-btn {
  margin: 30px 0px;
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

.primary-btn:hover {
  background-color: rgba(247, 135, 56, 1);
}

.primary-btn[disabled] {
  background-color: rgba(124, 124, 124, 0.8);
  cursor: default;
}
</style>
