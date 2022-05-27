<template>
    <article class="product-list-item">
        <router-link :to="{name: 'Product', params: {id: product.id}}">
            <figure class="product-list-item-image">
                <picture>
                    <img :src="product.image" :alt="product.name" />
                </picture>
            </figure>
            <div class="product-list-item-info">
                <div class="product-list-item-title">
                    {{ product.name }}
                </div>
                <div class="product-list-item-price">
                    {{ price_base  }}<sup>{{ price_decimal }}</sup>
                </div>
            </div>
        </router-link>
    </article>
</template>

<script>

export default {
    name: "ProductListItem",
    props: {
        product: {
            type: Object,
            default: null
        }
    },
    computed: {
        price_base() {
            if(this.product.price != null || this.product.price != undefined) {
                let parts = this.product.price.split('.');
                
                return parts.length > 0 ? parts[0] : '00';
            }

            return '';
        },
        price_decimal() {
            if(this.product.price != null || this.product.price != undefined) {
                let parts = this.product.price.split('.');
                
                return parts.length > 1 ? parts[1] : '00';
            }

            return '';
        }
    }
}
</script>

<style lang="css">
    .product-list-item-image {
        margin: 0px;
        background-color: #fef4f5;
        border-radius: 5px;
        transition: background-color 0.2s ease-in-out;
    }

    .product-list-item:hover .product-list-item-image {
        background-color: #feeeff;
    }

    .product-list-item-image picture {
        padding: 5px 5px 1px;
        display: block;
    }

    .product-list-item-image img {
        width: 100%;
        height: auto;
    }

    .product-list-item-info {
        text-align: left;
        padding: 10px;
    }

    .product-list-item-title {
        font-size: 1.2rem;
        font-weight: 500;
        color: #3c4849;
        margin-bottom: 5px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .product-list-item-price {
        font-size: 1.1rem;
        font-weight: 400;
        color: #3c4849;
        margin-bottom: 5px;
    }


    .product-list-item-price sup {
        font-size: 0.6rem;
        font-weight: 500;
        color: #3c4849;
        margin-left: 2px;
    }
</style>