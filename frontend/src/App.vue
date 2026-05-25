<script setup>
import { RouterView, RouterLink, useRoute } from 'vue-router'

const route = useRoute()
</script>

<template>
  <!-- Layout Desktop Full Screen -->
  <div class="desktop-container">
    
    <!-- Konten Utama (Beranda, Deteksi, dll) -->
    <!-- RouterView akan mengisi sisa ruang yang ada -->
    <RouterView />

    <!-- ================= Navigasi Bawah ================= -->
    <nav class="bottom-nav" v-if="!route.meta.guest">
      <!-- Container dalam agar ikon tidak terlalu melebar ke ujung layar -->
      <div class="nav-inner">
        <RouterLink to="/" class="nav-item" active-class="active" exact>
          <div class="icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
          </div>
          <span class="nav-label">Beranda</span>
        </RouterLink>

        <RouterLink to="/deteksi" class="nav-item" active-class="active">
          <div class="icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" x2="16.65" y1="21" y2="16.65"></line></svg>
          </div>
          <span class="nav-label">Deteksi</span>
        </RouterLink>

        <RouterLink to="/riwayat" class="nav-item" active-class="active">
          <div class="icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          </div>
          <span class="nav-label">Riwayat</span>
        </RouterLink>

        <RouterLink to="/profil" class="nav-item" active-class="active">
          <div class="icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </div>
          <span class="nav-label">Profil</span>
        </RouterLink>
      </div>
    </nav>

  </div>
</template>

<style>
/* CSS Reset Global */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #ffffff; /* Desktop putih penuh */
  -webkit-font-smoothing: antialiased;
}

a {
  text-decoration: none;
}
</style>

<style scoped>
/* Kontainer utama membentang sepenuh layar Desktop */
.desktop-container {
  width: 100%;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Navigasi Bawah Lebar untuk Desktop */
.bottom-nav {
  background-color: #ffffff;
  border-top: 1px solid #f0f0f0;
  padding: 20px 0 30px;
  width: 100%;
  margin-top: auto; /* Memaksa navigasi selalu berada di bawah */
}

/* Membatasi lebar menu navigasi agar tidak terlalu jauh ke tepi di monitor besar */
.nav-inner {
  max-width: 1000px;
  margin: 0 auto;
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 0 20px;
}

.nav-item {
  background: none;
  border: none;
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #b0b0b0;
  cursor: pointer;
  gap: 8px;
  width: 120px;
  transition: color 0.2s;
}

.nav-item.active {
  color: #2b88ff; 
}

.nav-label {
  font-size: 14px;
  font-weight: 600;
}
</style>
