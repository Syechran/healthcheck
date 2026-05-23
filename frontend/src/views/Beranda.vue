<script setup>
</script>

<template>
  <div class="beranda-wrapper">
    <!-- Kontainer agar isi halaman tidak menyentuh ujung monitor lebar -->
    <div class="inner-container">
      
      <!-- Header -->
      <header class="header">
        <div class="greeting">
          <p class="greeting-text">Halo,</p>
          <h1 class="user-name">Wowo</h1>
        </div>
        <button class="notification-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bell-icon"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
        </button>
      </header>

      <!-- Konten Utama -->
      <main class="main-content">
        <!-- Kartu Utama (Sangat Lebar di Desktop) -->
        <section class="action-card">
          <p class="card-subtitle">Periksa gejala sekarang</p>
          <h2 class="card-title">Bagaimana kondisimu<br/>hari ini?</h2>
          <RouterLink to="/deteksi">
            <button class="start-btn">Mulai Deteksi</button>
          </RouterLink>
        </section>

        <p class="info-text">Kami bisa mendeteksi penyakit,</p>

        <section class="history-section">
          <h3 class="section-title">Riwayat terakhir</h3>
          <!-- Tempat riwayat nanti -->
        </section>
      </main>

    </div>
  </div>
</template>

<style scoped>
.beranda-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center; /* Memusatkan kontainer dalam */
  padding-bottom: 60px;
}

.inner-container {
  width: 100%;
  max-width: 1000px; /* Lebar maksimal konten desktop mirip gambar */
  padding: 0 40px;
}

/* Header terpisah ke ujung kontainer (kiri dan kanan) */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 60px 0 40px;
}

.greeting-text {
  font-size: 20px;
  color: #a0a0a0;
  margin-bottom: 4px;
  font-weight: 500;
}

.user-name {
  font-size: 32px;
  font-weight: bold;
  color: #1a1a1a;
}

.notification-btn {
  background-color: #e8f0fe;
  border: none;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #3b82f6;
  cursor: pointer;
  transition: background-color 0.2s;
}

.notification-btn:hover {
  background-color: #d1e3fb;
}

.main-content {
  display: flex;
  flex-direction: column;
}

/* Kartu Gradasi dibuat sangat lebar */
.action-card {
  background: linear-gradient(135deg, #2b88ff 0%, #21c4a0 100%);
  border-radius: 24px;
  padding: 40px 50px;
  color: white;
  margin-bottom: 40px;
  box-shadow: 0 8px 30px rgba(43, 136, 255, 0.2);
  width: 100%; /* Mengisi penuh inner-container */
}

.card-subtitle {
  font-size: 16px;
  margin-bottom: 12px;
  opacity: 0.9;
  font-weight: 500;
}

.card-title {
  font-size: 28px;
  font-weight: 600;
  margin-bottom: 30px;
  line-height: 1.4;
}

.start-btn {
  background-color: rgba(255, 255, 255, 0.4); 
  border: none;
  color: white;
  padding: 14px 32px;
  border-radius: 30px;
  font-weight: 600;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.start-btn:hover {
  background-color: rgba(255, 255, 255, 0.6);
}

.info-text {
  font-size: 20px;
  color: #a0a0a0;
  margin-bottom: 60px;
  font-weight: 500;
}

.history-section {
  margin-top: 20px;
}

.section-title {
  font-size: 22px;
  color: #a0a0a0;
  font-weight: 600;
  margin-bottom: 24px;
}
</style>
