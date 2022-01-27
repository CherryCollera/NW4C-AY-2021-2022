<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        View Reports
      </h2>
    </template>

    <!-- Reports Table -->
    <reports-table
      v-on:show-review-report="showReviewReportModal"
      :reports="reports"
    />

    <!-- Review Report Modal -->
    <review-report-modal
      :showing="showingReviewReportModal"
      :close="closeReviewReportModal"
      :data="reviewReportModalData"
      v-on:show-lightbox="showReportImageLightbox"
    />

    <!-- Report Images Lightbox -->
    <vue-easy-lightbox
      moveDisabled
      scrollDisabled
      :visible="showingLightbox"
      :imgs="lightboxImgs"
      :index="lightboxIndex"
      @hide="hideLightbox"
    >
    </vue-easy-lightbox>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ReportsTable from "@/Components/ReportsTable";
import ReviewReportModal from "@/Components/ReviewReportModal";

export default {
  props: ["reports"],

  components: { AppLayout, ReportsTable, ReviewReportModal },

  data() {
    return {
      showingReviewReportModal: false,
      reviewReportModalData: null,
      showingLightbox: false,
      lightboxIndex: 0,
      lightboxImgs: "",
    };
  },

  methods: {
    closeReviewReportModal() {
      this.showingReviewReportModal = false;
    },

    showReviewReportModal(data) {
      this.showingReviewReportModal = true;
      this.reviewReportModalData = data;
    },

    showReportImageLightbox(data) {
      this.lightboxImgs = data.images.map((img) => ({
        title: "",
        src: img.image,
      }));

      this.lightboxIndex = data.index;
      this.showingLightbox = true;
    },

    hideLightbox() {
      this.showingLightbox = false;
    },
  },
};
</script>