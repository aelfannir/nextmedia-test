import axios from "axios";
import {API_URL} from "../helpers";

export const URL = `${API_URL}/categories`;

export const getCategories = () => axios.get(URL)
