import { h, render } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";

export function useConfirm() {
  return function confirm(options) {
    return new Promise((resolve) => {
      const container = document.createElement("div");
      document.body.appendChild(container);

      const close = () => {
        render(null, container);
        container.remove();
      };

      const onConfirm = () => {
        resolve(true);
        close();
      };

      const onCancel = () => {
        resolve(false);
        close();
      };

      const vnode = h(ConfirmationModal, {
        ...options,
        onConfirm,
        onCancel,
      });

      render(vnode, container);
    });
  };
}
