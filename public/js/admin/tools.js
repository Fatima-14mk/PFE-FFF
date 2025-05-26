document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("tool-form-modal");
  const formTitle = document.getElementById("tool-form-title");
  const addBtn = document.querySelector(".add-newtool-btn");
  const closeBtn = document.getElementById("close-tool-form");
  const editBtns = document.querySelectorAll(".btn-edit");

  const toolIDField = document.getElementById("toolID-hidden");
  const nameField = document.getElementById("name-field");
  const quantityField = document.getElementById("quantity-field");
  const typeField = document.getElementById("type-field");
  const descriptionField = document.getElementById("description-field");
  const imageField = document.getElementById("image-field");

  // Add tool
  addBtn.addEventListener("click", () => {
    formTitle.textContent = "Add New Tool";
    toolIDField.value = "";
    nameField.value = "";
    nameField.readOnly = false;

    quantityField.value = "";
    quantityField.readOnly = false;

    typeField.disabled = false;
    typeField.value = "motor";

    descriptionField.value = "";
    descriptionField.readOnly = false;

    imageField.required = true;

    document.querySelector("form").action = "../../../controller/admin/save_tool.php";
    modal.style.display = "flex";
  });

  // Edit tool
  editBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      formTitle.textContent = "Edit Tool";

      toolIDField.value = btn.dataset.id;
      nameField.value = btn.dataset.name;
      nameField.readOnly = true;

      quantityField.value = btn.dataset.quantity;

      typeField.value = btn.dataset.type;
      typeField.disabled = true;

      descriptionField.value = btn.dataset.description || '';
      descriptionField.readOnly = true;

      imageField.required = false;

      document.querySelector("form").action = "../../../controller/admin/update_tool_quantity.php";
      modal.style.display = "flex";
    });
  });

  // Close modal
  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  window.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
});
