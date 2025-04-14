<template>
    <button
        type="button"
        class="cursor-pointer relative w-full py-3 pl-16 block text-left hover:bg-[#e3e2e2] hover:transition-[background-color 0.4s] hover:text-[#162556]"
        :id="buttonID"
    >
        <span class="absolute left-3">{{ faIcon }}</span>
        {{ buttonValue }} <span class="absolute right-5">></span>
    </button>
</template>

<script setup>
import { defineProps } from "vue";

defineProps({
    buttonValue: String,
    faIcon: String,
    buttonID: String,
});
</script>

<style scoped></style>
