export const APP_URL = process.env.APP_URL || 'http://127.0.0.1:8000';
export const STORAGE_URL = `${APP_URL}/storage/products/`;
export const API_URL = `${APP_URL}/api`;

export const getFormData = (model) => {
    let formData = new FormData();
    Object.keys(model).forEach(k=>{
        const v = model[k];
        if(v !== undefined){
            formData.append(k, Array.isArray(v) ? JSON.stringify(v) : v);
        }

    })

    return formData;
}
