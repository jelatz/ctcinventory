<template>
    <div class="overflow-x-auto mt-10 w-full md:w-[90%] mx-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th
                        v-for="(header, index) in headers"
                        :key="index"
                        class="text-left px-4 py-2 border-b"
                    >
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(row, rowIndex) in rows"
                    :key="rowIndex"
                    class="even:bg-gray-100"
                >
                    <td
                        v-for="(value, colIndex) in row"
                        :key="colIndex"
                        class="px-4 py-2 border-b"
                    >
                        {{ value }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps({
    headers: Array,
    rows: Array,
});
</script>
