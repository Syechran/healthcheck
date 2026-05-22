<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'

const router = useRouter()

// State untuk melacak tampilan yang sedang aktif (upload atau kamera)
// Default-nya adalah 'upload'
const activeView = ref('upload')

// Fungsi untuk membuka tampilan kamera
const openCamera = () => {
  activeView.value = 'camera'
}

// Fungsi untuk simulasi mengambil foto dan lanjut ke langkah 2
const takePhoto = () => {
  router.push('/deteksi-2')
}
</script>

<template>
  <div class="deteksi-wrapper">
    <div class="inner-container">
      
      <!-- Header -->
      <header class="header">
        <div class="header-left">
          <!-- Jika berada di tampilan kamera, tombol back akan mengembalikan ke tampilan upload -->
          <!-- Jika di tampilan upload, tombol back mengarah ke beranda -->
          <button v-if="activeView === 'camera'" @click="activeView = 'upload'" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
          </button>
          <RouterLink v-else to="/" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
          </RouterLink>
          <h1 class="page-title">Deteksi Visual</h1>
        </div>
        
        <div class="header-center">
          <p class="step-text">Langkah 1 dari 3</p>
          <div class="step-pills">
            <div class="pill active"></div>
            <div class="pill"></div>
            <div class="pill"></div>
          </div>
        </div>
        
        <div class="header-right"></div>
      </header>

      <!-- Konten Utama (Berada di tengah layar) -->
      <main class="main-content">
        <div class="content-box">
          
          <!-- ============================================== -->
          <!-- TAMPILAN 1: PILIHAN UPLOAD & BUKA KAMERA -->
          <!-- ============================================== -->
          <div v-if="activeView === 'upload'" class="view-container">
            <!-- Kotak Upload -->

            <button @click="takePhoto">
              <div class="upload-area">
              <div class="upload-icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#2b88ff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                  <circle cx="8.5" cy="8.5" r="1.5"></circle>
                  <polyline points="21 15 16 10 5 21"></polyline>
                  <path d="M12 16v-9"></path>
                  <path d="M9 10l3-3 3 3"></path>
                </svg>
              </div>
              <h3 class="upload-title">Upload foto gejala</h3>
              <p class="upload-subtitle">Tap untuk membuka galeri</p>
            </div>

            </button>


            <!-- Pemisah "atau" -->
            <div class="divider">
              <span class="line"></span>
              <span class="text">atau</span>
              <span class="line"></span>
            </div>

            <!-- Tombol Buka Kamera -->
            <button class="camera-btn" @click="openCamera">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
              Buka kamera
            </button>

            <!-- Kotak Informasi -->
            <div class="info-box">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="info-icon"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
              <p class="info-text">Ambil foto area yang terasa tidak normal. Pastikan pencahayaan cukup</p>
            </div>
          </div>

          <!-- ============================================== -->
          <!-- TAMPILAN 2: KAMERA AKTIF -->
          <!-- ============================================== -->
          <div v-if="activeView === 'camera'" class="view-container camera-view">
            <!-- Kotak Placeholder Kamera (Biru Tua) -->
            <div class="camera-placeholder"></div>

            <!-- Kontrol Kamera (Flash, Jepret, Balik) -->
            <div class="camera-controls">
              <!-- Tombol Flash -->
              <button class="control-btn small">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2b88ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
              </button>
              
              <!-- Tombol Shutter (Jepret) -->
              <button class="control-btn large" @click="takePhoto">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
              </button>
              
              <!-- Tombol Balik Kamera -->
              <button class="control-btn small">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2b88ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
              </button>
            </div>

            <!-- Kotak Informasi (Garis Biru) -->
            <div class="info-box-outlined">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2b88ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="info-icon"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
              <p class="info-text">Pastikan objek fokus & cahaya cukup.<br/>Hindari foto blur atau terlalu gelap.</p>
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

/* --- Header --- */
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
}

.view-container {
  display: flex;
  flex-direction: column;
  gap: 24px;
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ========================================= */
/* GAYA TAMPILAN UPLOAD                      */
/* ========================================= */
.upload-area {
  border: 2px dashed #b3d4ff;
  background-color: #f4f9ff;
  border-radius: 16px;
  padding: 40px 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
  transition: background-color 0.2s;
}

.upload-area:hover {
  background-color: #e8f0fe;
}

.upload-icon-wrapper {
  background-color: #ffffff;
  width: 64px;
  height: 64px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 16px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.upload-title {
  font-size: 18px;
  font-weight: bold;
  color: #2b88ff;
  margin-bottom: 6px;
}

.upload-subtitle {
  font-size: 14px;
  color: #a0a0a0;
  font-weight: 500;
}

.divider {
  display: flex;
  align-items: center;
  gap: 16px;
}

.divider .line {
  flex: 1;
  height: 1px;
  background-color: #e0e0e0;
}

.divider .text {
  color: #a0a0a0;
  font-size: 14px;
  font-weight: 500;
}

.camera-btn {
  background-color: #2b88ff;
  color: white;
  border: none;
  border-radius: 30px;
  padding: 16px;
  font-size: 16px;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  cursor: pointer;
  transition: background-color 0.2s;
  box-shadow: 0 4px 12px rgba(43, 136, 255, 0.2);
}

.camera-btn:hover {
  background-color: #1a75ff;
}

.info-box {
  background-color: #f4f9ff;
  border-radius: 12px;
  padding: 16px;
  display: flex;
  gap: 12px;
  align-items: flex-start;
}

.info-icon {
  color: #2b88ff;
  flex-shrink: 0;
  margin-top: 2px;
}

.info-box .info-text {
  color: #2b88ff;
  font-size: 14px;
  line-height: 1.5;
  font-weight: 500;
  margin: 0;
}


/* ========================================= */
/* GAYA TAMPILAN KAMERA                      */
/* ========================================= */
.camera-view {
  gap: 32px; /* Jarak yang sedikit lebih lebar antar elemen di mode kamera */
}

.camera-placeholder {
  width: 100%;
  height: 320px;
  background-color: #173d63; /* Warna biru gelap / navy seperti gambar referensi */
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(23, 61, 99, 0.15);
}

.camera-controls {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 30px;
}

.control-btn {
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: transform 0.2s, background-color 0.2s;
}

.control-btn:hover {
  transform: scale(1.05);
}

.control-btn.small {
  width: 48px;
  height: 48px;
  background-color: #e8f0fe;
  border: none;
}

.control-btn.large {
  width: 64px;
  height: 64px;
  background-color: #2b88ff;
  border: none;
  box-shadow: 0 4px 15px rgba(43, 136, 255, 0.3);
}

.control-btn.large:hover {
  background-color: #1a75ff;
}

.info-box-outlined {
  background-color: #ffffff;
  border: 2px solid #2b88ff;
  border-radius: 16px;
  padding: 16px 20px;
  display: flex;
  gap: 16px;
  align-items: flex-start;
}

.info-box-outlined .info-text {
  color: #2b88ff;
  font-size: 15px;
  line-height: 1.5;
  font-weight: 500;
  margin: 0;
}
</style>
