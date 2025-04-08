<template>
    <div class="text-center mt-96">hsssey</div>
    <Link
        :href="route('logout')"
        method="post"
        as="button"
        type="button"
        class="text-black"
        @click="reloadPage"
    >
        Logout
    </Link>
</template>

<script setup>
const reloadPage = () => {
    window.location.reload();
};
</script>
