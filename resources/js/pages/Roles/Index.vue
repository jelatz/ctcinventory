<template>

    <Head title="Roles" />
    <div class="p-10">
        <h1 class="text-3xl font-bold">Roles</h1>

        <button class="block bg-blue-950 hover:bg-blue-500 px-5 mt-3 ml-auto py-2 text-white" @click="showModal = true">
            Add Role
        </button>

        <!-- ✅ Table -->
        <Table :headers="currentHeaders" :rows="currentRows" :total-items="roles.length">
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
        <Modal :isOpen="showModal" @close="showModal = false" modalSize="w-[40rem]" modalTitle="Add Role">
            <form class="p-5" @submit.prevent="submitAddRole">
                <FormInput formLabel="Role Name" labelFor="role" formInputType="input" v-model="form.role"
                    inputClass="w-full" :formError="false" errorMessage="Please enter a role" containerClass="w-full" />
                <FormInput formLabel="Role Description" labelFor="roleDescription" formInputType="textarea"
                    v-model="form.roleDescription" inputClass="w-full" :formError="false"
                    errorMessage="Please enter a role" containerClass="w-full" />
                <button type="submit"
                    class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                    Add
                </button>
            </form>
        </Modal>
    </div>
</template>

<script setup>
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FormInput from "@/Components/Form/FormInput.vue";
import { ref, computed, watch } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { formatDateTime } from "@/Utils/date";
import Swal from "sweetalert2";

const showModal = ref(false);
const page = usePage();
const roles = ref(page.props.roles);

// ✅ Headers with keys and labels
const currentHeaders = ref([
    { label: "Action", key: "action" },
    { label: "Role Name", key: "name" },
    { label: "Description", key: "description" },
    { label: "Created At", key: "created_at" },
]);

// ✅ Rows as objects
const currentRows = computed(() =>
    roles.value.map((r) => ({
        id: r.id,
        name: r.name,
        description: r.description,
        created_at: formatDateTime(r.created_at),
    }))
);

watch(
    () => page.props.roles,
    (newRoles) => {
        roles.value = newRoles;
    }
);

// Form
const form = useForm({
    role: "",
    roleDescription: "",
});

function submitAddRole() {
    form.post(route("roles.store"), {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
            Swal.fire("Success", "Role added successfully", "success");
            router.reload({ only: ["roles"] });
        },
        onError: () => Swal.fire("Error", "Failed to add role", "error"),
    });
}

function deleteRole(role) {
    Swal.fire({
        title: "Are you sure?",
        text: `Delete role: ${role.name}?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("roles.destroy", role.id), {
                onSuccess: () => Swal.fire("Deleted!", "Role removed.", "success"),
            });
        }
    });
}

function editRole(role) {
    console.log("Edit role:", role);
}
</script>
