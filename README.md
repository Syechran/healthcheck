# HealthCheck App - Antarmuka Diagnosa Penyakit

Ini adalah proyek tugas *web-based* yang mengimplementasikan antarmuka aplikasi seluler/desktop untuk mendiagnosis penyakit umum menggunakan **Vue.js 3** dan **Vue Router**. Aplikasi ini saat ini berfokus pada pembuatan purwarupa antarmuka (UI/UX) beserta alur simulasi navigasinya.

---

## 🏗 Struktur Utama Aplikasi

Secara garis besar, aplikasi ini dikendalikan oleh dua file utama:

1. **`src/App.vue` (Kerangka Utama)**
   File ini tidak berisi konten halaman spesifik, melainkan bertindak sebagai "cangkang" dari aplikasi kita.
   - **`<RouterView />`**: Sebuah lubang dinamis di tengah layar. Area inilah yang akan diisi oleh halaman yang berbeda-beda (Beranda, Deteksi, Profil) tergantung pada URL yang diakses.
   - **`nav.bottom-nav`**: Bilah navigasi bawah (Beranda, Deteksi, Riwayat, Profil) yang selalu tampil (*persistent*) di setiap halaman. Komponen ini menggunakan `<RouterLink>` untuk berpindah halaman secara instan tanpa perlu memuat ulang browser.

2. **`src/router/index.js` (Pengatur Lalu Lintas / *Routing*)**
   File ini mendaftarkan jalan (URL) untuk setiap komponen halaman. Jika URL berubah, *router* akan memerintahkan `App.vue` untuk mengganti isi di dalam `<RouterView />`.
   
   Rute yang terdaftar:
   - `/` $\rightarrow$ `Beranda.vue`
   - `/deteksi` $\rightarrow$ `Deteksi1.vue`
   - `/deteksi-2` $\rightarrow$ `Deteksi2.vue`
   - `/deteksi-3` $\rightarrow$ `Deteksi3.vue`
   - `/riwayat` $\rightarrow$ `Riwayat.vue`
   - `/profil` $\rightarrow$ `Profil.vue`

---

## 🔄 Alur Kerja Aplikasi (Workflow)

Berikut adalah panduan lengkap dari halaman ke halaman mengenai bagaimana aplikasi ini dirancang untuk bekerja:

### 1. Halaman Beranda (`src/views/Beranda.vue`)
- **Tampilan:** Halaman pertama yang muncul saat aplikasi dibuka. Menampilkan sapaan ("Halo, Wowo") dan kartu selamat datang.
- **Interaksi:** Pengguna dapat menekan tombol **"Mulai Deteksi"** (yang dibungkus dalam tag `<RouterLink to="/deteksi">`). Ini akan membawa pengguna ke alur deteksi penyakit.

### 2. Halaman Deteksi Langkah 1 (`src/views/Deteksi1.vue`)
- **Tampilan:** Menggunakan sistem *state management* sederhana milik Vue (`ref`) untuk memiliki **dua tampilan** dalam satu file.
   - *State* `upload`: Menampilkan kotak unggah gambar.
   - *State* `camera`: Menampilkan simulasi layar kamera (*viewfinder*) biru gelap.
- **Interaksi:** Saat tombol "Buka Kamera" ditekan, *state* berubah ke `camera` tanpa harus berpindah URL. Saat tombol bidik (*shutter*) ditekan, fungsi `router.push('/deteksi-2')` dipanggil untuk menyimulasikan foto yang sudah diambil dan otomatis lanjut ke langkah berikutnya.

### 3. Halaman Deteksi Langkah 2 (`src/views/Deteksi2.vue`)
- **Tampilan:** Merupakan halaman transisi/simulasi proses AI. Menampilkan status tahapan (Foto diterima $\rightarrow$ Memroses $\rightarrow$ Mencocokkan). Terdapat animasi CSS pada ikon *loading* dan bilah *progress bar*.
- **Interaksi:** (Sebagai *mockup*, untuk mempercepat demonstrasi) Jika pengguna mengeklik area kartu *loading*, fungsi `gotoResult` berjalan dan memanggil `router.push('/deteksi-3')` untuk membawa pengguna ke hasil deteksi.

### 4. Halaman Deteksi Langkah 3 (`src/views/Deteksi3.vue`)
- **Tampilan:** Menampilkan hasil akhir dari analisis AI. Menunjukkan bahwa penyakit terdeteksi sebagai "Dermatitis Ringan" dengan tingkat kecocokan 90%. Menampilkan gambar simulasi beserta letak kotak (*bounding box*) tempat AI menemukan penyakit.
- **Interaksi:** Di bagian bawah terdapat tombol **"Selesai"** yang menggunakan `<RouterLink to="/riwayat">`. Menekan tombol ini akan menutup proses deteksi dan mengarahkan pengguna ke halaman riwayat.

### 5. Halaman Riwayat (`src/views/Riwayat.vue`)
- **Tampilan:** Menampilkan log dari penyakit yang pernah dideteksi sebelumnya. Layout konten pada halaman ini dikhususkan merapat ke kiri (*align-items: flex-start*) dibandingkan dengan halaman Deteksi yang posisinya berada di tengah (*center*).
- **Interaksi:** Tombol kembali (`<-`) di pojok kiri atas mengarahkan kembali ke `/` (Beranda). Halaman ini juga dapat diakses dari navigasi bawah.

### 6. Halaman Profil (`src/views/Profil.vue`)
- **Tampilan:** Halaman untuk melihat detail statistik akun dan menu pengaturan. Terdapat deretan *card* yang berisi angka statistik (Deteksi, Bulan Aktif, Konsultasi) dan deretan menu (Pengaturan, Privasi, Keluar).
- **Interaksi:** Halaman ini dapat diakses secara langsung kapan pun melalui bilah navigasi bawah di tombol "Profil".

---

## 🚀 Cara Menjalankan Proyek

Jika server sudah berhenti, jalankan kembali dengan perintah ini di terminal:
```bash
npm run dev
```
Buka tautan lokal yang disediakan (biasanya `http://localhost:5173/`) melalui browser Anda.
