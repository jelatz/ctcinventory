<template>

    <Head title="Roles" />
    <div class="p-10">
        <h1 class="text-3xl font-bold">Roles</h1>

        <!-- Add Button -->
        <button class="block bg-blue-950 hover:bg-blue-500 px-5 mt-3 ml-auto py-2 text-white" @click="addRole">
            Add Role
        </button>

        <!-- Table -->
        <Table :headers="currentHeaders" :rows="paginatedRows" :total-items="filteredRoles.length" @fetch="handleFetch">
            <!-- Action Slot -->
            <template #Action="{ row }">
                <button @click="editRole(row)"
                    class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 mr-2">
                    Edit
                </button>
                <button @click="deleteRole(row)"
                    class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                    Delete
                </button>
            </template>
        </Table>

        <!-- Modal -->
        <Modal :isOpen="showModal" @close="closeModal" modalSize="w-[40rem]"
            :modalTitle="isEditing ? 'Edit Role' : 'Add Role'">
            <form class="p-5" @submit.prevent="submitForm">
                <FormInput formLabel="Role Name" labelFor="role" formInputType="input" v-model="form.role"
                    inputClass="w-full" :formError="formErrors.role" @input="formErrors.role = false"
                    :formErrorMessage="errorMessages.role" containerClass="w-full" />

                <FormInput formLabel="Role Description" labelFor="roleDescription" formInputType="textarea"
                    v-model="form.roleDescription" inputClass="w-full" :formError="formErrors.roleDescription"
                    @input="formErrors.roleDescription = false" :formErrorMessage="errorMessages.roleDescription"
                    containerClass="w-full" />

                <button type="submit"
                    class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                    {{ isEditing ? "Update" : "Add" }}
                </button>
            </form>
        </Modal>
    </div>
</template>

<script setup>
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import { ref, computed, watch, onMounted } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { formatDateTime } from "@/Utils/date";
import { validateFields, applyFilters, handleValidationErrors, confirmDelete } from "@/Utils/helpers";
import Swal from "sweetalert2";

const showModal = ref(false);
const isEditing = ref(false);
const currentRoleId = ref(null);

const page = usePage();
const roles = ref(page.props.roles);

// Error states
const formErrors = ref({
    role: false,
    roleDescription: false,
});

const errorMessages = ref({
    role: "",
    roleDescription: "",
});

// Table Headers
const currentHeaders = ref([
    { label: "Action", key: "action" },
    { label: "Role Name", key: "name" },
    { label: "Description", key: "description" },
    { label: "Created At", key: "created_at" },
]);

// States for filtering and pagination
const filteredRoles = ref([...roles.value]);
const paginatedRows = ref([]);
const tableParams = ref({
    page: 1,
    pageSize: 10,
    search: "",
    sortColumn: null,
    sortDirection: "asc",
});

// Watch for props update (e.g. when roles reload from Inertia)
watch(
    () => page.props.roles,
    (newRoles) => {
        roles.value = newRoles;
    }
);

// Handle table emit
function handleFetch(params) {
    tableParams.value = params;
    const result = applyFilters(roles.value, currentHeaders.value, tableParams.value);
    filteredRoles.value = result.filtered;
    paginatedRows.value = result.paginated;
}

// Initialize data on mount
onMounted(() => {
    const result = applyFilters(roles.value, currentHeaders.value, tableParams.value);
    filteredRoles.value = result.filtered;
    paginatedRows.value = result.paginated;
});


// Reusable Form
const form = useForm({
    role: "",
    roleDescription: "",
});

// Add Role Button
function addRole() {
    isEditing.value = false;
    form.reset();
    showModal.value = true;
}

// Edit Role
function editRole(role) {
    isEditing.value = true;
    currentRoleId.value = role.id;
    form.role = role.name;
    form.roleDescription = role.description;
    showModal.value = true;
}

// Close Modal
function closeModal() {
    showModal.value = false;
    form.reset();
    isEditing.value = false;
}

// Submit (Add or Edit)
function submitForm() {
    if (!validateFields(form, ["role", "roleDescription"], formErrors, errorMessages)) return;

    if (isEditing.value) {
        // Find original role
        const originalRole = roles.value.find(r => r.id === currentRoleId.value);

        if (!originalRole) {
            Swal.fire("Error", "Original role not found.", "error");
            return;
        }

        // Check if any changes were made
        const noChanges =
            form.role.trim() === originalRole.name.trim() &&
            form.roleDescription.trim() === (originalRole.description?.trim() || "");

        if (noChanges) {
            formErrors.value.role = true;

            return;
        }

        // Proceed with update
        form.put(route("roles.update", currentRoleId.value), {
            onSuccess: () => {
                Swal.fire("Updated!", "Role updated successfully.", "success");
                closeModal();
                router.reload({ only: ["roles"] });
            },
            onError: (errors) => handleValidationErrors(errors, formErrors.value, errorMessages.value),
        });
    } else {
        // Add new role
        form.post(route("roles.store"), {
            onSuccess: () => {
                Swal.fire("Success!", "Role added successfully.", "success");
                closeModal();
                router.reload({ only: ["roles"] });
            },
            onError: (errors) => handleValidationErrors(errors, formErrors.value, errorMessages.value),
        });
    }
}

// Delete Role
function deleteRole(role) {
    confirmDelete(`role: ${role.name}`, () => {
        router.delete(route("roles.destroy", role.id), {
            onSuccess: () => Swal.fire("Deleted!", "Role removed.", "success"),
            onError: () => Swal.fire("Error", "Failed to delete role.", "error"),
        });
    });
}
</script>
