<!-- NavButton.vue -->
<template>
    <div class="w-full text-nowrap m-0 p-0">
        <button
            type="button"
            class="cursor-pointer relative w-full py-3 pl-16 block text-left hover:bg-[#e3e2e2] hover:text-[#162556]"
            :id="buttonID"
            @click="$emit('toggle', buttonID)"
        >
            <fa :icon="faIcon" :size="faSize" class="absolute left-4 pt-1" />
            {{ buttonValue }}
            <span
                :class="[
                    'absolute transition-all duration-600 ease-in-out',
                    subMenuToggle ? 'right-5' : 'hidden',
                    isOpen ? 'rotate-0' : '-rotate-90',
                ]"
            >
                <fa icon="fa-solid fa-caret-down" size="lg" />
            </span>
        </button>

        <!-- Submenus -->
        <div
            :class="[
                'overflow-hidden bg-[#222f57] w-full transition-all duration-600 ease-in-out',
                isOpen ? 'max-h-40' : 'max-h-0 py-0',
            ]"
        >
            <!-- Loop over submenu links -->
            <Link
                v-for="(link, index) in subLinks"
                :key="index"
                :href="link.route"
                class="block w-full text-white hover:text-[#e3e2e2] hover:bg-blue-900 py-3 pl-16"
            >
                {{ link.name }}
            </Link>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

defineProps({
    buttonValue: String,
    faIcon: String,
    buttonID: String,
    isOpen: Boolean,
    subMenuToggle: Boolean,
    route: String,
    subLinks: Array,
});
</script>
