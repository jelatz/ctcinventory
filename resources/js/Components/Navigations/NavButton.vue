<!-- NavButton.vue -->
<template>
    <div class="w-full text-nowrap">
        <button
            type="button"
            class="cursor-pointer relative w-full py-3 pl-16 block text-left hover:bg-[#e3e2e2] hover:text-[#162556]"
            :id="buttonID"
            @click="$emit('toggle', buttonID)"
        >
            <span class="absolute left-5">{{ faIcon }}</span>
            {{ buttonValue }}
            <span :class="['absolute', subMenuToggle ? 'right-5' : 'hidden']"
                >></span
            >
        </button>

        <div
            :class="[
                'overflow-hidden bg-red-600 w-full pl-16 transition-all duration-600 ease-in-out',
                isOpen ? 'max-h-40 py-3' : 'max-h-0 py-0',
            ]"
        >
            <h1>{{ buttonValue }} submenu</h1>
            <p>More content...</p>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

defineProps({
    buttonValue: String,
    faIcon: String,
    buttonID: String,
    isOpen: Boolean, // received from parent
    subMenuToggle: Boolean,
});
</script>
