<template>
    <div class="p-10">
        <!-- cards -->
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="flex justify-center gap-5 px-2 items-center flex-wrap mt-5">
            <DashboardCard
                cardTitle="Total Items"
                :totalItem="5"
                :faIcon="['fas', 'fa-box']"
                :faSize="'lg'"
                @card-click="() => showTable('totalItems')"
            />
            <DashboardCard
                cardTitle="Total Devices"
                :totalItem="5"
                :faIcon="['fas', 'fa-box']"
                :faSize="'lg'"
                @card-click="() => showTable('totalDevices')"
            />
            <DashboardCard
                cardTitle="Available Items"
                :totalItem="5"
                :faIcon="['fas', 'fa-clipboard-check']"
                :faSize="'lg'"
                @card-click="() => showTable('availableItems')"
            />
            <DashboardCard
                cardTitle="Assigned Items"
                :totalItem="5"
                :faIcon="['fas', 'fa-user-check']"
                :faSize="'lg'"
                @card-click="() => showTable('assignedItems')"
            />
            <DashboardCard
                cardTitle="Items in Transfer"
                :totalItem="5"
                :faIcon="['fas', 'fa-exchange-alt']"
                :faSize="'lg'"
                @card-click="() => showTable('itemsInTransfer')"
            />
            <DashboardCard
                cardTitle="Disposed Items"
                :totalItem="5"
                :faIcon="['fas', 'fa-trash-alt']"
                :faSize="'lg'"
                @card-click="() => showTable('disposedItems')"
            />
            <DashboardCard
                cardTitle="Item Categories"
                :totalItem="5"
                :faIcon="['fas', 'fa-layer-group']"
                :faSize="'lg'"
                @card-click="() => showTable('itemCategories')"
            />
            <DashboardCard
                cardTitle="Total Users"
                :totalItem="5"
                :faIcon="['fas', 'fa-users']"
                :faSize="'lg'"
                @card-click="() => showTable('totalUsers')"
            />
            <DashboardCard
                cardTitle="Item Returns Today"
                :totalItem="5"
                :faIcon="['fas', 'fa-undo-alt']"
                :faSize="'lg'"
                @card-click="() => showTable('itemReturnsToday')"
            />
            <DashboardCard
                cardTitle="Low Stock Items"
                :totalItem="5"
                :faIcon="['fas', 'fa-exclamation-triangle']"
                :faSize="'lg'"
                @card-click="() => showTable('lowStockItems')"
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
    totalItems: {
        headers: ["Item Name", "Category", "Quantity"],
        rows: [
            ["Mouse", "Electronics", "10"],
            ["Keyboard", "Electronics", "10"],
        ],
    },
    totalDevices: {
        headers: [
            "Device Type",
            "Item Code",
            "Brand",
            "Model",
            "Serial Number",
        ],
        rows: [
            ["Laptop", "IT001", "Dell", "XPS 13", "SN123456"],
            ["Monitor", "IT002", "Samsung", "Odyssey G7", "SN654321"],
        ],
    },
    availableItems: {
        headers: ["Item Name", "Category", "Status"],
        rows: [
            ["Monitor", "Electronics", "Available"],
            ["Printer", "Electronics", "Available"],
        ],
    },
    assignedItems: {
        headers: ["Item Name", "Category", "Status"],
        rows: [
            ["Laptop", "Electronics", "Assigned"],
            ["Projector", "Electronics", "Assigned"],
        ],
    },
    itemsInTransfer: {
        headers: ["Item Name", "Category", "Status"],
        rows: [
            ["Tablet", "Electronics", "In Transfer"],
            ["Smartphone", "Electronics", "In Transfer"],
        ],
    },
    disposedItems: {
        headers: ["Item Name", "Category", "Status"],
        rows: [
            ["Old Monitor", "Electronics", "Disposed"],
            ["Old Printer", "Electronics", "Disposed"],
        ],
    },
    itemCategories: {
        headers: ["Category Name", "Description"],
        rows: [
            ["Electronics", "Devices and gadgets"],
            ["Furniture", "Office and home furniture"],
        ],
    },
    itemReturnsToday: {
        headers: ["Item Name", "User", "Return Date"],
        rows: [
            ["Laptop", "John Doe", "2023-10-01"],
            ["Projector", "Jane Smith", "2023-10-01"],
        ],
    },
    lowStockItems: {
        headers: ["Item Name", "Category", "Stock Level"],
        rows: [
            ["Mouse", "Electronics", "Low"],
            ["Keyboard", "Electronics", "Low"],
        ],
    },
    totalUsers: {
        headers: ["Name", "Email", "Role"],
        rows: [
            ["John Doe", "john@example.com", "Admin"],
            ["Jane Smith", "jane@example.com", "User"],
        ],
    },
};

const currentHeaders = ref([]);
const currentRows = ref([]);

const showTable = (type) => {
    if (tableSets[type]) {
        currentHeaders.value = tableSets[type].headers;
        currentRows.value = tableSets[type].rows;
    }
};

onMounted(() => {
    showTable("totalItems");
});
</script>

<style scoped>
table thead th {
    padding: 0.4rem;
}
</style>
