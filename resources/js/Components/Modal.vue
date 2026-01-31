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
    <!-- Backdrop -->
    <div class="fixed inset-0 z-50 flex justify-center" :class="{ 'pointer-events-none': !modelValue }">
        <Transition enter-active-class="transition-opacity ease-linear duration-300" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition-opacity ease-linear duration-300"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="modelValue" class="fixed inset-0 bg-black/30 backdrop-blur-sm pointer-events-auto"
                @click="emit('update:modelValue', false)"></div>
        </Transition>

        <!-- <div class="grid place-items-center z-50">
            hey
        </div> -->
    </div>
</template>

<style lang="css" scoped></style>