import { createRouter, createWebHistory } from 'vue-router'
import Beranda from '../views/Beranda.vue'
import Deteksi1 from '../views/Deteksi1.vue'
import Deteksi2 from '../views/Deteksi2.vue'
import Deteksi3 from '../views/Deteksi3.vue'
import Riwayat from '../views/Riwayat.vue'
import Profil from '../views/Profil.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'beranda',
      component: Beranda
    },
    {
      path: '/deteksi',
      name: 'deteksi1',
      component: Deteksi1
    },
    {
      path: '/deteksi-2',
      name: 'deteksi2',
      component: Deteksi2
    },
    {
      path: '/deteksi-3',
      name: 'deteksi3',
      component: Deteksi3
    },
    {
      path: '/riwayat',
      name: 'riwayat',
      component: Riwayat
    },
    {
      path: '/profil',
      name: 'profil',
      component: Profil
    }
  ]
})

export default router
