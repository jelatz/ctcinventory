<template>
    <div :class="isShow ? 'block' : 'hidden'">
        <h1>hey</h1>
    </div>
</template>

<script setup>
defineProps({
    isShow: Boolean,
});
</script>

<style scoped></style>
