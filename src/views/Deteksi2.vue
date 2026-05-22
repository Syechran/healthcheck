<script setup>
import { RouterLink, useRouter } from 'vue-router'

const router = useRouter()

// Fungsi simulasi: Jika diklik akan pindah ke Deteksi3 (Hasil)
const gotoResult = () => {
  router.push('/deteksi-3')
}
</script>

<template>
  <div class="deteksi-wrapper">
    <div class="inner-container">
      
      <!-- Header -->
      <header class="header">
        <div class="header-left">
          <RouterLink to="/deteksi" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
          </RouterLink>
          <h1 class="page-title">Deteksi Visual</h1>
        </div>
        
        <div class="header-center">
          <p class="step-text">Langkah 2 dari 3</p>
          <div class="step-pills">
            <div class="pill active"></div>
            <div class="pill active"></div>
            <div class="pill"></div>
          </div>
        </div>
        
        <div class="header-right"></div>
      </header>

      <!-- Konten Utama -->
      <main class="main-content">
        <!-- Tambahkan @click="gotoResult" agar pengguna bisa simulasi lanjut ke hasil -->
        <div class="content-box" @click="gotoResult" style="cursor: pointer;">
          
          <!-- Kartu Animasi Loading / Analisis -->
          <div class="analysis-card">
            <div class="icon-wrapper">
              <!-- Ikon Otak -->
              <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#2b88ff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 1.98-3A2.5 2.5 0 0 1 9.5 2Z"></path>
                <path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-1.98-3A2.5 2.5 0 0 0 14.5 2Z"></path>
              </svg>
            </div>
            <h3 class="analysis-title">Menganalisis gambar</h3>
            <p class="analysis-subtitle">Mohon tunggu sebentar</p>
            
            <div class="progress-bar-container">
              <div class="progress-bar-fill"></div>
            </div>
          </div>

          <!-- Daftar Proses (Status List) -->
          <div class="status-list">
            
            <!-- Selesai 1 -->
            <div class="status-item completed">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4caf50" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span>Foto diterima</span>
            </div>

            <!-- Selesai 2 -->
            <div class="status-item completed">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4caf50" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span>Memroses gambar</span>
            </div>

            <!-- Sedang Berjalan (Active) -->
            <div class="status-item active">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2b88ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="spinning">
                <circle cx="12" cy="12" r="10" stroke-dasharray="16 16" stroke-dashoffset="0"></circle>
              </svg>
              <span>Mencocokkan pola penyakit</span>
            </div>

            <!-- Tertunda (Pending) -->
            <div class="status-item pending">
              <span>Menyiapkan hasil</span>
            </div>

          </div>

        </div>
      </main>

    </div>
  </div>
</template>

<style scoped>
.deteksi-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-bottom: 60px;
}

.inner-container {
  width: 100%;
  max-width: 1000px;
  padding: 0 40px;
}

/* --- Header (Sama dengan Langkah 1) --- */
.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 60px 0 40px;
}

.header-left, .header-center, .header-right {
  flex: 1;
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
}

.page-title {
  font-size: 24px;
  font-weight: bold;
  color: #1a1a1a;
  margin: 0;
}

.header-center {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.step-text {
  font-size: 14px;
  color: #b0b0b0;
  margin-bottom: 8px;
  font-weight: 500;
}

.step-pills {
  display: flex;
  gap: 6px;
}

.pill {
  width: 30px;
  height: 8px;
  border-radius: 4px;
  background-color: #d9d9d9;
}

.pill.active {
  background-color: #2b88ff;
}

/* --- Konten Utama --- */
.main-content {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.content-box {
  width: 100%;
  max-width: 450px;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

/* Kartu Analisis (Loading Card) */
.analysis-card {
  background-color: #e8f0fe;
  border: 1px solid #b3d4ff;
  border-radius: 16px;
  padding: 40px 30px;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0 4px 15px rgba(43, 136, 255, 0.1);
}

.analysis-card .icon-wrapper {
  margin-bottom: 16px;
}

.analysis-title {
  font-size: 18px;
  font-weight: bold;
  color: #2b88ff;
  margin-bottom: 6px;
}

.analysis-subtitle {
  font-size: 14px;
  color: #8fa0c4;
  font-weight: 500;
  margin-bottom: 24px;
}

.progress-bar-container {
  width: 100%;
  height: 8px;
  background-color: #ffffff;
  border-radius: 4px;
  overflow: hidden;
}

.progress-bar-fill {
  width: 60%; /* Simulasi loading 60% */
  height: 100%;
  background-color: #2b88ff;
  border-radius: 4px;
  animation: pulseWidth 2s infinite ease-in-out alternate;
}

@keyframes pulseWidth {
  from { width: 50%; }
  to { width: 75%; }
}

/* Daftar Status / Proses */
.status-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.status-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 16px 20px;
  border-radius: 30px; /* Bentuk rounded mirip pil/kapsul */
  font-size: 15px;
  font-weight: 600;
  background-color: #ffffff;
}

/* Item yang Selesai */
.status-item.completed {
  border: 1px solid #e0e0e0;
  color: #666666;
}

/* Item Sedang Berjalan */
.status-item.active {
  border: 1px solid #b3d4ff;
  background-color: #e8f0fe;
  color: #2b88ff;
  box-shadow: 0 4px 10px rgba(43, 136, 255, 0.1);
}

/* Item Tertunda */
.status-item.pending {
  border: 1px solid #f0f0f0;
  color: #cccccc;
  padding-left: 50px; /* Offset agar sejajar dengan teks item lain yang ada ikonnya */
}

/* Animasi Ikon Putar */
.spinning {
  animation: spin 2s linear infinite;
}

@keyframes spin {
  100% { transform: rotate(360deg); }
}
</style>
