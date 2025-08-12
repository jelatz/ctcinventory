<template>
    <div>
        <div class="p-10">
            <h1 class="text-2xl font-bold mb-5">Users</h1>

            <div class="flex items-center justify-end">
                <button class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                    @click="userModal = true">
                    Add User
                </button>
                <!-- User Modal -->
                <Modal :isOpen="userModal" @close="
                    () => {
                        userModal = false;
                        resetUserForm();
                    }
                " modalSize="w-3/4">
                    <h2 class="text-2xl font-semibold mb-4">Add User</h2>
                    <form>
                        <div class="flex items-center justify-between gap-5 flex-wrap mt-10">
                            <FormInput formLabel="Email" labelFor="email" formInputType="input" inputType="email"
                                v-model="userForm.email" inputClass="w-full" :formError="false" errorMessage="This field is
                        required" containerClass="w-60" />
                            <FormInput formLabel="Username" labelFor="username" formInputType="input"
                                inputType="username" v-model="userForm.username" inputClass="w-full" :formError="false"
                                errorMessage="This field is
                        required" containerClass="w-60" />
                            <FormInput formLabel="First Name" labelFor="firstName" formInputType="input"
                                inputType="text" v-model="userForm.firstName" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />
                            <FormInput formLabel="Middle Name" labelFor="middleName" formInputType="input"
                                inputType="text" v-model="userForm.middleName" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />
                            <FormInput formLabel="Last Name" labelFor="lastName" formInputType="input" inputType="text"
                                v-model="userForm.lastName" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />

                        </div>

                        <button type="submit"
                            class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                            Add
                        </button>
                    </form>
                </Modal>

                <!-- <button class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                    @click="positionModal = true">
                    Add Position
                </button>
                Position Modal
                <Modal :isOpen="positionModal" @close="positionModal = false" modalSize="w-96">
                    <h2 class="text-xl font-semibold mb-4">Add Position</h2>
                    <form>
                        <FormInput formLabel="Position Name" labelFor="position" formInputType="input"
                            v-model="position" inputClass="w-full" :formError="false"
                            errorMessage="Please enter a position" containerClass="w-full" />
                        <button type="submit"
                            class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                            Add
                        </button>
                    </form>
                </Modal>

                <button class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                    @click="departmentModal = true">
                    Add Department
                </button> -->
                <!-- Department Modal -->
                <!-- <Modal :isOpen="departmentModal" @close="departmentModal = false" modalSize="w-96">
                    <h2 class="text-xl font-semibold mb-4">Add Department</h2>
                    <form>
                        <FormInput formLabel="Department Name" labelFor="department" formInputType="input"
                            v-model="department" inputClass="w-full" :formError="false"
                            errorMessage="Please enter a department" containerClass="w-full" />
                        <button type="submit"
                            class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                            Add
                        </button>
                    </form>
                </Modal> -->
            </div>
            <Table :headers="currentHeaders" :rows="currentRows" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Modal from "@/Components/Modal.vue";
import "vue-select/dist/vue-select.css";

const userModal = ref(false);
const positionModal = ref(false);
const departmentModal = ref(false);
import Table from "@/Components/Table.vue";
import FormInput from "../../Components/Form/FormInput.vue";
const tableSets = {
    totalItems: {
        headers: ["Employee ID", "Name", "Position", "Department", "Action"],
        rows: [
            ["E001", "John Doe", "Software Engineer", "IT", "Edit"],
            ["E002", "Jane Smith", "Project Manager", "Marketing", "Edit"],
            ["E003", "Sam Wilson", "Data Analyst", "Finance", "Edit"],
            ["E004", "Lisa Brown", "UX Designer", "Design", "Edit"],
            ["E005", "Tom Green", "Sales Executive", "Sales", "Edit"],
        ],
    },
};

const department = ref("");
const departmentOptions = [
    { id: "1", label: "IT Dev" },
    { id: "2", label: "IT Network" },
    { id: "3", label: "HR" },
    { id: "4", label: "Operations" },
    { id: "5", label: "QA" },
];

const account = ref("");
const accountOptions = [
    { id: "1", label: "Sagenet" },
    { id: "2", label: "NOC" },
    { id: "3", label: "NOC BPRF" },
    { id: "4", label: "Cloud 5" },
    { id: "5", label: "NOC" },
];

// User Form
const userForm = ref({
    firstName: "",
    middleName: "",
    lastName: "",
    email: "",
    username: "",
    department: "",
    account: "",
    role: "",
});

// Reset function
function resetUserForm() {
    userForm.value = {
        firstName: "",
        middleName: "",
        lastName: "",
        email: "",
        username: "",
        department: "",
        account: "",
        role: "",
    };
}
const currentHeaders = ref([]);
const currentRows = ref([]);

// Initialize on mount
onMounted(() => {
    currentHeaders.value = tableSets.totalItems.headers;
    currentRows.value = tableSets.totalItems.rows;
});

// Escape key event listener (closes the modal)
document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
        userModal.value = false;
        positionModal.value = false;
        departmentModal.value = false;
        showModal.value = false;
    }
});
</script>

<style scoped></style>
