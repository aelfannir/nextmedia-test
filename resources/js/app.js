import Vue from 'vue'

//Main pages
import App from './app.vue'
import axios from 'axios'

export const APP_URL = 'http://127.0.0.1:8000';
export const STORAGE_URL = `${APP_URL}/storage/products/`;
export const API_URL = `${APP_URL}/api`;
export const API_URL_PRODUCTS = `${API_URL}/products`;
export const API_URL_CATEGORIES = `${API_URL}/categories`;

//
export const getFormData = (model) => {
    let formData = new FormData();
    Object.keys(model).forEach(k=>{
        const v = model[k];
        if(!(v instanceof undefined)){
            formData.append(k, Array.isArray(v) ? JSON.stringify(v) : v);
        }

    })
    console.log(model, formData)
    return formData;
}
//
export const getProducts = (meta) => axios.get(API_URL_PRODUCTS, {params: {meta}})
export const getProduct = id => axios.get(`${API_URL_PRODUCTS}/${id}`)
export const saveProduct = product => axios.post(API_URL_PRODUCTS, getFormData(product))
export const updateProduct = (product) => axios.post(`${API_URL_PRODUCTS}/${product.id}?_method=PUT`, getFormData(product))
export const deleteProduct = (id) => axios.delete(`${API_URL_PRODUCTS}/${id}`)
export const getCategories = () => axios.get(API_URL_CATEGORIES)



const app = new Vue({
    el: '#app',
    components: { App }
});
