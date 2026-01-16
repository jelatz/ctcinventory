<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import FormInput from "@/Components/FormInput.vue";

const form = useForm({
    username: '',
    password: '',
});

const submit = () => {
    console.log(form.data());
    // form.post(route('login'));
};
</script>

<template>
    <div class="grid place-items-center pt-36">
        <img src="../../../images/ctc-logo.webp" alt="">
        <h1 class="text-6xl font-bold mt-10">Inventory System</h1>
        <h2 class="text-3xl font-semibold mt-10">Login</h2>
        <form @submit.prevent="submit" class="w-full max-w-md mt-8">
            <div>
                <FormInput v-model="form.username" label="Username :" placeholder="Enter Username" required />

                <FormInput v-model="form.password" type="password" label="Password :" placeholder="Enter Password"
                    required />

            </div>
            <div class="mt-4">
                <FormInput type="button" @click="submit" label="Login" />
            </div>
        </form>
    </div>
</template>

<style scoped></style>