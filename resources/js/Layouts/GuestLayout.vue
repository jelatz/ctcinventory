<template>
    <div class="flex justify-stretch items-center">
        <div class="w-0 lg:w-[70%] bg-red-800" v-if="page.url === '/'">
            <h1>hey</h1>
        </div>
        <slot />
    </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<style lang="scss" scoped></style>
