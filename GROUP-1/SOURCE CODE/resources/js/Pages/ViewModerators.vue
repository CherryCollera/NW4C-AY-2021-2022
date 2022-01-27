<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        View Moderators
      </h2>
    </template>

    <!-- Moderators Table -->
    <moderators-table
      :moderators="moderators"
      :showAddModerator="showAddModerator"
    />

    <!-- Add Moderator Modal -->
    <add-moderator-modal
      :showing="showingAddModerator"
      :closeModal="closeAddModeratorModal"
    />

    <!-- Promotion History -->
    <promotion-history-table :promotions="promotions" />
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ModeratorsTable from "@/Components/ModeratorsTable";
import AddModeratorModal from "@/Components/AddModeratorModal";
import PromotionHistoryTable from "@/Components/PromotionHistoryTable";

export default {
  props: ["moderators", "promotions"],

  components: {
    AppLayout,
    ModeratorsTable,
    AddModeratorModal,
    PromotionHistoryTable,
  },

  data() {
    return {
      showingAddModerator: null,
    };
  },

  methods: {
    showAddModerator() {
      this.showingAddModerator = true;
    },

    closeAddModeratorModal() {
      this.showingAddModerator = false;
    },
  },
};
</script>
