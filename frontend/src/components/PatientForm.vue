<template>
  <form @submit.prevent="handleSubmit" class="bg-white p-6 rounded shadow w-full max-w-md justify-center mx-auto">
    <h1 class="text-2xl font-bold mb-4">{{ editMode ? 'Edit Pasien' : 'Tambah Pasien' }}</h1>
    <div class="mb-4">
      <label class="block mb-1">Nama</label>
      <input v-model="form.name" class="w-full border rounded px-3 py-2" required />
    </div>
    <div class="mb-4">
      <label class="block mb-1">NIK</label>
      <input v-model="form.nik" class="w-full border rounded px-3 py-2" required />
    </div>
    <div class="mb-4">
      <label class="block mb-1">Jenis Kelamin</label>
      <select v-model="form.sex" class="w-full border rounded px-3 py-2">
        <option value="">-- Pilih --</option>
        <option value="Male">Laki-laki</option>
        <option value="Female">Perempuan</option>
      </select>
    </div>
    <div class="mb-4">
      <label class="block mb-1">Agama</label>
      <input v-model="form.religion" class="w-full border rounded px-3 py-2" />
    </div>
    <div class="mb-4">
      <label class="block mb-1">Telepon</label>
      <input v-model="form.phone" class="w-full border rounded px-3 py-2" />
    </div>
    <div class="mb-4">
      <label class="block mb-1">Alamat</label>
      <textarea v-model="form.address" class="w-full border rounded px-3 py-2"></textarea>
    </div>
    <div class="text-right space-x-2">
      <button type="button" @click="router.push('/')" class="bg-gray-400 text-white px-4 py-2 rounded">
        Batal
      </button>
      <button type="submit" onclick="" class="bg-green-500 text-white px-4 py-2 rounded">
        {{ editMode ? 'Update' : 'Simpan' }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../services/api'

const props = defineProps({ editMode: Boolean })
const route = useRoute()
const router = useRouter()

const form = ref({
  name: '', nik: '', sex: '', religion: '', phone: '', address: ''
})

onMounted(async () => {
  if (props.editMode && route.params.id) {
    const res = await api.getPatient(route.params.id)
    form.value = res.data.data
  }
})

const handleSubmit = async () => {
  if (props.editMode) {
    await api.updatePatient(route.params.id, form.value)
  } else {
    await api.createPatient(form.value)
  }
  router.push('/')
}
</script>