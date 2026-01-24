<script setup>
import { ref, reactive } from 'vue'
import { UserRound, Camera } from 'lucide-vue-next'
import FormInput from '@/components/FormInput.vue'

const fileInput = ref(null)
const preview = ref(null)

const triggerUpload = () => {
    fileInput.value.click()
}

const onFileChange = (e) => {
    const file = e.target.files[0]
    if (!file) return

    preview.value = URL.createObjectURL(file)
}

const roles = [
    { id: 1, text: 'Admin' },
    { id: 2, text: 'User' },
]

const departments = [
    { id: 1, text: 'HR' },
    { id: 2, text: 'IT' },
    { id: 3, text: 'Finance' }
]

// Form 
const submitForm = () => {
    console.log('Form submitted');
}

const form = reactive({
    username: '',
    role: '',
})
</script>

<template>
    <div class="flex items-center justify-center pt-20 flex-col">
        <!-- Clickable Avatar -->
        <div class="relative cursor-pointer group" @click="triggerUpload">
            <!-- Image Preview / Icon -->
            <div class="w-32 h-32 rounded-full border-2 border-gray-300
                       flex items-center justify-center overflow-hidden
                       hover:border-blue-500 transition">
                <img v-if="preview" :src="preview" class="w-full h-full object-cover" />
                <UserRound v-else size="120" class="text-gray-400" />
            </div>

            <!-- Camera Overlay -->
            <div class="absolute inset-0 bg-black/40 rounded-full
                       flex items-center justify-center opacity-0
                       group-hover:opacity-100 transition">
                <Camera class="text-white w-8 h-8" />
            </div>
        </div>

        <!-- Hidden File Input -->
        <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onFileChange" />

        <!-- Label -->
        <div class="mt-4 text-center">
            <p class="text-md text-blue-600 cursor-pointer hover:underline" @click="triggerUpload">
                Upload Profile Picture
            </p>
        </div>

        <div class="w-full px-20 mt-20">
            <form @submit.prevent="submitForm">
                <div class="grid grid-cols-1 gap-x-10 items-center w-150 mx-auto">
                    <FormInput v-model="form.username" label="Username" placeholder="Enter Username" required />
                    <h1 class="text-2xl font-bold mt-10">Change Passowrd</h1>
                    <FormInput v-model="form.password" type="password" label="Password" placeholder="Enter Password"
                        required />
                    <FormInput v-model="form.password_confirmation" type="password" label="Confirm Password"
                        placeholder="Enter Confirm Password" required />
                    <FormInput type="button" @click="submitForm" label="Update Password" />
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped></style>
