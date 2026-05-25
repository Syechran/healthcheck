<script setup>
import { ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const errorMsg = ref('');
const isLoading = ref(false);

const handleLogin = async () => {
  errorMsg.value = '';
  isLoading.value = true;
  try {
    await authStore.login(email.value, password.value);
    router.push('/');
  } catch (err) {
    if (err.response && err.response.data && err.response.data.errors) {
      // Get first error message
      const errors = err.response.data.errors;
      const firstKey = Object.keys(errors)[0];
      errorMsg.value = errors[firstKey][0];
    } else {
      errorMsg.value = 'Terjadi kesalahan saat login. Silakan coba lagi.';
    }
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <div class="auth-wrapper">
    <div class="inner-container">
      
      <header class="header">
        <h1 class="page-title">Selamat Datang</h1>
        <p class="subtitle">Masuk untuk melanjutkan ke HealthCheck</p>
      </header>

      <main class="main-content">
        <form @submit.prevent="handleLogin" class="auth-form">
          <div v-if="errorMsg" class="error-alert">
            {{ errorMsg }}
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input 
              id="email" 
              type="email" 
              v-model="email" 
              placeholder="Masukkan email" 
              required 
            />
          </div>

          <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input 
              id="password" 
              type="password" 
              v-model="password" 
              placeholder="Masukkan kata sandi" 
              required 
            />
          </div>

          <button type="submit" class="submit-btn" :disabled="isLoading">
            {{ isLoading ? 'Memproses...' : 'Masuk' }}
          </button>
        </form>

        <p class="footer-text">
          Belum punya akun? 
          <RouterLink to="/register" class="link">Daftar sekarang</RouterLink>
        </p>
      </main>

    </div>
  </div>
</template>

<style scoped>
.auth-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background-color: #f9fbfd;
}

.inner-container {
  width: 100%;
  max-width: 450px;
  padding: 40px;
  background-color: #ffffff;
  border-radius: 24px;
  box-shadow: 0 10px 40px rgba(0,0,0,0.05);
}

.header {
  text-align: center;
  margin-bottom: 32px;
}

.page-title {
  font-size: 28px;
  font-weight: bold;
  color: #1a1a1a;
  margin-bottom: 8px;
}

.subtitle {
  font-size: 15px;
  color: #888888;
}

.main-content {
  width: 100%;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

label {
  font-size: 14px;
  font-weight: 600;
  color: #444444;
}

input {
  width: 100%;
  padding: 16px;
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  font-size: 15px;
  transition: border-color 0.2s, box-shadow 0.2s;
  outline: none;
}

input:focus {
  border-color: #2b88ff;
  box-shadow: 0 0 0 3px rgba(43, 136, 255, 0.1);
}

.error-alert {
  background-color: #ffebee;
  color: #d32f2f;
  padding: 12px 16px;
  border-radius: 8px;
  font-size: 14px;
  border-left: 4px solid #f44336;
}

.submit-btn {
  width: 100%;
  background-color: #2b88ff;
  color: white;
  border: none;
  border-radius: 12px;
  padding: 16px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s, transform 0.1s;
  margin-top: 10px;
}

.submit-btn:hover {
  background-color: #1a75ff;
}

.submit-btn:active {
  transform: scale(0.98);
}

.submit-btn:disabled {
  background-color: #a0c4ff;
  cursor: not-allowed;
  transform: none;
}

.footer-text {
  text-align: center;
  margin-top: 24px;
  font-size: 14px;
  color: #888888;
}

.link {
  color: #2b88ff;
  font-weight: 600;
  text-decoration: none;
}

.link:hover {
  text-decoration: underline;
}
</style>
