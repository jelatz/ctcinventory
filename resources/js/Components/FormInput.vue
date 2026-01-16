<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue';

interface Option {
    id: string | number;
    text: string;
    label?: string;
    value?: string | number;
    [key: string]: any;
}

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean, Array] as any,
        default: ''
    },
    label: String,
    type: {
        type: String,
        default: 'text',
        validator: (value: string) => ['text', 'email', 'password', 'number', 'hidden', 'select', 'radio', 'textarea', 'button', 'checkbox', 'date', 'datetime-local'].includes(value)
    },
    placeholder: String,
    options: {
        type: Array as () => (string | number | Option)[],
        default: () => []
    },
    name: String,
    id: String,
    required: Boolean,
    error: String,
    disabled: Boolean,
    multiple: Boolean,
    rows: {
        type: Number,
        default: 3
    }
});

const emit = defineEmits<{
    (e: 'update:modelValue', value: any): void;
    (e: 'change', value: any): void;
    (e: 'click', event?: Event): void;
}>();

const inputId = computed(() => props.id || `input-${Math.random().toString(36).substring(2, 10)}`);
const containerRef = ref<HTMLElement | null>(null);
const isOpen = ref(false);
const searchQuery = ref('');

const normalizedOptions = computed((): { id: string | number; text: string }[] => {
    if (!props.options) return [];
    return props.options.map((opt) => {
        if (typeof opt === 'object' && opt !== null) {
            const optionObj = opt as Option;
            return {
                id: optionObj.id || optionObj.value!,
                text: optionObj.text || optionObj.label || String(optionObj.value)
            };
        }
        return { id: opt as string | number, text: String(opt) };
    });
});

const filteredOptions = computed(() => {
    if (!searchQuery.value) return normalizedOptions.value;
    const query = searchQuery.value.toLowerCase();
    return normalizedOptions.value.filter(opt =>
        String(opt.text).toLowerCase().includes(query)
    );
});

const isSelected = (optionId: string | number) => {
    if (props.multiple) {
        return Array.isArray(props.modelValue) && (props.modelValue as Array<string | number>).includes(optionId);
    }
    return props.modelValue == optionId;
};

// Display text logic
const selectedLabel = computed(() => {
    if (props.multiple) return '';
    const selected = normalizedOptions.value.find(opt => opt.id == props.modelValue);
    return selected ? selected.text : null;
});

const selectedTags = computed(() => {
    if (!props.multiple || !Array.isArray(props.modelValue)) return [];
    return normalizedOptions.value.filter(opt => (props.modelValue as Array<string | number>).includes(opt.id));
});

const toggleDropdown = () => {
    if (props.disabled) return;
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        searchQuery.value = '';
        nextTick(() => {
            const searchInput = containerRef.value?.querySelector('input[type="text"]') as HTMLInputElement;
            if (searchInput) searchInput.focus();
        });
    }
};

const selectOption = (option: { id: string | number; text: string }) => {
    if (props.multiple) {
        let newValue = Array.isArray(props.modelValue) ? [...(props.modelValue as Array<any>)] : [];
        if (newValue.includes(option.id)) {
            newValue = newValue.filter(id => id !== option.id);
        } else {
            newValue.push(option.id);
        }
        emit('update:modelValue', newValue);
        emit('change', newValue);
    } else {
        emit('update:modelValue', option.id);
        emit('change', option.id);
        isOpen.value = false;
    }
};

const removeTag = (id: string | number) => {
    if (!props.multiple) return;
    const newValue = ((props.modelValue as Array<any>) || []).filter(val => val !== id);
    emit('update:modelValue', newValue);
    emit('change', newValue);
};

const updateValue = (value: any) => {
    emit('update:modelValue', value);
    emit('change', value);
};

