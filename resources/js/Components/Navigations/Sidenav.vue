<!-- Sidenav.vue -->
<template>
    <div class="bg-blue-950 text-white sidenav overflow-hidden transition-all duration-600 ease-in-out text-nowrap"
        :class="isShown ? 'w-80' : 'w-0'">
        <div class="flex justify-center flex-col py-5 items-center">
            <img :src="`/storage/ctc_logo.png`" alt="Calltek logo" class="w-24 h-24" />
            <p :class="[
                'mt-5 w-full text-center',
                isShown ? 'block' : 'text-transparent',
            ]">
                Calltek Inc.
            </p>
        </div>

        <div class="flex flex-col justify-center items-stretch mt-5">
            <Link @click="$emit('close-dropdown')" :href="route('dashboard')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block" :class="{
                    'bg-[#e2e2e2] text-[#162556]':
                        $page.component === 'Dashboard',
                }">
            <span class="absolute left-4">
                <fa icon="fa-solid fa-house" size="lg"></fa>
            </span>
            Dashboard
            </Link>
            <Link @click="$emit('close-dropdown')" :href="route('users.index')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block" :class="{
                    'bg-slate-100 text-[#162556]':
                        $page.component === 'Users/Index',
                }">
            <span class="absolute left-4">
                <fa icon="fa-solid fa-user" size="lg"></fa>
            </span>
            Users
            </Link>
            <NavButton buttonValue="Categories" :faIcon="['fas', 'layer-group']" :faSize="'lg'" buttonID="categories"
                :isOpen="openMenu === 'categories'" @toggle="toggleMenu" :subMenuToggle="subMenuToggle"
                @click="$emit('close-dropdown')" :subLinks="[
                    {
                        name: 'Item Categories',
                        route: route('category.item'),
                        component: 'Category/ItemCategory',
                    },
                    {
                        name: 'Brands',
                        route: route('category.brands'),
                        component: 'Category/Brands',
                    },
                    {
                        name: 'Suppliers',
                        route: route('category.supplier'),
                        component: 'Category/Supplier',
                    },
                ]" />
            <Link @click="$emit('close-dropdown')" :href="route('items.index')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block" :class="{
                    'bg-[#e2e2e2] text-[#162556]':
                        $page.component === 'Item/Index',
                }">
            <span class="absolute left-4">
                <fa icon="fa-solid fa-box" size="lg"></fa>
            </span>
            Items
            </Link>
            <Link @click="$emit('close-dropdown')" :href="route('transactions.index')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block" :class="{
                    'bg-[#e2e2e2] text-[#162556]':
                        $page.component === 'Transaction/Index',
                }">
            <span class="absolute left-4">
                <fa icon="fa-solid fa-box" size="lg"></fa>
            </span>
            Transactions
            </Link>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import NavButton from "@/Components/Navigations/NavButton.vue";

const props = defineProps({
    isShown: Boolean,
});

const subMenuToggle = ref(props.isShown);

watch(
    () => props.isShown,
    (newVal) => {
        subMenuToggle.value = newVal;
    }
);

const openMenu = ref(null);

const toggleMenu = (id) => {
    openMenu.value = openMenu.value === id ? null : id;
};
</script>
