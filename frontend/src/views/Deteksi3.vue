<script setup>
import { onMounted } from 'vue';
import { RouterLink } from 'vue-router'
import api from '../utils/axios';

onMounted(async () => {
  try {
    await api.post('/detections', {
      disease_name: "Dermatitis",
      severity: "mild",
      confidence: 90,
      detected_area: "wajah",
      notes: "Deteksi visual via foto dummy."
    });
  } catch (error) {
    console.error('Failed to post detection result', error);
  }
});
</script>

<template>
  <div class="deteksi-wrapper">
    <div class="inner-container">
      
      <!-- Header -->
      <header class="header">
        <div class="header-left">
          <RouterLink to="/deteksi-2" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
          </RouterLink>
          <h1 class="page-title">Deteksi Visual</h1>
        </div>
        
        <div class="header-center">
          <p class="step-text">Langkah 3 dari 3</p>
          <div class="step-pills">
            <div class="pill active"></div>
            <div class="pill active"></div>
            <div class="pill active"></div>
          </div>
        </div>
        
        <div class="header-right"></div>
      </header>

      <!-- Konten Utama -->
      <main class="main-content">
        <div class="content-box">
          
          <!-- Kartu Hasil Utama (Dermatitis) -->
          <div class="result-card">
            <div class="result-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#4caf50" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
              </svg>
            </div>
            <div class="result-info">
              <div class="result-header">
                <h3 class="result-title">Dermatitis</h3>
                <span class="severity-badge">Ringan</span>
              </div>
              <p class="result-desc">Terdeteksi dari foto<br/>90% cocok</p>
            </div>
          </div>

          <h4 class="section-subtitle">Area terdeteksi pada foto</h4>

          <!-- Kotak Preview Gambar -->
          <div class="image-preview-card">
            <div class="image-placeholder">
              <!-- Kotak Hijau Deteksi (Bounding Box) -->
              <div class="bounding-box">
                <span class="box-label">Area 1</span>
              </div>
              
              <!-- Ikon dan Nama File Dummy -->
              <div class="placeholder-content">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#a0a0a0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                  <circle cx="8.5" cy="8.5" r="1.5"></circle>
                  <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                <span class="filename">foto_telinga.jpg</span>
              </div>
            </div>
            <div class="image-footer">
              <p>Kotak merah = area yang terdeteksi AI</p>
            </div>
          </div>

          <!-- Statistik / Persentase Penyakit -->
          <div class="stats-container">
            <!-- Item Statistik 1 -->
            <div class="stat-item">
              <div class="stat-header">
                <div class="stat-label">
                  <span class="dot green"></span>
                  <span class="stat-name">Dermatitis kulit</span>
                </div>
                <span class="stat-value">90%</span>
              </div>
              <div class="stat-bar-bg">
                <div class="stat-bar-fill" style="width: 90%;"></div>
              </div>
            </div>

            <!-- Item Statistik 2 -->
            <div class="stat-item">
              <div class="stat-header">
                <div class="stat-label">
                  <span class="dot red"></span>
                  <span class="stat-name">Peradangan</span>
                </div>
                <span class="stat-value">10%</span>
              </div>
              <div class="stat-bar-bg">
                <div class="stat-bar-fill" style="width: 10%;"></div>
              </div>
            </div>
          </div>

          <!-- Tombol Selesai -->
          <RouterLink to="/riwayat" class="finish-btn-wrapper">
            <button class="finish-btn">Selesai</button>
          </RouterLink>

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
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* Kartu Hasil (Warna Hijau) */
.result-card {
  background-color: #e8f5e9; /* Hijau muda */
  border: 1px solid #81c784;
  border-radius: 16px;
  padding: 20px 24px;
  display: flex;
  align-items: flex-start;
  gap: 16px;
}

.result-icon {
  margin-top: 4px;
}

.result-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 8px;
}

.result-title {
  font-size: 18px;
  font-weight: bold;
  color: #2e7d32; /* Hijau tua */
  margin: 0;
}

.severity-badge {
  background-color: #a5d6a7;
  color: #1b5e20;
  font-size: 12px;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 20px;
}

.result-desc {
  font-size: 14px;
  color: #4caf50;
  line-height: 1.5;
  margin: 0;
}

/* Judul Sub-bagian */
.section-subtitle {
  font-size: 14px;
  color: #888888;
  margin-top: 10px;
  font-weight: 600;
}

/* Kartu Preview Gambar */
.image-preview-card {
  background-color: #ffffff;
  border: 1px solid #e0e0e0;
  border-radius: 16px;
  overflow: hidden;
}

.image-placeholder {
  background-color: #cfd8dc; /* Biru keabuan seperti gambar */
  height: 180px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.placeholder-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  opacity: 0.7;
}

.filename {
  font-size: 16px;
  font-weight: bold;
  color: #78909c;
}

/* Kotak Deteksi (Bounding Box) */
.bounding-box {
  position: absolute;
  top: 20px;
  left: 30px;
  width: 100px;
  height: 60px;
  border: 2px solid #81c784;
  border-radius: 8px;
  background-color: rgba(129, 199, 132, 0.2);
}

.box-label {
  position: absolute;
  top: -12px;
  left: 8px;
  background-color: #ffffff;
  color: #4caf50;
  font-size: 12px;
  font-weight: bold;
  padding: 2px 8px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.image-footer {
  padding: 16px;
  text-align: center;
}

.image-footer p {
  font-size: 14px;
  color: #a0a0a0;
  margin: 0;
}

/* Statistik (Bar Persentase) */
.stats-container {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-top: 10px;
  margin-bottom: 20px;
}

.stat-item {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.stat-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.stat-label {
  display: flex;
  align-items: center;
  gap: 8px;
}

.dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
}

.dot.green { background-color: #81c784; }
.dot.red { background-color: #f44336; }

.stat-name {
  font-size: 14px;
  font-weight: 600;
  color: #444444;
}

.stat-value {
  font-size: 14px;
  font-weight: bold;
  color: #888888;
}

.stat-bar-bg {
  width: 100%;
  height: 6px;
  background-color: #f0f0f0;
  border-radius: 3px;
  overflow: hidden;
}

.stat-bar-fill {
  height: 100%;
  background-color: #2b88ff;
  border-radius: 3px;
}

/* Tombol Selesai */
.finish-btn-wrapper {
  text-decoration: none;
  width: 100%;
}

.finish-btn {
  width: 100%;
  background-color: #2b88ff;
  color: white;
  border: none;
  border-radius: 30px;
  padding: 16px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s;
  box-shadow: 0 4px 12px rgba(43, 136, 255, 0.2);
}

.finish-btn:hover {
  background-color: #1a75ff;
}
</style>
