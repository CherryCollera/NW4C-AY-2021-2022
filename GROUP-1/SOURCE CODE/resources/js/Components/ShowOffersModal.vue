<template>
  <jet-dialog-modal :show="showingOffersModal" @close="closeOffersModal">
    <template #title>
      {{ postOffers.length ? postOffers.length : "No" }} Offers Received from
      post '{{ post.title }}'
    </template>

    <template #content>
      <!-- Show all offers received -->
      <div v-if="postOffers.length" class="p-6">
        <p>Showing all the offers received from other users for this post</p>

        <div class="container mx-auto">
          <div class="flex flex-wrap -mx-4">
            <offer-card
              v-for="postOffer in postOffers"
              :key="postOffer.id"
              :offer="postOffer"
              :showRejectOfferModal="showRejectOfferModal"
              :showLighbox="showLighbox"
              :categories="categories"
              :qtyTypes="qtyTypes"
            />
          </div>
        </div>
      </div>

      <!-- Show if no offers received -->
      <div v-else class="flex justify-center flex-col mt-20">
        <div class="mx-auto">
          <lottie-animation
            path="animations/empty-box-flies.json"
            :loop="true"
            :autoPlay="true"
            :speed="1"
            background="transparent"
            :width="300"
            :height="300"
          />
        </div>

        <div class="mx-auto">
          <h2
            class="
              text-center
              font-semibold
              text-xl text-gray-800
              leading-tight
            "
          >
            No offers received yet
          </h2>
        </div>
      </div>
    </template>

    <template #footer>
      <jet-button @click="closeOffersModal" class="ml-2"> Close </jet-button>
    </template>
  </jet-dialog-modal>

  <!-- Reject Offer Modal -->
  <reject-offer-modal
    :show="showingRejectOfferModal"
    :close="closeRejectOfferModal"
    :offerID="rejectOfferData"
  />
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal";
import JetButton from "@/Jetstream/Button";
import OfferServices from "@/Services/Offer";
import OfferCard from "@/Components/OfferCard";
import RejectOfferModal from "@/Components/RejectOfferModal";
import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";

export default {
  components: {
    JetDialogModal,
    JetButton,
    OfferCard,
    RejectOfferModal,
    LottieAnimation,
  },

  props: [
    "showingOffersModal",
    "closeOffersModal",
    "post",
    "showLighbox",
    "categories",
    "qtyTypes",
  ],

  data() {
    return {
      showingRejectOfferModal: false,

      rejectOfferData: null,

      postOffers: [],

      categoryOptions: [
        { text: "Crops", value: "categ-1" },
        { text: "Livestocks", value: "categ-2" },
        { text: "Dairy", value: "categ-3" },
        { text: "Fish Farming", value: "categ-4" },
        { text: "Machineries", value: "categ-5" },
        { text: "Others", value: "categ-6" },
      ],

      qtyOptions: [
        { text: "Kilogram", value: "categ-1" },
        { text: "Liter", value: "categ-2" },
        { text: "Box", value: "categ-3" },
        { text: "Sack", value: "categ-4" },
        { text: "Truck", value: "categ-5" },
        { text: "Piece", value: "categ-6" },
      ],
    };
  },

  methods: {
    showRejectOfferModal(offerID) {
      this.rejectOfferData = offerID;
      this.showingRejectOfferModal = true;
    },

    closeRejectOfferModal() {
      this.showingRejectOfferModal = false;
      this.closeOffersModal();
    },

    async getPostOffers() {
      if (this.post && this.post.id) {
        this.postOffers = await OfferServices.getPostOffers(this.post.id);
      }
    },
  },

  beforeUpdate() {
    this.getPostOffers();
  },
};
</script>