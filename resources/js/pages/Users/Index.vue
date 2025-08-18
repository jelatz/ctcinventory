<template>
    <div>
        <div class="p-10">
            <h1 class="text-2xl font-bold mb-5">Users</h1>

            <div class="flex items-center justify-end">
                <button class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                    @click="userModal = true">
                    Add User
                </button>
                <!-- Add User Modal -->
                <Modal :isOpen="userModal" @close="
                    () => {
                        userModal = false;
                        resetUserForm();
                    }
                " modalSize="w-[60rem]" modalTitle="Add User">
                    <form class="p-5" @submit.prevent="submitAddUser">
                        <div class="flex items-center flex-wrap *:flex-3/4 justify-between p-5">
                            <FormInput formLabel="Email" labelFor="email" formInputType="input" inputType="email"
                                v-model="userForm.email" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-full" />
                            <FormInput formLabel="Username" labelFor="username" formInputType="input" inputType="text"
                                v-model="userForm.username" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-full" />
                            <FormInput formLabel="First Name" labelFor="firstName" formInputType="input"
                                inputType="text" v-model="userForm.first_name" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-full" />
                            <FormInput formLabel="Middle Name" labelFor="middleName" formInputType="input"
                                inputType="text" v-model="userForm.middle_name" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-full" />
                            <FormInput formLabel="Last Name" labelFor="lastName" formInputType="input" inputType="text"
                                v-model="userForm.last_name" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-full" />
                        </div>

                        <button type="submit"
                            class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                            Add
                        </button>
                    </form>
                </Modal>
            </div>

            <!-- User Table -->
            <Table :headers="headers" :rows="rows" :total-items="props.users.length" @fetch="handleFetch">
                <template #Action="{ value: user }">
                    <button @click="editUser(user)" class="text-blue-600 hover:underline">
                        Edit
                    </button>
                    |
                    <button @click="deleteUser(user)" class="text-red-600 hover:underline">
                        Delete
                    </button>
                </template>
            </Table>

            <!-- Edit User Modal -->
            <Modal :isOpen="editUserModal" @close="
                () => {
                    editUserModal = false;
                    resetUserForm();
                }
            " modalSize="w-[30rem]" modalTitle="Edit User">
                <form class="p-5">
                    <div class="flex items-center flex-wrap *:flex3/4 justify-between mt-10 p-5">
                        <FormInput formLabel="Email" labelFor="email" formInputType="input" inputType="email"
                            v-model="userForm.email" inputClass="w-full" :formError="false"
                            errorMessage="This field is required" containerClass="w-full" />
                        <FormInput formLabel="Username" labelFor="username" formInputType="input" inputType="text"
                            v-model="userForm.username" inputClass="w-full" :formError="false"
                            errorMessage="This field is required" containerClass="w-full" />
                        <FormInput formLabel="First Name" labelFor="firstName" formInputType="input" inputType="text"
                            v-model="userForm.first_name" inputClass="w-full" :formError="false"
                            errorMessage="This field is required" containerClass="w-full" />
                        <FormInput formLabel="Middle Name" labelFor="middleName" formInputType="input" inputType="text"
                            v-model="userForm.middle_name" inputClass="w-full" :formError="false"
                            errorMessage="This field is required" containerClass="w-full" />
                        <FormInput formLabel="Last Name" labelFor="lastName" formInputType="input" inputType="text"
                            v-model="userForm.last_name" inputClass="w-full" :formError="false"
                            errorMessage="This field is required" containerClass="w-full" />
                    </div>

                    <button type="submit"
                        class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                        Save
                    </button>
                </form>
            </Modal>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import Modal from "@/Components/Modal.vue";
import Table from "@/Components/Table.vue";
import FormInput from "@/Components/Form/FormInput.vue";

const userModal = ref(false);
const editUserModal = ref(false);
const selectedUser = ref(null);

const props = defineProps({
    users: Array
});

const headers = ["Name", "Action"];
const rows = props.users.map(user => [
    user.username,
    user
]);

// User Form
const userForm = useForm({
    first_name: "",
    middle_name: "",
    last_name: "",
    email: "",
    username: "",
});

// Add User
function submitAddUser() {
    userForm.post(route('users.store')), {
        onSuccess: () => {
            Swal.fire({
                title: 'Success',
                text: 'User added successfully!',
                icon: 'success',
                confirmButtonColor: '#2563eb'
            });
        }, onError: () => {
            Swal.fire({
                title: 'Error',
                text: 'Failed to add user.',
                icon: 'error',
                confirmButtonColor: '#2563eb'
            });
        }
    };
}

// Reset form
function resetUserForm() {
    userForm.value = {
        first_name: "",
        middle_name: "",
        last_name: "",
        email: "",
        username: "",
    };
}

// Edit user
function editUser(user) {
    editUserModal.value = true;
    selectedUser.value = user;
    userForm.value = {
        first_name: user.first_name,
        middle_name: user.middle_name,
        last_name: user.last_name,
        email: user.email,
        username: user.username,
    };
}


function deleteUser(user) {
    Swal.fire({
        title: `Delete ${user.username}?`,
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            // Call your API
            Swal.fire('Deleted!', 'User has been deleted.', 'success')
        }
    })
}
</script>
