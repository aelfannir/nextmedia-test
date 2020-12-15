<template>
    <div>
        <div>
            <h3>Products</h3>
            <table border>
                <thead>
                    <tr>
                        <th>image</th>
                        <th>
                            <a href="#" v-on:click="sort('name', !meta.sort.asc)" >
                                Name
                                <span v-if="meta.sort.field === 'name'">
                                    ({{ meta.sort.asc ? 'asc':'desc' }})
                                </span>
                            </a>
                        </th>
                        <th>
                            <a href="#" v-on:click="sort('price', !meta.sort.asc)" >
                                Price
                                <span v-if="meta.sort.field === 'price'">
                                    ({{ meta.sort.asc ? 'asc':'desc' }})
                                </span>
                            </a>
                        </th>
                        <th>
                            Categories
                            <select v-model="meta.filters.category_id">
                                <option v-for="category in categories" v-bind:value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td id="form">
                        <input
                            type="file"
                            v-on:change="onImageChange"
                            accept="image/png, image/jpeg, image/jpg"
                            multiple
                        />
                    </td>
                    <td>
                        <input v-model.lazy="model.name" />
                    </td>
                    <td>
                        <input type="number" v-model="model.price" />
                    </td>
                    <td>
                        <select v-model="model.categories_ids" multiple >
                            <option v-bind:value="category.id" v-for="category in categories">{{category.name}}</option>
                        </select>
                    </td>
                    <td>
                        <textarea v-model="model.description" rows="4" />
                    </td>


                    <td>
                        <button v-on:click="saveProduct">{{model.id ? 'Update':'Create'}}</button>
                        <button v-on:click="reset">Reset</button>
                    </td>
                </tr>
                <tr v-for="product in products" v-bind:key="product.id">
                    <td>
                        <img v-bind:src="'./storage/products/'+product.image" width="100" height="60">
                    </td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.categories.map(c=>c.name).join(', ') }}</td>
                    <td>{{ product.description }}</td>
                    <td>
                        <button v-on:click="deleteProduct(product.id)">Delete</button>
                        <button v-on:click="getProduct(product.id)">Update</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


    </div>
</template>
<script>


    import {deleteProduct, getCategories, getProduct, getProducts, saveProduct, updateProduct} from "./app";
    // const default_layout = "default";
    const prefix = "/products";
    const defaultModel = ()=>{
        return {
            id:undefined,
            name: '',
            description: '',
            price: 0,
            image: undefined,
            categories_ids: [],
        }
    };



    export default {
        computed: {},
        watch:{
          meta: {
              handler: function () {
                  this.getProducts()
              },
              deep: true
          },
        },
        data () {
            return {
                products: [],
                categories: [],
                model: defaultModel(),
                meta: {
                    sort:{
                        field: 'id',
                        asc: true
                    },
                    filters:{
                        category_id: undefined
                    }
                }
            }
        },
        methods: {
            reset() {
                this.model = defaultModel()
            },
            sort(field, asc) {
                console.log(field, asc)
                this.meta.sort = {field, asc};
            },

            getCategories: function() {
                getCategories()
                    .then(response => (this.categories = response.data))
            },
            getProducts: function () {
                getProducts(this.meta).then((response) => (this.products = response.data))
            },
            getProduct: function (id) {
                getProduct(id).then((response) => {
                    location.href = "#form"
                    const {id, description, name, price, categories  } = response.data;

                    this.model = { id, description, name, price, categories_ids:categories.map(c=>c.id) }
                })
            },
            saveProduct: function () {
                if(this.model.id){
                    updateProduct(this.model)
                        .then(() => {
                            this.getProducts();
                            this.reset();
                            alert("Updated");
                        })
                        .catch(({response:{status, data}})=>{
                            alert(`Error ${status}: ${data.message}`);
                        })
                }else {
                    saveProduct(this.model)
                        .then(() => {
                            this.getProducts();
                            this.reset();
                            alert("Created");
                        })
                        .catch(({response:{status, data}})=>{
                            alert(`Error ${status}: ${data.message}`);
                        })
                }

            },
            deleteProduct: function (id) {
                deleteProduct(id)
                    .then(() => {
                        this.getProducts();
                        alert("Deleted");
                    })
                    .catch(({response:{status}})=>{
                        alert(`Error ${status}`);
                    })
            },
            onImageChange(e) {
                this.model.image = e.target.files[0];
            },

        },
        mounted () {
            this.reset();
            this.getProducts();
            this.getCategories();
        }

    };
</script>
