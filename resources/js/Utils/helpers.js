export function formatDate(dateStr) {
    if (!dateStr) return "";
    const date = new Date(dateStr);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
}

export function formatDateTime(dateString) {
    if (!dateString) return "-";
    const d = new Date(dateString);
    return d.toLocaleString("en-PH", {
        year: "numeric",
        month: "short",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
    });
}

export function capitalize(str) {
    if (!str) return "";
    return str.charAt(0).toUpperCase() + str.slice(1);
}

export function truncate(text, length = 50) {
    return text.length > length ? text.substring(0, length) + "..." : text;
}

// resources/js/Utils/validation.js
export function validateFields(form, fields, formErrors, errorMessages) {
    formErrors.value = {};
    errorMessages.value = {};

    let valid = true;

    fields.forEach((field) => {
        if (!form[field].trim()) {
            formErrors.value[field] = true;
            errorMessages.value[field] = `Please enter a ${field
                .replace(/([A-Z])/g, " $1")
                .toLowerCase()}.`;
            valid = false;
        } else {
            formErrors.value[field] = false;
            errorMessages.value[field] = "";
        }
    });

    return valid;
}

// Apply filtering, sorting, and pagination to a dataset
export function applyFilters(data, headers, params) {
    const { page, pageSize, search, sortColumn, sortDirection } = params;

    const formattedData = data.map((item) => {
        const newItem = { ...item };
        for (const key in newItem) {
            const val = newItem[key];
            if (typeof val === "string" && /\d{4}-\d{2}-\d{2}T/.test(val)) {
                newItem[key] = formatDateTime(val);
            }
        }
        return newItem;
    });
    // Filter
    let filtered = formattedData.filter((item) =>
        Object.values(item).some((val) =>
            String(val || "")
                .toLowerCase()
                .includes(search.toLowerCase())
        )
    );

    // Sort
    if (sortColumn !== null) {
        const key = headers[sortColumn].key;
        filtered = [...filtered].sort((a, b) => {
            const aVal = a[key] ?? "";
            const bVal = b[key] ?? "";
            if (aVal < bVal) return sortDirection === "asc" ? -1 : 1;
            if (aVal > bVal) return sortDirection === "asc" ? 1 : -1;
            return 0;
        });
    }

    // Paginate
    const start = (page - 1) * pageSize;
    const end = start + pageSize;
    const paginated = filtered.slice(start, end);

    return { filtered, paginated };
}

export function handleValidationErrors(errors, formErrors, errorMessages) {
    Object.keys(errors).forEach((field) => {
        if (formErrors[field] !== undefined) {
            formErrors[field] = true;
            errorMessages[field] = errors[field];
        }
    });

    Swal.fire("Error", "Please check the form for validation errors.", "error");
}

export function confirmDelete(itemName, onConfirm) {
    Swal.fire({
        title: "Are you sure?",
        text: `Delete ${itemName}?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) onConfirm();
    });
}
