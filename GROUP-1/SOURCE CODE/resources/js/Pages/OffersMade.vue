<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Offer's Made
      </h2>
    </template>

    <!-- All Offers made -->
    <div v-if="offersMade.data.length" class="p-6">
      <div class="container mx-auto">
        <div class="flex flex-wrap -mx-4">
          <offer-card
            v-for="postOffer in offersMade.data"
            :key="postOffer.id"
            :offer="postOffer"
            :offerror="true"
            class="lg:w-3/5"
            :showCancelOffer="showCancelOffer"
            :showEditOffer="showEditOffer"
            :categories="categories"
            :qtyTypes="qtyTypes"
            :showLighbox="showLighbox"
          />
        </div>
      </div>
      <pagination :links="offersMade.links" />
    </div>

    <!-- Show if no offers made yet -->
    <div v-else class="flex justify-center flex-col mt-10 pb-36">
      <div class="mx-auto">
        <lottie-animation
          path="animations/empty-box-2.json"
          :loop="true"
          :autoPlay="true"
          :speed="1"
          background="transparent"
          :width="300"
          :height="300"
        />
      </div>

      <div class="mx-auto">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          No offers made yet
        </h2>
      </div>
    </div>

    <!-- Cancel Offer Modal -->
    <confirmation-modal :show="showingCancelOffer">
      <template #title>
        <h2>Cancel Offer</h2>
      </template>

      <template #content>
        <p>
          Are you sure you want to cancel your offer? The offeree won't be able
          to see it anymore.
        </p>
      </template>

      <template #footer>
        <secondary-button @click="closeCancelOffer"> Cancel </secondary-button>

        <danger-button
          class="ml-2"
          @click="cancelOffer()"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Confirm
        </danger-button>
      </template>
    </confirmation-modal>

    <!-- Edit Offer Modal -->
    <edit-offer-modal
      :show="showingEditOffer"
      :close="closeEditOffer"
      :editOfferData="editOfferData"
      :categories="categories"
      :qtyTypes="qtyTypes"
    />

    <!-- Post Images Lightbox -->
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
import AppLayout from "@/Layouts/AppLayout";
import Pagination from "@/Components/Pagination";
import OfferCard from "@/Components/OfferCard";
import ConfirmationModal from "@/Jetstream/ConfirmationModal";
import SecondaryButton from "@/Jetstream/SecondaryButton";
import DangerButton from "@/Jetstream/DangerButton";
import EditOfferModal from "@/Components/EditOfferModal";
import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";
import VueEasyLighbox from "vue-easy-lightbox";

export default {
  props: ["offersMade", "categories", "qtyTypes"],

  components: {
    AppLayout,
    Pagination,
    OfferCard,
    ConfirmationModal,
    SecondaryButton,
    DangerButton,
    EditOfferModal,
    LottieAnimation,
    VueEasyLighbox,
  },

  data() {
    return {
      showingCancelOffer: false,
      showingEditOffer: false,
      editOfferData: null,
      showingLightbox: false,
      lightboxIndex: 0,
      lightboxImgs: "",

      form: this.$inertia.form({
        offerID: null,
      }),
    };
  },

  methods: {
    showLighbox(index, imgs) {
      this.lightboxImgs = imgs.map((img) => ({
        title: "",
        src: img.image,
      }));

      this.lightboxIndex = index;
      this.showingLightbox = true;
    },

    hideLightbox() {
      this.showingLightbox = false;
    },

    showEditOffer(offer, offerImages) {
      this.editOfferData = {
        offer: offer,
        offerImages: offerImages,
      };

      this.showingEditOffer = true;
    },

    closeEditOffer() {
      this.showingEditOffer = false;
    },

    showCancelOffer(offerID) {
      this.form.offerID = offerID;
      this.showingCancelOffer = true;
    },

    closeCancelOffer() {
      this.showingCancelOffer = false;
    },

    cancelOffer() {
      this.form.delete(
        route("offer.destroy", {
          offer: this.form.offerID,
        }),
        {
          preserveScroll: true,
          onSuccess: () => this.closeCancelOffer(),
          onError: () => console.log("Cant cancel offer"),
          onFinish: () => this.form.reset(),
        }
      );
    },
  },

  mounted() {},
};
</script>