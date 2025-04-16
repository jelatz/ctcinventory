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
                :href="route('dashboard')"
                class="relative hover:bg-[#e3e2e2] hover:text-[#162556] w-full text-left py-3 pl-16 block"
            >
                <span class="absolute left-4"><fa icon="fa-solid fa-house" size="lg"></fa></span>
                Dashboard
            </Link>
            <NavButton
                buttonValue="Users"
                :faIcon="['fas', 'user']"
                :faSize="'lg'"
                buttonID="users"
                :isOpen="openMenu === 'users'"
            />
            <NavButton
                buttonValue="Categories"
                :faIcon="['fas', 'layer-group']"
                :faSize="'lg'"
                buttonID="categories"
                :isOpen="openMenu === 'categories'"
                @toggle="toggleMenu"
                :subMenuToggle="subMenuToggle"
                linkName="another link"
                :route="route('profile')"
            />
            <NavButton
                buttonValue="Items"
                :faIcon="['fas', 'box']"
                :faSize="'lg'"
                buttonID="items"
                :isOpen="openMenu === 'items'"
                @toggle="toggleMenu"
                :subMenuToggle="subMenuToggle"
                linkName="Profile"
                :route="route('profile')"
            />
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
