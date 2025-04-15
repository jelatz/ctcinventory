<!-- Sidenav.vue -->
<template>
    <div
        class="bg-blue-950 text-white sidenav overflow-hidden transition-all duration-600 ease-in-out text-nowrap"
        :class="isShown ? 'w-96' : 'w-14'"
    >
        <div class="flex justify-center flex-col p-5 items-center">
            <img src="" alt="Calltek Logo" />
            <p class="mt-5 w-full text-center">Calltek Inc.</p>
        </div>

        <div class="flex flex-col justify-center items-center mt-5 text-nowrap">
            <Link
                :href="route('dashboard')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block text-nowrap"
            >
                <span :class="['absolute', isShown ? 'left-5' : 'left-6']">{{
                    faDashboard
                }}</span>
                Dashboard
            </Link>
            <NavButton
                buttonValue="Users"
                faIcon="U"
                buttonID="users"
                :isOpen="openMenu === 'users'"
                @toggle="toggleMenu"
                :subMenuToggle="subMenuToggle"
            />
            <NavButton
                buttonValue="Categories"
                faIcon="C"
                buttonID="categories"
                :isOpen="openMenu === 'categories'"
                @toggle="toggleMenu"
                :subMenuToggle="subMenuToggle"
            />
            <NavButton
                buttonValue="Items"
                faIcon="I"
                buttonID="items"
                :isOpen="openMenu === 'items'"
                @toggle="toggleMenu"
                :subMenuToggle="subMenuToggle"
            />
            <NavButton
                buttonValue="Transactions"
                faIcon="T"
                buttonID="transactions"
                :isOpen="openMenu === 'transactions'"
                @toggle="toggleMenu"
                :subMenuToggle="subMenuToggle"
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
