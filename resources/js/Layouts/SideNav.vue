<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { Home, Users, Boxes, Files, ArrowLeftRight, ChartColumnStacked, User, IdCardLanyard } from 'lucide-vue-next'


const props = defineProps({
    collapsed: Boolean,
})

const page = usePage()
const openMenu = ref(null)


/* Permissions from backend */
const permissions = computed(() => page.props.auth?.permissions ?? [])


/* Helpers */
const hasPermission = (perm) => {
    if (!perm) return true
    return permissions.value.includes(perm)
}

// const isActive = (href) => {
//     return page.url === href || page.url.startsWith(href + '/')
// }

const isActive = (href, children = []) => {
    const relativeHref = href.replace(window.location.origin, '');
    if (page.url === relativeHref || page.url.startsWith(relativeHref + '/')) return true;

    // Check children
    return children.some(child => {
        const childHref = child.href.replace(window.location.origin, '');
        return page.url === childHref || page.url.startsWith(childHref + '/');
    });
}

const toggleMenu = (href) => {
    openMenu.value = openMenu.value === href ? null : href
}

const menu = [
    {
        label: 'Dashboard',
        href: route('dashboard'),
        icon: Home,
    },
    {
        label: 'Users',
        href: route('users.index'),
        icon: Users,
        permission: 'manage_users',
        children: [
            { label: 'Manage Users', href: route('users.index'), icon: User },
            { label: 'Employees', href: route('employees.index'), icon: IdCardLanyard }
        ],
    },
    {
        label: 'Categories',
        href: route('categories.index'),
        icon: ChartColumnStacked,
        permission: 'manage_categories',
    },
    {
        label: 'Assets',
        href: route('assets.index'),
        icon: Boxes,
        permission: 'manage_assets',
        children: [
            { label: 'Manage Assets', href: route('assets.index'), icon: Boxes },
            { label: 'Assignments', href: route('assignments.index'), icon: ArrowLeftRight },
        ],
    },
    {
        label: 'Reports',
        href: route('reports.index'),
        icon: Files,
        permission: 'view_reports',
    },
]



</script>

<template>
    <aside :class="[
        'bg-blue-950 min-h-screen transition-all duration-300',
        collapsed ? 'w-20' : 'w-72'
    ]">
        <!-- Logo -->
        <div class="p-6 flex items-center justify-between">
            <img src="../../images/ctc-logo.webp" class="transition-all duration-300"
                :class="collapsed ? 'w-full mx-auto py-2' : 'w-full'" />
        </div>
        <!-- v-if="hasPermission(item.permission)" -->
        <!-- Menu -->
        <ul class="text-white">
            <li v-for="item in menu" :key="item.href">
                <!-- Parent -->
                <div v-if="item.children"
                    class=" flex items-center justify-between px-5 py-4 cursor-pointer hover:bg-blue-900"
                    @click="item.children ? toggleMenu(item.href) : null">
                    <div class="flex items-center gap-3">
                        <!-- Icon -->
                        <span class="w-5 text-center mr-5">
                            <component :is="item.icon" />
                        </span>

                        <!-- Label -->
                        <span v-if="!collapsed">
                            {{ item.label }}
                        </span>
                    </div>

                    <!-- Chevron -->
                    <span v-if="item.children && !collapsed" class="transition-transform"
                        :class="{ 'rotate-90': openMenu === item.href }">
                        ▶
                    </span>
                </div>

                <!-- NO children → normal Link -->
                <Link v-else :href="item.href" class="flex items-center px-5 py-4 hover:bg-blue-900"
                    :class="{ 'bg-[#E55207]': isActive(item.href) }">
                    <span class="w-5 text-center mr-5">
                        <component :is="item.icon" />
                    </span>

                    <span v-if="!collapsed">
                        {{ item.label }}
                    </span>
                </Link>

                <!-- Submenu -->
                <transition enter-active-class="transition-all duration-300"
                    leave-active-class="transition-all duration-200" enter-from-class="opacity-0 max-h-0"
                    enter-to-class="opacity-100 max-h-40" leave-from-class="opacity-100 max-h-40"
                    leave-to-class="opacity-0 max-h-0">
                    <ul v-if="item.children && openMenu === item.href" class="bg-blue-900/50 overflow-hidden">
                        <li v-for="child in item.children" :key="child.href">
                            <Link :href="child.href" class="flex items-center pl-5 pr-6 py-4 text-sm hover:bg-blue-800"
                                :class="{ 'bg-[#E55207]': isActive(child.href) }">
                                <div class="flex items-center gap-3">
                                    <span class="w-5 text-center mr-5">
                                        <component :is="child.icon" />
                                    </span>
                                    <span v-if="!collapsed">
                                        {{ child.label }}
                                    </span>
                                </div>
                            </Link>
                        </li>
                    </ul>
                </transition>
            </li>
        </ul>

    </aside>
</template>


<style lang="scss" scoped></style>