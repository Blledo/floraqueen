<template>
	<template v-if="loading">
		Cargando...
	</template>
	<template v-else>
		<Product :product="product" />
	</template>
</template>

<script>
import axios from 'axios';
import Product from '@/components/Product/Product';

export default {
	name: 'ProductView',
	components: {
		Product
	},
	data() {
		return {
			loading: false,
			error: null,
			product: null
		};
	},
	methods: {
		async getProduct() {
			this.loading = true;
			try {
				const product = await axios('https://bouquets.herokuapp.com/bouquets/' + this.$route.params.id);
				
				this.product = product.data;
				this.loading = false;
			} catch (err) {
				this.product = null;
				this.error = 'Ouch! Can\'t get the product';
				this.loading = false;
			}
		}
	},
	async mounted () {
		await this.getProduct();
	}
}
</script>
