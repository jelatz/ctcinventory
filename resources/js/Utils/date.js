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
