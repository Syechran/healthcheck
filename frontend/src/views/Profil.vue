<script setup>
import { onMounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

onMounted(() => {
  if (authStore.isAuthenticated && !authStore.user) {
    authStore.fetchUser();
  }
});

const handleLogout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>

<template>
  <div class="profil-wrapper">
    <div class="inner-container">
      
      <!-- Header -->
      <header class="header">
        <div class="header-left">
          <!-- Tombol kembali ke Beranda -->
          <RouterLink to="/" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
          </RouterLink>
          <h1 class="page-title">Profile Saya</h1>
        </div>
      </header>

      <!-- Konten Utama -->
      <main class="main-content">
        <div class="content-box">
          
          <!-- Avatar & Nama Pengguna -->
          <div class="profile-info">
            <div class="avatar-circle">
              <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <h2 class="profile-name">{{ authStore.user?.name || 'Memuat...' }}</h2>
          </div>

          <!-- Bagian Pengaturan (Settings) -->
          <div class="settings-section">
            <h3 class="section-title">Pengaturan</h3>
            
            <div class="settings-list">
              <!-- Tombol Pengaturan -->
              <button class="settings-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Pengaturan</span>
              </button>
              
              <!-- Tombol Privasi -->
              <button class="settings-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>Privasi dan keamanan</span>
              </button>
              
              <!-- Tombol Tentang Kami -->
              <button class="settings-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <span>Tentang kami</span>
              </button>
              
              <!-- Tombol Keluar (Logout) -->
              <button class="settings-btn logout-btn" @click="handleLogout">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f44336" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span>Keluar</span>
              </button>
            </div>
          </div>

        </div>
      </main>

    </div>
  </div>
</template>

<style scoped>
.profil-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-bottom: 60px;
}

.inner-container {
  width: 100%;
  max-width: 1000px; /* Lebar maksimal konten desktop */
  padding: 0 40px;
}

/* --- Header --- */
.header {
  display: flex;
  align-items: center;
  padding: 60px 0 40px;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.back-btn {
  color: #1a1a1a;
  display: flex;
  align-items: center;
  justify-content: center;
  background: none;
  border: none;
  cursor: pointer;
  transition: transform 0.2s;
}

.back-btn:hover {
  transform: translateX(-4px);
}

.page-title {
  font-size: 24px;
  font-weight: bold;
  color: #1a1a1a;
  margin: 0;
}

/* --- Konten Utama --- */
.main-content {
  display: flex;
  justify-content: center; /* Di gambar, profil berada di tengah layar */
  width: 100%;
}

.content-box {
  width: 100%;
  max-width: 450px; /* Lebar kotak yang pas agar tidak terlalu melar */
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* --- Avatar & Profil --- */
.profile-info {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 32px;
}

.avatar-circle {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 3px solid #1a1a1a;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 12px;
}

.profile-name {
  font-size: 20px;
  font-weight: bold;
  color: #1a1a1a;
  margin: 0;
}

/* --- Statistik --- */
.stats-row {
  display: flex;
  justify-content: center;
  gap: 16px;
  margin-bottom: 40px;
  width: 100%;
}

.stat-card {
  flex: 1;
  background-color: #ffffff;
  border: 1px solid #e0e0e0;
  border-radius: 16px;
  padding: 16px 8px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}

.stat-number {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 4px;
}

/* Warna spesifik untuk angka sesuai desain */
.stat-number.blue { color: #2b88ff; }
.stat-number.green { color: #4caf50; }
.stat-number.orange { color: #ff9800; }

.stat-label {
  font-size: 13px;
  color: #a0a0a0;
  line-height: 1.3;
}

/* --- Pengaturan --- */
.settings-section {
  width: 100%;
}

.section-title {
  font-size: 14px;
  font-weight: bold;
  color: #888888;
  margin-bottom: 16px;
  text-align: left;
}

.settings-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.settings-btn {
  width: 100%;
  background-color: #ffffff;
  border: 1px solid #e0e0e0;
  border-radius: 16px; /* Pill shape */
  padding: 16px 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  cursor: pointer;
  transition: background-color 0.2s, box-shadow 0.2s;
}

.settings-btn:hover {
  background-color: #f9f9f9;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.settings-btn span {
  font-size: 15px;
  font-weight: 600;
  color: #666666;
}

/* Tombol Logout Spesifik (Merah) */
.logout-btn {
  border-color: #ffcdd2; /* Border merah muda */
  background-color: #fffafb;
}

.logout-btn:hover {
  background-color: #ffebee;
}

.logout-btn span {
  color: #f44336;
}
</style>
