<template>
    <div>
        <div class="p-10">
            <h1 class="text-3xl">Account Settings</h1>

            <button
                class="text-right block ml-auto w-fit bg-blue-950 text-white px-4 py-2 rounded-lg mt-5 cursor-pointer hover:bg-blue-900"
                @click="showModal = true"
            >
                Change Password
            </button>
            <!-- Modal For Change Password -->
            <Modal
                :isOpen="showModal"
                @close="showModal = false"
                modalSize="w-96"
            >
                <h2 class="text-xl font-semibold mb-4">Update Password</h2>
                <form @submit.prevent="submitChangePassword">
                    <FormInput
                        formInputType="input"
                        labelFor="oldPassword"
                        inputType="password"
                        formLabel="Old Password"
                        inputClass="w-full"
                        v-model="changePassForm.oldPassword"
                    />
                    <FormInput
                        formInputType="input"
                        labelFor="newPassword"
                        inputType="password"
                        formLabel="New Password"
                        inputClass="w-full"
                        v-model="changePassForm.newPassword"
                    />
                    <FormInput
                        formInputType="input"
                        labelFor="confirmPassword"
                        inputType="password"
                        formLabel="Confirm New Password"
                        inputClass="w-full"
                        v-model="changePassForm.password_confirmation"
                    />
                    <button
                        type="submit"
                        class="bg-green-950 text-white px-4 py-2 rounded hover:bg-green-900 block ml-auto"
                        :disabled="changePassForm.processing"
                    >
                        Submit
                    </button>
                </form>
            </Modal>
            <div class="shadow-lg px-10 py-5 rounded-lg">
                <form @submit.prevent="submitUpdateProfile">
                    <div class="flex items-center space-x-18 flex-wrap">
                        <FormInput
                            formInputType="input"
                            formLabel="Username"
                            labelFor="username"
                            inputType="text"
                            :disabled="
                                $page.props.auth.user.role_id != 0
                                    ? true
                                    : false
                            "
                            v-model="updateProfile.username"
                        />
                        <FormInput
                            formInputType="select"
                            formLabel="Role"
                            labelFor="role"
                            :options="[
                                { label: 'Admin', value: 'admin' },
                                { label: 'User', value: 'user' },
                            ]"
                            v-model="updateProfile.role"
                            :disabled="
                                $page.props.auth.user.role_id != 0
                                    ? true
                                    : false
                            "
                        />
                        <FormInput
                            formInputType="input"
                            formLabel="Email"
                            labelFor="email"
                            inputType="email"
                            v-model="updateProfile.email"
                            :disabled="
                                $page.props.auth.user.role_id != 0
                                    ? true
                                    : false
                            "
                        />
                        <FormInput
                            formInputType="input"
                            formLabel="Real Name"
                            labelFor="realName"
                            inputType="text"
                            v-model="updateProfile.realName"
                        />
                        <FormInput
                            formInputType="input"
                            formLabel="Password"
                            labelFor="password"
                            inputType="password"
                            v-model="updateProfile.password"
                        />
                        <FormInput
                            formInputType="input"
                            formLabel="Added by"
                            labelFor="addedBy"
                            inputType="text"
                            v-model="updateProfile.addedBy"
                        />
                        <FormInput
                            formInputType="input"
                            formLabel="Date Added"
                            labelFor="dateAdded"
                            inputType="date"
                            v-model="updateProfile.dateAdded"
                        />
                        <FormInput
                            formInputType="input"
                            formLabel="Status"
                            labelFor="status"
                            inputType="text"
                            v-model="updateProfile.status"
                            v-if="$page.props.auth.user.role_id == 0"
                        />
                    </div>
                    <button
                        class="px-5 py-2 rounded-lg bg-blue-950 text-white mt-5 block ml-auto mr-18 cursor-pointer hover:bg-blue-900"
                    >
                        Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import FormInput from "@/Components/Form/FormInput.vue";
import Modal from "@/Components/Modal.vue";

const changePassForm = useForm({
    oldPassword: null,
    newPassword: null,
    password_confirmation: null,
});

const updateProfile = useForm({
    username: null,
    role: null,
    email: null,
    realName: null,
    password: null,
    addedBy: null,
    dateAdded: null,
    status: null,
});

const submitChangePassword = () => {
    console.log("yes");
    changePassForm.post(route("change.password"), {
        onError: (e) => {
            console.log(e);
        },
    });
};

const submitUpdateProfile = () => {
    updateProfile.post(route("update.profile"), {
        onError: (e) => {
            console.log(e);
            updateProfile.reset();
        },
    });
};

const showModal = ref(false);
</script>

<style scoped></style>
