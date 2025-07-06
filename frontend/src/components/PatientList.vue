<template>
  <div>
    <router-link to="/patient/new" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
      + Tambah Pasien
    </router-link>
    <table class="min-w-full bg-white border rounded shadow">
      <thead class="bg-gray-200">
        <tr>
          <th class="py-2 px-4">Nama</th>
          <th class="py-2 px-4">NIK</th>
          <th class="py-2 px-4">Jenis Kelamin</th>
          <th class="py-2 px-4">Phone</th>
          <th class="py-2 px-4">Alamat</th>
          <th class="py-2 px-4">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="patient in patients" :key="patient.id" class="border-t">
          <td class="py-2 px-4">{{ patient.name }}</td>
          <td class="py-2 px-4 text-center">{{ patient.nik }}</td>
          <td class="py-2 px-4 text-center">{{ patient.sex }}</td>
          <td class="py-2 px-4 text-center">{{ patient.phone }}</td>
          <td class="py-2 px-4 text-center">{{ patient.address }}</td>
          <td class="py-2 px-4 space-x-2 text-center">
            <router-link :to="`/patient/${patient.id}`" class="text-blue-500">Edit</router-link>
            <button @click="deletePatient(patient.id)" class="text-red-500">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import api from '../services/api'

const patients = ref([])

const fetchPatients = async () => {
  const res = await api.getPatients()
  patients.value = res.data.data
  
}

const deletePatient = async (id) => {
  if (confirm('Yakin hapus pasien?')) {
    await api.deletePatient(id)
    fetchPatients()
  }
}

onMounted(fetchPatients)
</script>