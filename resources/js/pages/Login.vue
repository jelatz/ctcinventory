<template>
    <div
        class="bg-[#e9e9e9] w-full lg:w-[30%] h-screen flex flex-col justify-start pt-52 items-stretch text-center"
    >
        <img src="" alt="Logo" class="my-5 w-20 mx-auto" />
        <p class="tracking-widest mb-5">Calltek Center</p>
        <h2 class="text-2xl text-blue-950 text-shadow-blue-950">
            CTC Inventory System
        </h2>
        <form @submit.prevent="login" class="p-10 w-80%">
            <div>
                <label for="username" class="hidden">Username :</label>
                <input
                    type="text"
                    id="username"
                    v-model="username"
                    class="px-5 py-2 bg-white rounded-lg w-full"
                    placeholder="Enter Username"
                />
            </div>
            <div class="mt-5">
                <label for="password" class="hidden">Password :</label>
                <input
                    type="password"
                    id="password"
                    v-model="password"
                    class="px-5 py-2 bg-white rounded-lg w-full"
                    placeholder="Enter Password"
                />
            </div>
            <button
                type="button"
                class="mt-3 w-fit block pointer-events-auto hover:text-blue-800"
            >
                Forgot Password?
            </button>
            <button
                type="submit"
                class="mt-10 px-5 py-4 shadow-lg pointer-events-auto hover:bg-blue-800 w-full rounded-lg bg-blue-900 font-bold text-white"
            >
                Sign In
            </button>
        </form>
    </div>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
defineOptions({ layout: GuestLayout });
</script>

<style lang="scss" scoped></style>
