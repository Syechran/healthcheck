<script setup>
import { ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');
const errorMsg = ref('');
const isLoading = ref(false);

const handleRegister = async () => {
  errorMsg.value = '';
  if (password.value !== passwordConfirmation.value) {
    errorMsg.value = 'Kata sandi dan konfirmasi tidak cocok.';
    return;
  }
  
  isLoading.value = true;
  try {
    await authStore.register({
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value
    });
    router.push('/');
  } catch (err) {
    if (err.response && err.response.data && err.response.data.errors) {
      const errors = err.response.data.errors;
      const firstKey = Object.keys(errors)[0];
      errorMsg.value = errors[firstKey][0];
    } else {
      errorMsg.value = 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.';
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
        <h1 class="page-title">Buat Akun</h1>
        <p class="subtitle">Daftar untuk memulai dengan HealthCheck</p>
      </header>

      <main class="main-content">
        <form @submit.prevent="handleRegister" class="auth-form">
          <div v-if="errorMsg" class="error-alert">
            {{ errorMsg }}
          </div>

          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input 
              id="name" 
              type="text" 
              v-model="name" 
              placeholder="Masukkan nama lengkap" 
              required 
            />
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
              placeholder="Minimal 8 karakter" 
              required 
              minlength="8"
            />
          </div>

          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input 
              id="password_confirmation" 
              type="password" 
              v-model="passwordConfirmation" 
              placeholder="Ulangi kata sandi" 
              required 
              minlength="8"
            />
          </div>

          <button type="submit" class="submit-btn" :disabled="isLoading">
            {{ isLoading ? 'Memproses...' : 'Daftar' }}
          </button>
        </form>

        <p class="footer-text">
          Sudah punya akun? 
          <RouterLink to="/login" class="link">Masuk di sini</RouterLink>
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
  padding: 40px 0;
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
  gap: 16px;
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
  padding: 14px 16px;
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
  margin-top: 14px;
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
