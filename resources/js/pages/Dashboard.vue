<template>

    <Head title="Dashboard" />
    <div class="p-10">
        <h1 class="text-2xl font-bold mb-5">Dashboard</h1>

        <div class="flex justify-evenly **:flex-1 gap-5 items-stretch flex-wrap">
            <DashboardCard v-for="card in dashboardCards" :key="card.type" :cardTitle="card.title"
                :totalItem="card.total" :faIcon="card.icon" :faSize="'lg'" faClass="text-left"
                @card-click="() => showTable(card.type)" />
        </div>

        <!-- table -->
        <Table :headers="currentHeaders" :rows="currentRows" v-if="currentHeaders.length" />
    </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import Table from "@/Components/Table.vue";
import DashboardCard from "@/Components/Dashboard/DashboardCard.vue";
import { Head } from "@inertiajs/vue3";

const tableSets = {
    totalItems: {
        headers: ["Item Name", "Category", "Quantity"],
        rows: [
            ["Laptop", "Devices", 5],
            ["Monitor", "Devices", 3],
            ["Printer", "Devices", 2],
            ["Tablet", "Devices", 4],
            ["Smartphone", "Devices", 6],
            ["Bondpaper", "Supplies", 10],
            ["Scissors", "Supplies", 5],
            ["Printing Paper", "Supplies", 2],
            ["White board", "Supplies", 1],
            ["Projector", "Furnitures", 2],
            ["Desk", "Furnitures", 4],
            ["Chair", "Furnitures", 6],
            ["Monitor", "Tools", 3],
            ["Printer", "Tools", 2],
            ["Laptop", "Tools", 5],
            ["Tablet", "Users", 4],
        ],
    },
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
        headers: ["Item Name", "Item Code", "Brand", "Model", "Status"],
        rows: [
            ["Drill", "D203", "Makita", "model1", "Available"],
            ["Drill", "D102", "Bosch", "model2", "Available"],
        ],
    },
    furnitures: {
        headers: ["Name", "Brand", "Location", "Status"],
        rows: [
            ["Couch", "brand1", "4th Floor Lobby", "Assigned"],
            ["Flower Pot", "brand1", "9th Floor Lobby", "Assigned"],
        ],
    },
    users: {
        headers: ["Name", "Department", "Position", "Status"],
        rows: [
            ["User1", "HR", "Supervisor", "Assigned"],
            ["User2", "IT", "Manager", "In Transfer"],
            ["User3", "HR", "Staff", "Assigned"],
            ["User4", "Finance", "Staff", "Assigned"],
            ["User5", "PCTECH", "Staff", "In Transfer"],
            ["User2", "PCTECH", "Staff", "In Transfer"],
        ],
    },
};

const dashboardCards = [
    {
        title: "Total Items",
        type: "totalItems",
        total: 5,
        icon: ["fas", "fa-layer-group"],
    },
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
