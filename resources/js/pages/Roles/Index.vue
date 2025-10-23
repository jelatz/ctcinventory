<template>

    <Head title="Roles" />
    <div class="p-10">
        <h1 class="text-3xl font-bold">Roles</h1>
        <button class="block bg-blue-950 hover:bg-blue-500 px-5 mt-3 ml-auto py-2 text-white"
            @click="showModal = true">Add
            Role</button>
        <Table :headers="currentHeaders" :rows="currentRows" v-if="currentHeaders.length" />

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
import { ref, watch, computed } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { formatDateTime } from "@/Utils/date";
import Swal from "sweetalert2";
import Modal from "@/Components/Modal.vue";
import FormInput from "@/Components/Form/FormInput.vue";

const showModal = ref(false);
const page = usePage();
const roles = ref(page.props.roles);

const currentHeaders = ref(["Role Name", "Description", "Created At"]);
const currentRows = computed(() =>
    roles.value.map((r) => [
        r.name,
        r.description,
        formatDateTime(r.created_at),
    ])
);


watch(
    () => page.props.roles,
    (newRoles) => {
        roles.value = newRoles;
        currentRows.value = newRoles.map(role => [
            role.name,
            role.description,
            role.created_at,
        ]);
    }
);

const form = useForm({
    role: "",
    roleDescription: ""
});

function submitAddRole() {
    form.post(route('roles.store'), {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
            Swal.fire("Success", "Role added successfully", "success");

            // ✅ refresh roles data from server
            router.reload({ only: ["roles"] });
        },
        onError: () => {
            Swal.fire("Error", "Failed to add role", "error");
        }
    });
}
</script>


<style lang="scss" scoped></style>