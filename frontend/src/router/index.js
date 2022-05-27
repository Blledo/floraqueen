import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";

const routes = [
  { 
    path: "/",
    name: "ProductListView",
    component: Home,
  },
  {
    path: "/product-list",
    name: "ProductList",
    component: () =>
      import(/* webpackChunkName: "product-list" */ "../views/ProductListView.vue"),
  },
  {
    path: "/product/:id",
    name: "Product",
    component: () =>
      import(/* webpackChunkName: "product" */ "@/views/ProductView.vue"),
  },
  {
    path: "/product-form",
    name: "ProductForm",
    component: () =>
      import(/* webpackChunkName: "product" */ "@/views/ProductFormView.vue"),
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
