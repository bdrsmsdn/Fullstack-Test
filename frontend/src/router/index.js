import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Patients.vue'
import PatientDetail from '../pages/PatientDetail.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/patient/:id', component: PatientDetail }
]

export default createRouter({
  history: createWebHistory(),
  routes
})
