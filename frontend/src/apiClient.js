import axios from 'axios';

// Create an Axios instance with default config
const apiClient = axios.create({
  baseURL: 'http://localhost:8000', // Laravel backend URL
  withCredentials: true, // Needed for Sanctum to work with session-based auth
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  }
});

export default apiClient;
