<!-- Sidenav.vue -->
<template>
    <div
        class="bg-blue-950 text-white sidenav overflow-hidden transition-all duration-600 ease-in-out text-nowrap"
        :class="isShown ? 'w-96' : 'w-14'"
    >
        <div class="flex justify-center flex-col p-5 items-center">
            <img src="" alt="Calltek Logo" />
            <p
                :class="[
                    'mt-5 w-full text-center',
                    isShown ? 'block' : 'text-transparent',
                ]"
            >
                Calltek Inc.
            </p>
        </div>

        <div class="flex flex-col justify-center items-stretch mt-5">
            <Link
                @click="$emit('close-dropdown')"
                :href="route('dashboard')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block"
            >
                <span class="absolute left-4"
                    ><fa icon="fa-solid fa-house" size="lg"></fa
                ></span>
                Dashboard
            </Link>
            <Link
                @click="$emit('close-dropdown')"
                :href="route('users.index')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block"
            >
                <span class="absolute left-4"
                    ><fa icon="fa-solid fa-user" size="lg"></fa
                ></span>
                Users
            </Link>
            <Link
                @click="$emit('close-dropdown')"
                :href="route('category.index')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block"
            >
                <span class="absolute left-4"
                    ><fa icon="fa-solid fa-layer-group" size="lg"></fa
                ></span>
                Category
            </Link>
            <Link
                @click="$emit('close-dropdown')"
                :href="route('items.index')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block"
            >
                <span class="absolute left-4"
                    ><fa icon="fa-solid fa-box" size="lg"></fa
                ></span>
                Items
            </Link>
            <NavButton
                buttonValue="Transactions"
                :faIcon="['fas', 'left-right']"
                :faSize="'lg'"
                buttonID="transactions"
                :isOpen="openMenu === 'transactions'"
                @toggle="toggleMenu"
                :subMenuToggle="subMenuToggle"
                linkName="Profile"
                :route="route('profile')"
                @click="$emit('close-dropdown')"
                :subLinks="[
                    {
                        name: 'Item Assignment',
                        route: route('items.assignment'),
                    },
                    { name: 'Item Return', route: route('items.return') },
                    { name: 'Item Transfer', route: route('items.transfer') },
                    { name: 'Item Adjustment', route: '#' },
                    { name: 'Item Disposal', route: '#' },
                ]"
            />
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

const faDashboard = ref("D");
const openMenu = ref(null);

const toggleMenu = (id) => {
    openMenu.value = openMenu.value === id ? null : id;
};
</script>
