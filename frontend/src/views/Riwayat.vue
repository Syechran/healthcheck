<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink } from 'vue-router'
import api from '../utils/axios';

const history = ref([]);
const isLoading = ref(true);

onMounted(async () => {
  try {
    const response = await api.get('/detections');
    history.value = response.data.data;
  } catch (error) {
    console.error('Failed to fetch history', error);
  } finally {
    isLoading.value = false;
  }
});
</script>

<template>
  <div class="riwayat-wrapper">
    <div class="inner-container">
      
      <!-- Header -->
      <header class="header">
        <div class="header-left">
          <!-- Tombol kembali ke Beranda -->
          <RouterLink to="/" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
          </RouterLink>
          <h1 class="page-title">Riwayat</h1>
        </div>
      </header>

      <!-- Konten Utama -->
      <main class="main-content">
        <!-- Membatasi lebar konten agar rapi di desktop -->
        <div class="content-box">
          
          <!-- Judul Bagian -->
          <h2 class="section-heading">Riwayat Deteksi</h2>

          <div v-if="isLoading" class="info-state">Memuat riwayat...</div>
          <div v-else-if="history.length === 0" class="info-state">Belum ada riwayat deteksi.</div>

          <div v-else class="history-list">
            <!-- Kartu Item Riwayat -->
            <div class="history-card" v-for="item in history" :key="item.id">
              <div class="card-left">
                <span class="disease-name">{{ item.disease_name }}</span>
                <span class="severity-badge" :class="item.severity">{{ item.severity_label }}</span>
              </div>
              
              <div class="card-right">
                <span class="date-text">{{ new Date(item.detected_at).toLocaleDateString('id-ID') }}</span>
              </div>
            </div>
          </div>

        </div>
      </main>

    </div>
  </div>
</template>

<style scoped>
.riwayat-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center; /* Memusatkan kontainer dalam */
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
  flex-direction: column;
  /* Konten riwayat dibuat mepet ke kiri, tidak ditengah layaknya deteksi */
  align-items: flex-start; 
}

.content-box {
  width: 100%;
  /* Lebar bisa diatur, namun di gambar terlihat menyebar ke kiri */
  max-width: 600px; 
}

.section-heading {
  font-size: 28px;
  font-weight: normal;
  color: #1a1a1a;
  margin-bottom: 24px;
}

.history-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
  width: 100%;
}

.history-card {
  background-color: #ffffff; 
  border: 1px solid #e0e0e0;
  border-radius: 20px; 
  padding: 16px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: box-shadow 0.2s;
  cursor: pointer;
  width: 100%;
}

.history-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0, 0.05);
}

.card-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.disease-name {
  font-size: 18px;
  font-weight: bold;
  color: #1a1a1a; 
}

.severity-badge {
  background-color: #f0f0f0; 
  color: #666666;
  font-size: 12px;
  font-weight: 600;
  padding: 4px 12px;
  border-radius: 20px;
}

.severity-badge.mild {
  background-color: #a5d6a7; 
  color: #1b5e20;
}
.severity-badge.moderate {
  background-color: #ffe082; 
  color: #ff8f00;
}
.severity-badge.severe {
  background-color: #ef9a9a; 
  color: #c62828;
}

.card-right {
  display: flex;
  align-items: center;
}

.date-text {
  font-size: 13px;
  color: #a0a0a0;
}

.info-state {
  color: #888888;
  font-style: italic;
  padding: 20px 0;
}
</style>
