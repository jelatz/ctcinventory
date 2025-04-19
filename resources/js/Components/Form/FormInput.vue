<template>
    <div class="mb-4">
        <label :for="labelFor" class="block mb-1 font-semibold">
            {{ formLabel }}
        </label>
        <input
            v-if="formInputType === 'input'"
            :id="labelFor"
            ref="dateInput"
            @focus="inputType === 'date' && openDatePicker()"
            v-model="localValue"
            :class="['w-72 h-10 border rounded p-2', inputClass]"
            :type="inputType"
            :disabled="disabled"
        />

        <select
            v-else-if="formInputType === 'select'"
            :id="labelFor"
            v-model="localValue"
            class="w-72 h-10 border rounded p-2"
        >
            <option
                v-for="(option, index) in options"
                :key="index"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>

        <textarea
            v-else-if="formInputType === 'textarea'"
            :id="labelFor"
            v-model="localValue"
            class="w-72 h-10 border rounded p-2"
            rows="4"
        ></textarea>
        <p v-if="formError" class="text-red-600">{{ formErrorMessage }}</p>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    modelValue: [String, Number],
    formInputType: String,
    formLabel: String,
    labelFor: String,
    inputType: {
        type: String,
        default: "text",
    },
    options: {
        type: Array,
        default: () => [],
    },
    inputClass: String,
    formError: Boolean,
    formErrorMessage: String,
    disabled: Boolean,
});

const emit = defineEmits(["update:modelValue"]);

const localValue = ref(props.modelValue);

// Watch for external changes and emit updates
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
    background-color: red !important;
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
