<script setup>
import { onMounted } from 'vue'
import { useToast } from '@/Composables/useToast'
import Toast from '@/Components/Toast.vue'
const { add } = useToast()

onMounted(() => {
    add('Saved successfully')
})
</script>

<template>
    <div>
        <Toast />
        <h1>Dashboard page</h1>
    </div>
</template>

<style scoped></style>