<template>
    <div>
        <!-- cards -->
        <div
            class="flex justify-center gap-12 px-2 items-center flex-wrap mt-5"
        >
            <DashboardCard
                cardTitle="Total Items"
                totalItem="5"
                :faIcon="['fas', 'fa-box']"
                :faSize="'lg'"
            />
            <DashboardCard
                cardTitle="Available Items"
                totalItem="5"
                :faIcon="['fas', 'fa-clipboard-check']"
                :faSize="'lg'"
            />
            <DashboardCard
                cardTitle="Assigned Items"
                totalItem="5"
                :faIcon="['fas', 'fa-user-check']"
                :faSize="'lg'"
            />
            <DashboardCard
                cardTitle="Items in Transfer"
                totalItem="5"
                :faIcon="['fas', 'fa-exchange-alt']"
                :faSize="'lg'"
            />
            <DashboardCard
                cardTitle="Disposed Items"
                totalItem="5"
                :faIcon="['fas', 'fa-trash-alt']"
                :faSize="'lg'"
            />
            <DashboardCard
                cardTitle="Item Categories"
                totalItem="5"
                :faIcon="['fas', 'fa-layer-group']"
                :faSize="'lg'"
            />
            <DashboardCard
                cardTitle="Total Users"
                totalItem="5"
                :faIcon="['fas', 'fa-users']"
                :faSize="'lg'"
            />
            <DashboardCard
                cardTitle="Item Returns Today"
                totalItem="5"
                :faIcon="['fas', 'fa-undo-alt']"
                :faSize="'lg'"
            />
            <DashboardCard
                cardTitle="Low Stock Items"
                totalItem="5"
                :faIcon="['fas', 'fa-exclamation-triangle']"
                :faSize="'lg'"
            />
        </div>
    </div>
</template>

<script setup>
import { defineEmits } from "vue";
import DashboardCard from "@/Components/Dashboard/DashboardCard.vue";
const emit = defineEmits(["toggleSidenav"]);

const toggle = () => {
    emit("toggleSidenav");
};
</script>
