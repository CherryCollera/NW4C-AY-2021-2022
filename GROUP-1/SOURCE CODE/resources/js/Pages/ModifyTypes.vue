<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Modify Types
      </h2>
    </template>

    <!-- Categories Table -->
    <categories-table
      :categories="categories"
      :showAddCategoryModal="showAddCategoryModal"
      :showEditCategoryModal="showEditCategoryModal"
      :showDeleteCategoryModal="showDeleteCategoryModal"
    />

    <!-- Qty Types Table -->
    <qty-types-table
      :qtyTypes="qtyTypes"
      :showAddQtyModal="showAddQtyModal"
      :showEditQtyModal="showEditQtyModal"
      :showDeleteQtyModal="showDeleteQtyModal"
    />

    <!-- Add Qty Modal -->
    <add-qty-modal
      :showing="showingAddQtyModal"
      :closeModal="closeAddQtyModal"
      :qtyTypes="qtyTypes"
    />

    <!-- Edit Qty Modal -->
    <edit-qty-modal
      :showingModal="showingEditQtyModal"
      :closeModal="closeEditQtyModal"
      :data="editQtyModalData"
    />

    <!-- Delete Qty Modal -->
    <delete-qty-modal
      :data="deleteQtyData"
      :showing="showingDeleteQtyModal"
      :closeModal="closeDeleteQtyModal"
    />

    <!-- Edit Category Modal -->
    <edit-category-modal
      :showingModal="showingEditCategoryModal"
      :closeModal="closeEditCategoryModal"
      :data="editCategoryModalData"
    />

    <!-- Delete Category Modal -->
    <delete-category-modal
      :data="deleteCategoryModalData"
      :showing="showingDeleteCategoryModal"
      :closeModal="closeDeleteCategoryModal"
    />

    <!-- Add Category Modal -->
    <add-category-modal
      :showing="showingAddCategoryModal"
      :closeModal="closeAddCategoryModal"
      :categories="categories"
    />
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import EditCategoryModal from "@/Components/EditCategoryModal";
import DeleteCategoryModal from "@/Components/DeleteCategoryModal";
import AddCategoryModal from "@/Components/AddCategoryModal";
import CategoriesTable from "@/Components/CategoriesTable";
import QtyTypesTable from "@/Components/QtyTypesTable";
import EditQtyModal from "@/Components/EditQtyModal";
import AddQtyModal from "@/Components/AddQtyModal";
import DeleteQtyModal from "@/Components/DeleteQtyModal";

export default {
  props: ["categories", "qtyTypes"],

  components: {
    AppLayout,
    EditCategoryModal,
    DeleteCategoryModal,
    AddCategoryModal,
    CategoriesTable,
    QtyTypesTable,
    EditQtyModal,
    AddQtyModal,
    DeleteQtyModal,
  },

  data() {
    return {
      showingEditCategoryModal: false,
      editCategoryModalData: null,
      showingDeleteCategoryModal: false,
      deleteCategoryModalData: null,
      showingAddCategoryModal: false,
      showingEditQtyModal: false,
      editQtyModalData: null,
      showingAddQtyModal: false,
      showingDeleteQtyModal: false,
      deleteQtyData: null,
    };
  },

  methods: {
    closeDeleteQtyModal() {
      this.showingDeleteQtyModal = false;
    },

    showDeleteQtyModal(data) {
      this.deleteQtyData = data;
      this.showingDeleteQtyModal = true;
    },

    closeAddQtyModal() {
      this.showingAddQtyModal = false;
    },

    showAddQtyModal() {
      this.showingAddQtyModal = true;
    },

    showEditQtyModal(data) {
      this.editQtyModalData = data;
      this.showingEditQtyModal = true;
    },

    closeEditQtyModal() {
      this.showingEditQtyModal = false;
    },

    showAddCategoryModal() {
      this.showingAddCategoryModal = true;
    },

    closeAddCategoryModal() {
      this.showingAddCategoryModal = false;
    },

    closeDeleteCategoryModal() {
      this.showingDeleteCategoryModal = false;
    },

    showDeleteCategoryModal(data) {
      this.deleteCategoryModalData = data;
      this.showingDeleteCategoryModal = true;
    },

    closeEditCategoryModal() {
      this.showingEditCategoryModal = false;
    },

    showEditCategoryModal(data) {
      this.editCategoryModalData = data;
      this.showingEditCategoryModal = true;
    },
  },
};
</script>
