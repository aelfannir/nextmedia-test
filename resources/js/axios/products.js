import axios from "axios";
import {API_URL, getFormData} from "../helpers";

export const URL = `${API_URL}/products`;

export const getProducts = (meta) => axios.get(URL, {params: {meta}})
export const getProduct = id => axios.get(`${URL}/${id}`)
export const saveProduct = product => axios.post(URL, getFormData(product))
export const updateProduct = (product) => axios.post(`${URL}/${product.id}?_method=PUT`, getFormData(product))
export const deleteProduct = (id) => axios.delete(`${URL}/${id}`)
