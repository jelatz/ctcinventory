<template>
    <div><h1>dashboard page</h1></div>
</template>

<script setup>
import { defineEmits } from "vue";
const emit = defineEmits(["toggleSidenav"]);

const toggle = () => {
    emit("toggleSidenav");
};
</script>
