<template>
    <div class="p-10">
        <h1 class="text-2xl font-bold">Dashboard</h1>

        <div
            class="flex justify-between gap-5 px-2 items-center flex-wrap mt-5"
        >
            <DashboardCard
                v-for="card in dashboardCards"
                :key="card.type"
                :cardTitle="card.title"
                :totalItem="card.total"
                :faIcon="card.icon"
                :faSize="'lg'"
                @card-click="() => showTable(card.type)"
            />
        </div>

        <!-- table -->
        <Table
            :headers="currentHeaders"
            :rows="currentRows"
            v-if="currentHeaders.length"
        />
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import Table from "@/Components/Table.vue";
import DashboardCard from "@/Components/Dashboard/DashboardCard.vue";

const tableSets = {
    devices: {
        headers: [
            "Device Type",
            "Item Code",
            "Brand",
            "Model",
            "Serial Number",
            "Status",
        ],
        rows: [
            ["Laptop", "IT001", "Dell", "XPS 13", "SN123456", "Assigned"],
            [
                "Monitor",
                "IT002",
                "Samsung",
                "Odyssey G7",
                "SN654321",
                "Not Assigned",
            ],
            ["Printer", "IT003", "HP", "LaserJet Pro", "SN789012", "Assigned"],
            ["Tablet", "IT004", "Apple", "iPad Pro", "SN345678", "In Transfer"],
            [
                "Smartphone",
                "IT005",
                "Google",
                "Pixel 6",
                "SN901234",
                "In Transfer",
            ],
        ],
    },
    supplies: {
        headers: ["Name", "Quantity"],
        rows: [
            ["Bondpaper", 10],
            ["Scissors", 5],
            ["Printing Paper", 2],
            ["White board", 1],
            ["Tablet", 3],
        ],
    },
    tools: {
        headers: ["Item Name", "Category", "Status"],
        rows: [
            ["Monitor", "Electronics", "Available"],
            ["Printer", "Electronics", "Available"],
        ],
    },
    furnitures: {
        headers: ["Item Name", "Category", "Status"],
        rows: [
            ["Laptop", "Electronics", "Assigned"],
            ["Projector", "Electronics", "Assigned"],
        ],
    },
    users: {
        headers: ["Item Name", "Category", "Status"],
        rows: [
            ["Tablet", "Electronics", "In Transfer"],
            ["Smartphone", "Electronics", "In Transfer"],
        ],
    },
};

const dashboardCards = [
    {
        title: "Devices",
        type: "devices",
        total: 5,
        icon: ["fas", "fa-desktop"],
    },
    {
        title: "Supplies",
        type: "supplies",
        total: 5,
        icon: ["fas", "fa-box"],
    },
    {
        title: "Tools",
        type: "tools",
        total: 5,
        icon: ["fas", "fa-clipboard-check"],
    },
    {
        title: "Furnitures",
        type: "furnitures",
        total: 5,
        icon: ["fas", "fa-user-check"],
    },
    { title: "Users", type: "users", total: 5, icon: ["fas", "fa-users"] },
];

const currentHeaders = ref([]);
const currentRows = ref([]);

const showTable = (type) => {
    if (tableSets[type]) {
        currentHeaders.value = tableSets[type].headers;
        currentRows.value = tableSets[type].rows;
    }
};

onMounted(() => {
    showTable("devices"); // default on load
});
</script>
<style scoped></style>
