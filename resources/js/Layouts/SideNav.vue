<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const isActive = (href) => {
    return page.url.startsWith(href)
}

const menu = [
    { label: 'Dashboard', href: '/dashboard' },
    { label: 'Reports', href: '/reports' },
]

</script>

<template>
    <div class="bg-blue-950 min-h-screen w-96">
        <a :href="route('dashboard')"><img src="../../images/ctc-logo.webp" class="p-14" alt="Calltek Logo"></a>

        <ul class="**:text-lg **:text-white">
            <li v-for="item in menu" :key="item.href">
                <Link :href="item.href" class="px-6 py-4 block hover:bg-blue-900"
                    :class="{ 'bg-blue-900': isActive(item.href) }">
                    {{ item.label }}
                </Link>
            </li>
        </ul>
    </div>
</template>

<style lang="scss" scoped></style>