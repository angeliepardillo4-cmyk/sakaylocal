import axios from 'axios';
export const api = axios.create({ baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api', headers: { Accept: 'application/json' } });
api.interceptors.request.use(config => { const token = localStorage.getItem('sakaylocal_token'); if (token) config.headers.Authorization = `Bearer ${token}`; return config; });
api.interceptors.response.use(response => response, error => { if (error.response?.status === 401) { localStorage.removeItem('sakaylocal_token'); window.dispatchEvent(new Event('auth:unauthorized')); if (!['/login','/register'].includes(window.location.pathname)) window.location.assign('/login'); } return Promise.reject(error); });
