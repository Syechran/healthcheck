import { createRouter, createWebHistory } from 'vue-router'
import Beranda from '../views/Beranda.vue'
import Deteksi1 from '../views/Deteksi1.vue'
import Deteksi2 from '../views/Deteksi2.vue'
import Deteksi3 from '../views/Deteksi3.vue'
import Riwayat from '../views/Riwayat.vue'
import Profil from '../views/Profil.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import { useAuthStore } from '../stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: { guest: true }
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: { guest: true }
    },
    {
      path: '/',
      name: 'beranda',
      component: Beranda,
      meta: { requiresAuth: true }
    },
    {
      path: '/deteksi',
      name: 'deteksi1',
      component: Deteksi1,
      meta: { requiresAuth: true }
    },
    {
      path: '/deteksi-2',
      name: 'deteksi2',
      component: Deteksi2,
      meta: { requiresAuth: true }
    },
    {
      path: '/deteksi-3',
      name: 'deteksi3',
      component: Deteksi3,
      meta: { requiresAuth: true }
    },
    {
      path: '/riwayat',
      name: 'riwayat',
      component: Riwayat,
      meta: { requiresAuth: true }
    },
    {
      path: '/profil',
      name: 'profil',
      component: Profil,
      meta: { requiresAuth: true }
    }
  ]
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: 'login' })
  } else if (to.meta.guest && authStore.isAuthenticated) {
    next({ name: 'beranda' })
  } else {
    next()
  }
})

export default router
