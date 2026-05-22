<script setup>
import { RouterLink } from 'vue-router'
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
          <h2 class="section-heading">Minggu ini</h2>

          <!-- Kartu Item Riwayat -->
          <div class="history-card">
            <div class="card-left">
              <span class="disease-name">Dermatitis</span>
              <span class="severity-badge">Ringan</span>
            </div>
            
            <div class="card-right">
              <!-- Ikon Menu (Tiga Titik) -->
              <button class="menu-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#a0a0a0" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="1.5"></circle>
                  <circle cx="12" cy="5" r="1.5"></circle>
                  <circle cx="12" cy="19" r="1.5"></circle>
                </svg>
              </button>
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

/* --- Kartu Riwayat --- */
.history-card {
  background-color: #e8f5e9; /* Hijau muda */
  border: 1px solid #81c784; /* Border hijau */
  border-radius: 30px; /* Bentuk melingkar seperti pil panjang */
  padding: 16px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: background-color 0.2s, box-shadow 0.2s;
  cursor: pointer;
}

.history-card:hover {
  background-color: #dcedc8;
  box-shadow: 0 4px 12px rgba(129, 199, 132, 0.2);
}

.card-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.disease-name {
  font-size: 18px;
  font-weight: bold;
  color: #2e7d32; /* Hijau tua */
}

.severity-badge {
  background-color: #a5d6a7; /* Latar badge hijau sedikit gelap */
  color: #1b5e20;
  font-size: 12px;
  font-weight: 600;
  padding: 4px 12px;
  border-radius: 20px;
}

.card-right {
  display: flex;
  align-items: center;
}

.menu-btn {
  background: none;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4px;
  border-radius: 50%;
  transition: background-color 0.2s;
}

.menu-btn:hover {
  background-color: rgba(0, 0, 0, 0.05);
}
</style>
