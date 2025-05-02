<template>
    <div class="mb-4">
        <!-- Label -->
        <label :for="labelFor" class="block mb-1 font-semibold text-md">
            {{ formLabel }}
        </label>

        <!-- Input -->
        <input
            v-if="formInputType === 'input'"
            :id="labelFor"
            ref="dateInput"
            v-model="localValue"
            :type="inputType"
            :disabled="disabled"
            @focus="inputType === 'date' && openDatePicker()"
            :class="[
                'w-72 h-10 border rounded p-2',
                inputClass,
                formError ? 'border-red-500' : 'border-gray-300',
            ]"
        />

        <!-- Native Select -->
        <select
            v-else-if="formInputType === 'select'"
            :id="labelFor"
            v-model="localValue"
            :disabled="disabled"
            :class="[
                'w-72 h-10 border rounded p-2 bg-white',
                inputClass,
                formError ? 'border-red-500' : 'border-gray-300',
            ]"
        >
            <option disabled value="">
                {{ selectPlaceholder || "Select an option" }}
            </option>
            <option
                v-for="(option, index) in options"
                :key="index"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>

        <!-- Textarea -->
        <textarea
            v-else-if="formInputType === 'textarea'"
            :id="labelFor"
            v-model="localValue"
            :disabled="disabled"
            rows="4"
            :class="[
                'w-72 border rounded p-2',
                inputClass,
                formError ? 'border-red-500' : 'border-gray-300',
            ]"
        ></textarea>

        <!-- Error -->
        <p v-if="formError" class="text-red-600 mt-1 text-sm">
            {{ formErrorMessage }}
        </p>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    modelValue: [String, Number],
    formInputType: String,
    formLabel: String,
    labelFor: String,
    inputType: { type: String, default: "text" },
    options: { type: Array, default: () => [] },
    inputClass: String,
    formError: Boolean,
    formErrorMessage: String,
    disabled: Boolean,
    selectPlaceholder: String,
});

const emit = defineEmits(["update:modelValue"]);
const localValue = ref(props.modelValue);

watch(
    () => props.modelValue,
    (val) => (localValue.value = val)
);

watch(localValue, (val) => {
    emit("update:modelValue", val);
});

const dateInput = ref(null);
function openDatePicker() {
    if (dateInput.value && typeof dateInput.value.showPicker === "function") {
        dateInput.value.showPicker();
    } else {
        dateInput.value.focus();
    }
}
</script>

<style scoped>
select option {
    padding: 0.5rem;
}
input:disabled,
select:disabled,
textarea:disabled {
    background-color: #f1f1f1;
    color: #6b7280;
    cursor: not-allowed;
    opacity: 0.7;
}
</style>
