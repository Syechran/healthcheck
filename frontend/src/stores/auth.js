import { defineStore } from 'pinia';
import api from '../utils/axios';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    stats: null,
    token: localStorage.getItem('token') || null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
  },
  actions: {
    async login(email, password) {
      try {
        const response = await api.post('/login', { email, password });
        this.token = response.data.access_token;
        this.user = response.data.user;
        localStorage.setItem('token', this.token);
        return true;
      } catch (error) {
        console.error('Login failed', error);
        throw error;
      }
    },
    async register(userData) {
      try {
        const response = await api.post('/register', userData);
        this.token = response.data.access_token;
        this.user = response.data.user;
        localStorage.setItem('token', this.token);
        return true;
      } catch (error) {
        console.error('Registration failed', error);
        throw error;
      }
    },
    async logout() {
      try {
        if (this.token) {
          await api.post('/logout');
        }
      } catch (error) {
        console.error('Logout error', error);
      } finally {
        this.token = null;
        this.user = null;
        this.stats = null;
        localStorage.removeItem('token');
      }
    },
    async fetchUser() {
      if (!this.token) return;
      try {
        const response = await api.get('/me');
        this.user = response.data.user;
        this.stats = response.data.stats;
      } catch (error) {
        console.error('Fetch user failed', error);
        if (error.response && error.response.status === 401) {
          this.logout();
        }
      }
    }
  }
});