// Click outside
const handleClickOutside = (event: Event) => {
    if (containerRef.value && !containerRef.value.contains(event.target as Node)) {
        isOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div :class="['w-full', type !== 'hidden' ? 'mb-4' : '']">
        <!-- Label -->
        <label v-if="label && type !== 'hidden' && type !== 'button'" :for="inputId"
            class="block mb-1.5 text-md font-medium text-gray-700">
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>

        <!-- Custom Select -->
        <div v-if="type === 'select'" class="relative" ref="containerRef">
            <!-- Trigger -->
            <div @click="toggleDropdown" :class="[
                'w-full px-3 py-2 text-gray-900 border rounded-lg cursor-pointer bg-white flex items-center justify-between transition-all duration-200',
                isOpen ? 'ring-2 ring-primary-500 border-primary-500' : 'border-gray-300 hover:border-gray-400',
                disabled ? 'bg-gray-100 cursor-not-allowed opacity-75' : '',
                error ? 'border-red-500 bg-red-50' : ''
            ]">
                <div class="flex flex-wrap gap-1 items-center overflow-hidden">
                    <span v-if="!props.modelValue || (multiple && (props.modelValue as any[]).length === 0)"
                        class="text-gray-400">
                        {{ placeholder || 'Select option' }}
                    </span>

                    <!-- Single Value -->
                    <span v-else-if="!multiple" class="truncate">
                        {{ selectedLabel }}
                    </span>

                    <!-- Multiple Tags -->
                    <div v-else v-for="tag in selectedTags" :key="tag.id"
                        class="bg-gray-200 text-primary-800 text-xs font-medium me-1 px-2 py-0.5 rounded flex items-center">
                        {{ tag.text }}
                        <button type="button" @click.stop="removeTag(tag.id)"
                            class="ml-1 text-primary-600 hover:text-primary-800 focus:outline-none">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Chevron -->
                <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': isOpen }"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>

            <!-- Dropdown Menu -->
            <div v-if="isOpen"
                class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 flex flex-col">
                <!-- Search -->
                <div class="p-2 border-b border-gray-100">
                    <input type="text" v-model="searchQuery"
                        class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none"
                        placeholder="Search..." @click.stop>
                </div>

                <!-- Options -->
                <ul class="overflow-y-auto flex-1 py-1">
                    <li v-for="option in filteredOptions" :key="option.id" @click="selectOption(option)" :class="[
                        'px-4 py-2 text-sm cursor-pointer flex items-center justify-between',
                        isSelected(option.id) ? 'bg-primary-50 text-primary-700 font-medium' : 'text-gray-700 hover:bg-gray-50'
                    ]">
                        <span>{{ option.text }}</span>
                        <svg v-if="isSelected(option.id)" class="w-4 h-4 text-primary-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </li>
                    <li v-if="filteredOptions.length === 0" class="px-4 py-2 text-sm text-gray-400 text-center">
                        No results found
                    </li>
                </ul>
            </div>
        </div>

        <!-- Textarea -->
        <textarea v-else-if="type === 'textarea'" :id="inputId" :value="modelValue as string"
            @input="updateValue(($event.target as HTMLTextAreaElement).value)" :placeholder="placeholder" :rows="rows"
            :disabled="disabled" :class="[
                'w-full px-4 py-2 text-gray-900 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 outline-none',
                error ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white focus:bg-white',
                disabled ? 'bg-gray-100 cursor-not-allowed opacity-75' : ''
            ]"></textarea>

        <!-- Radio -->
        <div v-else-if="type === 'radio'" class="flex flex-wrap gap-4">
            <div v-for="option in normalizedOptions" :key="option.id" class="flex items-center">
                <input type="radio" :id="`${inputId}-${option.id}`" :name="name || inputId" :value="option.id"
                    :checked="modelValue == option.id" @change="updateValue(option.id)" :disabled="disabled"
                    class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 focus:ring-2">
                <label :for="`${inputId}-${option.id}`" class="ms-2 text-sm font-medium text-gray-900 cursor-pointer">
                    {{ option.text }}
                </label>
            </div>
        </div>

        <!-- Checkbox (Single) -->
        <div v-else-if="type === 'checkbox'" class="flex items-center">
            <input type="checkbox" :id="inputId" :checked="modelValue as boolean"
                @change="updateValue(($event.target as HTMLInputElement).checked)" :disabled="disabled"
                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 focus:ring-2">
            <label v-if="placeholder" :for="inputId" class="ms-2 text-sm font-medium text-gray-900 cursor-pointer">
                {{ placeholder }}
            </label>
        </div>

        <!-- Button -->
        <button v-else-if="type === 'button'" :type="type" @click="emit('click')" :disabled="disabled"
            class="w-full px-5 py-2.5 text-sm font-medium text-white bg-blue-950 rounded-lg hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
            {{ label || modelValue }}
        </button>

        <!-- Standard Inputs (Text, Password, etc.) -->
        <input v-else :type="type" :id="inputId" :value="modelValue"
            @input="updateValue(($event.target as HTMLInputElement).value)" :placeholder="placeholder"
            :disabled="disabled" :class="[
                type === 'hidden' ? '' : 'w-full px-4 py-2 text-gray-900 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 outline-none',
                error ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white focus:bg-white',
                disabled ? 'bg-gray-100 cursor-not-allowed opacity-75' : ''
            ]">

        <!-- Error Message -->
        <p v-if="error" class="mt-1 text-sm text-red-600">
            {{ error }}
        </p>
    </div>
</template>