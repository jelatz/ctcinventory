<script setup>
defineProps({
    modelValue: {
        type: Boolean,
        required: true
    }
})

const emit = defineEmits(['update:modelValue'])
</script>
   
<template>
    <div class="fixed inset-0 z-50 flex justify-end" :class="{ 'pointer-events-none': !modelValue }">
        <!-- Backdrop -->
        <Transition enter-active-class="transition-opacity ease-linear duration-300" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition-opacity ease-linear duration-300"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="modelValue" class="fixed inset-0 bg-black/30 backdrop-blur-sm pointer-events-auto"
                @click="emit('update:modelValue', false)"></div>
        </Transition>

        <!-- Offcanvas Panel -->
        <Transition enter-active-class="transform transition ease-in-out duration-300"
            enter-from-class="translate-x-full" enter-to-class="translate-x-0"
            leave-active-class="transform transition ease-in-out duration-300" leave-from-class="translate-x-0"
            leave-to-class="translate-x-full">
            <div v-if="modelValue"
                class="relative w-1/2 md:w-1/3 bg-white h-full shadow-2xl p-6 overflow-y-auto pointer-events-auto">
                <button @click="emit('update:modelValue', false)"
                    class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
                    <!-- Close Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <slot />
            </div>
        </Transition>
    </div>
</template>

<style lang="css" scoped></style>