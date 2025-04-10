<template>
    <div>
        <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="text-black mt-10"
        >
            Logout
        </Link>
    </div>
</template>

<script setup>
import { defineEmits } from "vue";
const emit = defineEmits(["toggleSidenav"]);

const toggle = () => {
    emit("toggleSidenav");
};
</script>
