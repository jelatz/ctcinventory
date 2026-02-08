import { ref } from "vue";

export function useOffcanvasForm(defaultForm = {}) {
  const showOffcanvas = ref(false);
  const mode = ref("add");
  const selectedItem = ref(null);
  const form = ref({ ...defaultForm });

  const openOffcanvas = (action = "add", item = null) => {
    mode.value = action;
    selectedItem.value = item;
    form.value = item ? { ...item } : { ...defaultForm };
    showOffcanvas.value = true;
  };

  const closeOffcanvas = () => {
    showOffcanvas.value = false;
  };

  const applyChanges = (listRef) => {
    if (mode.value === "add") {
      listRef.value.push({ ...form.value });
    } else if (selectedItem.value) {
      Object.assign(selectedItem.value, form.value);
    }
    closeOffcanvas();
  };

  return {
    showOffcanvas,
    mode,
    selectedItem,
    form,
    openOffcanvas,
    closeOffcanvas,
    applyChanges,
  };
}
