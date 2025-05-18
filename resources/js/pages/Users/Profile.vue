<template>
    <div>
        <div class="p-10">
            <h1 class="text-3xl">Account Settings</h1>

            <button
                class="text-right block ml-auto w-fit bg-blue-950 text-white px-4 py-2 rounded-lg mt-5 cursor-pointer hover:bg-blue-900"
                @click="showModal = true">
                Change Password
            </button>
            <!-- Modal For Change Password -->
            <Modal :isOpen="showModal" @close="showModal = false" modalSize="w-96">
                <h2 class="text-xl font-semibold mb-4">Update Password</h2>
                <form @submit.prevent="submitChangePassword">
                    <FormInput formInputType="input" labelFor="oldPassword" inputType="password"
                        formLabel="Old Password" inputClass="w-full" v-model="changePassForm.oldPassword" />
                    <FormInput formInputType="input" labelFor="newPassword" inputType="password"
                        formLabel="New Password" inputClass="w-full" v-model="changePassForm.newPassword" />
                    <FormInput formInputType="input" labelFor="confirmPassword" inputType="password"
                        formLabel="Confirm New Password" inputClass="w-full"
                        v-model="changePassForm.password_confirmation" />
                    <button type="submit"
                        class="bg-blue-950 text-white cursor-pointer hover:bg-blue-900 px-4 py-2 rounded  block ml-auto"
                        :disabled="changePassForm.processing">
                        Submit
                    </button>
                </form>
            </Modal>

            <!-- main  -->
            <div class="shadow-lg px-10 py-5 rounded-lg">
                <form @submit.prevent="submitUpdateProfile">
                    <img :src="$page.props.auth.profile_picture" alt="profile picture"
                        class="rounded-full w-20 h-20 block mx-auto" />
                    <div class="flex items-center justify-between flex-wrap profile-form gap-3">
                        <FormInput formInputType="input" formLabel="American Name" labelFor="americanName"
                            inputType="text" inputClass="w-full" :disabled="$page.props.auth.user.role_id != 0
                                ? true
                                : false
                                " v-model="updateProfile.username" />
                        <FormInput formInputType="select" formLabel="Role" labelFor="role" inputClass="w-full" :options="[
                            { label: 'Admin', value: 'admin' },
                            { label: 'User', value: 'user' },
                        ]" v-model="updateProfile.role" :disabled="$page.props.auth.user.role_id != 0
                            ? true
                            : false
                            " selectPlaceholder="Select Role" />
                        <FormInput formInputType="input" formLabel="Email" labelFor="email" inputType="email"
                            inputClass="w-full" v-model="updateProfile.email" :disabled="$page.props.auth.user.role_id != 0
                                ? true
                                : false
                                " />
                        <FormInput formInputType="input" formLabel="Real Name" labelFor="realName" inputClass="w-full"
                            inputType="text" v-model="updateProfile.realName" />
                        <FormInput formInputType="input" formLabel="Password" labelFor="password" inputClass="w-full"
                            inputType="password" v-model="updateProfile.password" />
                        <FormInput formInputType="input" formLabel="Date Added" labelFor="dateAdded" inputClass="w-full"
                            inputType="date" v-model="updateProfile.dateAdded" :disabled="$page.props.auth.user.role_id != 0
                                ? true
                                : false
                                " />
                        <FormInput formInputType="input" formLabel="Status" labelFor="status" inputClass="w-full"
                            inputType="text" v-model="updateProfile.status" :disabled="$page.props.auth.user.role_id != 1
                                ? true
                                : false
                                " />
                    </div>
                    <button
                        class="px-5 py-2 rounded-lg bg-blue-950 text-white mt-5 block ml-auto mr-18 cursor-pointer hover:bg-blue-900">
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

// eventlistenter to close all modal after Escape keydown
document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
        showModal.value = false;
    }
})
</script>

<style scoped>
.profile-form div {
    width: 18rem;
}
</style>
