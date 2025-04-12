<template>
    <div :class="isShow ? 'block' : 'hidden'">
        <slot />
    </div>
</template>

<script setup>
defineProps({
    isShow: Boolean,
});
</script>

<style scoped></style>
