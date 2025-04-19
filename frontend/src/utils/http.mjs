// @utils/http.mjs
import axios from 'axios';

export const http = axios.create({ baseURL: 'http://backend.vm1.test/api' });

http.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});
