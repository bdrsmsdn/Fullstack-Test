<template>
  <div class="grid h-screen place-items-center">
      <PatientForm :editMode="isEditMode" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import PatientForm from '../components/PatientForm.vue'

const route = useRoute()
const isEditMode = computed(() => {
  const id = route.params.id
  return id !== 'new' && !!id
})

</script>