<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Trader's Cart
      </h2>
    </template>

    <!-- All Posts Added To Cart -->
    <div v-if="posts.data.length" class="p-6">
      <div class="container mx-auto">
        <div class="flex flex-wrap -mx-4">
          <post-card
            v-for="post in posts.data"
            :key="post.id"
            :id="post.id"
            :title="post.title"
            :description="post.description"
            :showMakeOfferModal="showMakeOfferModal"
            :price="post.est_price"
            :views="post.views"
            :preferredItem="post.preferred_prod"
            :status="post.status"
            :userID="post.user_id"
            :created_at="post.created_at"
            :prodName="post.prod_name"
            :qty="post.prod_qty"
            :qtyType="post.qty_type"
            :dateProduced="post.date_produced"
            :updated_at="post.updated_at"
            :dateExpiree="post.date_expiree"
            :category="post.category"
            :datePosted="post.created_at"
            :removeFromCart="showRemoveCartModal"
            :categories="categories"
            :qtyTypes="qtyTypes"
          />
        </div>
      </div>
      <pagination :links="posts.links" />
    </div>

    <div v-else class="flex justify-center flex-col mt-20">
      <div class="mx-auto">
        <lottie-animation
          path="animations/empty-cart.json"
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
          Cart is Empty
        </h2>
      </div>
    </div>

    <!-- Make Offer Modal -->
    <make-offer-modal
      :showingMakeOfferModal="showingMakeOfferModal"
      :closeMakeOfferModal="closeMakeOfferModal"
      :postID="makeOfferData"
      :categories="categories"
      :qtyTypes="qtyTypes"
    />

    <!-- Confirm Remove to Cart Modal -->
    <remove-cart-modal
      :show="showingRemoveCartModal"
      :close="closeRemoveCartModal"
      :postID="removeCartData"
    />
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import PostCard from "@/Components/PostCard";
import Pagination from "@/Components/Pagination";
import MakeOfferModal from "@/Components/MakeOfferModal";
import RemoveCartModal from "@/Components/RemoveCartModal";
import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";

export default {
  props: ["posts", "categories", "qtyTypes"],

  components: {
    AppLayout,
    PostCard,
    Pagination,
    MakeOfferModal,
    RemoveCartModal,
    LottieAnimation,
  },

  data() {
    return {
      showingMakeOfferModal: false,
      makeOfferData: null,
      showingRemoveCartModal: false,
      removeCartData: null,
    };
  },

  methods: {
    showRemoveCartModal(postID) {
      this.removeCartData = postID;
      this.showingRemoveCartModal = true;
    },

    closeRemoveCartModal() {
      this.showingRemoveCartModal = false;
    },

    showMakeOfferModal(postID) {
      this.makeOfferData = postID;
      this.showingMakeOfferModal = true;
    },

    closeMakeOfferModal() {
      this.showingMakeOfferModal = false;
    },
  },
};
</script>