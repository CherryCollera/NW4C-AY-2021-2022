<template>
  <app-layout>
    <!-- Categories -->
    <template #header>
      <categories :categories="categories" />
    </template>

    <!-- Sort Posts -->
    <div>
      <div class="container mx-auto">
        <div v-if="route().params.searchKeyword" class="flex flex-wrap mt-10">
          <p>Showing results for {{ route().params.searchKeyword }}</p>
        </div>
        <div class="flex flex-wrap">
          <sort-posts />
        </div>
      </div>
    </div>

    <!-- All Posts -->
    <div v-if="posts.data.length" class="p-6">
      <div class="container mx-auto">
        <div class="flex flex-wrap -mx-4">
          <post-card
            v-on:show-feedbacks="showFeedbacks"
            v-for="post in posts.data"
            :key="post.id"
            :id="post.id"
            :title="post.title"
            :description="post.description"
            :showMakeOfferModal="showMakeOfferModal"
            :created_at="post.created_at"
            :updated_at="post.updated_at"
            :price="post.est_price"
            :views="post.views"
            :preferredItem="post.preferred_prod"
            :status="post.status"
            :userID="post.user_id"
            :showOffersModal="showOffersModal"
            :showReportModal="showReportModal"
            :prodName="post.prod_name"
            :qty="post.prod_qty"
            :qtyType="post.qty_type"
            :dateProduced="post.date_produced"
            :showDeletePostModal="showDeletePostModal"
            :dateExpiree="post.date_expiree"
            :category="post.category"
            :datePosted="post.created_at"
            :showEditPostModal="showEditPostModal"
            :addToCart="addToCart"
            :showLighbox="showLighbox"
            :categories="categories"
            :qtyTypes="qtyTypes"
            :enlarge="showEnlargeModal"
          />
        </div>
      </div>
      <pagination :links="posts.links" />
    </div>

    <!-- No search results found -->
    <div v-else class="flex justify-center flex-col py-20">
      <div class="mx-auto">
        <lottie-animation
          path="animations/empty-dessert.json"
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
          v-if="route().params.searchKeyword"
          class="font-semibold text-xl text-gray-800 leading-tight"
        >
          No results found for {{ route().params.searchKeyword }}
        </h2>
        <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">
          No results found
        </h2>
      </div>
    </div>

    <!-- Floating Action Button -->
    <fab id="fab" @click="showAddPostModal">
      <svg
        viewBox="0 0 20 20"
        enable-background="new 0 0 20 20"
        class="w-6 h-6 inline-block"
      >
        <path
          fill="#FFFFFF"
          d="M16,10c0,0.553-0.048,1-0.601,1H11v4.399C11,15.951,10.553,16,10,16c-0.553,0-1-0.049-1-0.601V11H4.601
                                    C4.049,11,4,10.553,4,10c0-0.553,0.049-1,0.601-1H9V4.601C9,4.048,9.447,4,10,4c0.553,0,1,0.048,1,0.601V9h4.399
                                    C15.952,9,16,9.447,16,10z"
        />
      </svg>
    </fab>

    <!-- Enlarge Post Modal -->
    <enlarge-post-modal
      :showLighbox="showLighbox"
      :post="showingEnlargeModalData"
      :showing="showingEnlargeModal"
      :close="closeEnlargeModal"
      :categories="categories"
      :qtyTypes="qtyTypes"
      :showRatings="showFeedbacks"
      :showEditPostModal="showEditPostModal"
      :showOffersModal="showOffersModal"
      :showDelete="showDeletePostModal"
      :makeOffer="showMakeOfferModal"
      :showAddToCart="addToCart"
      :showReport="showReportModal"
    />

    <!-- Add Post Modal -->
    <add-post-modal
      :showingPostModal="showingPostModal"
      :closeAddPostModal="closeAddPostModal"
      :categories="categories"
      :qtyTypes="qtyTypes"
    />

    <!-- Edit Post Modal -->
    <edit-post-modal
      :postData="editPostData"
      :showingEditModal="showingEditModal"
      :closeEditPostModal="closeEditPostModal"
      :categories="categories"
      :qtyTypes="qtyTypes"
    />

    <!-- Delete Post Modal -->
    <delete-post-modal
      :postData="deletePostData"
      :showingDeletePostModal="showingDeleteModal"
      :closeDeletePostModal="closeDeletePostModal"
    />

    <!-- Make Offer Modal -->
    <make-offer-modal
      :showingMakeOfferModal="showingMakeOfferModal"
      :closeMakeOfferModal="closeMakeOfferModal"
      :postID="makeOfferData"
      :categories="categories"
      :qtyTypes="qtyTypes"
    />

    <!-- Report Modal -->
    <report-modal
      :showingReportModal="showingReportModal"
      :closeReportModal="closeReportModal"
      :reportData="showingReportData"
    />

    <!-- Show Offers Modal -->
    <show-offers-modal
      :showingOffersModal="showingOffersModal"
      :closeOffersModal="closeOffersModal"
      :post="showingOffersData"
      :showLighbox="showLighbox"
      :categories="categories"
      :qtyTypes="qtyTypes"
    />

    <!-- Show Feedbacks Modal -->
    <show-feedbacks-modal
      :show="showingFeedbacksModal"
      :close="closeFeedbacksModal"
      :feedbacks="feedbacks"
      @show-edit-feedback-modal="showEditFeedbackModal"
    />

    <!-- Edit Feedback Modal -->
    <edit-feedback-modal
      :showing="showingEditFeedbackModal"
      :close="closeEditFeedbackModal"
      :feedback="showingEditFeedbackModalData"
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
import Fab from "@/Components/Fab";
import PostCard from "@/Components/PostCard";
import Pagination from "@/Components/Pagination";
import AddPostModal from "@/Components/AddPostModal";
import Categories from "@/Components/Categories";
import EditPostModal from "@/Components/EditPostModal";
import DeletePostModal from "@/Components/DeletePostModal";
import MakeOfferModal from "@/Components/MakeOfferModal";
import ShowOffersModal from "@/Components/ShowOffersModal";
import SortPosts from "@/Components/SortPosts";
import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";
import ShowFeedbacksModal from "@/Components/ShowFeedbacksModal";
import ReportModal from "@/Components/ReportModal";
import VueEasyLighbox from "vue-easy-lightbox";
import EnlargePostModal from "@/Components/EnlargePostModal";
import EditFeedbackModal from "@/Components/EditFeedbackModal";
import OfferServices from "@services/Offer";
import MessageServices from "@services/Message";

export default {
  components: {
    AppLayout,
    Fab,
    PostCard,
    Pagination,
    AddPostModal,
    Categories,
    EditPostModal,
    DeletePostModal,
    MakeOfferModal,
    ShowOffersModal,
    SortPosts,
    LottieAnimation,
    ShowFeedbacksModal,
    ReportModal,
    VueEasyLighbox,
    EnlargePostModal,
    EditFeedbackModal,
  },

  props: ["posts", "categories", "qtyTypes"],

  data() {
    return {
      showingPostModal: false,
      showingEditModal: false,
      editPostData: null,
      showingDeleteModal: false,
      deletePostData: null,
      showingMakeOfferModal: false,
      makeOfferData: null,
      showingOffersModal: false,
      showingOffersData: null,
      showingFeedbacksModal: null,
      feedbacks: null,
      showingReportModal: false,
      showingReportData: null,
      showingLightbox: false,
      lightboxIndex: 0,
      lightboxImgs: "",
      showingEnlargeModal: false,
      showingEnlargeModalData: null,
      showingEditFeedbackModal: false,
      showingEditFeedbackModalData: null,
      receivedOffers: null,
      newMessages: null,
    };
  },

  created() {
    window.addEventListener("scroll", this.hideFabOnBottom);

    // Get Offers every 3 second
    this.polling = setInterval(() => {
      this.getReceivedOffers();
      this.getNewMessages();
    }, 3000);
  },

  unmounted() {
    window.removeEventListener("scroll", this.hideFabOnBottom);
    clearInterval(this.polling);
  },

  methods: {
    async getNewMessages() {
      // If New Messages is empty, fetch messages
      if (!this.newMessages) {
        this.newMessages = await MessageServices.getMessagesOfUser();
      }

      // Else if messages is not empty check for new messages
      // if there is new messages, send notification
      else if (this.newMessages) {
        const retrievedMessages = await MessageServices.getMessagesOfUser();

        if (
          retrievedMessages &&
          retrievedMessages.length > this.newMessages.length
        ) {
          const latestMessage = retrievedMessages[retrievedMessages.length - 1];

          this.notifyMe("New Message ", `${latestMessage.content}`);

          this.newMessages = retrievedMessages;
        }
      }
    },

    async getReceivedOffers() {
      // If Received Offers is empty, fetch received offers
      if (!this.receivedOffers) {
        this.receivedOffers = await OfferServices.getOfferToUser(
          this.$page.props.authUser.id
        );
      }

      // Else if Received Offers is not empty check for new offers
      // if there is new offers, send notification
      else if (this.receivedOffers) {
        const newOffers = await OfferServices.getOfferToUser(
          this.$page.props.authUser.id
        );

        if (newOffers && newOffers.length > this.receivedOffers.length) {
          const latestOffer = newOffers[newOffers.length - 1];

          this.notifyMe("New Offer ", `Product Name: ${latestOffer.prod_name}`);

          this.receivedOffers = newOffers;
        }
      }
    },

    notifyMe(title, desc) {
      // check if the browser supports notifications
      if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
      }

      // check whether notification permissions have already been granted
      else if (Notification.permission === "granted") {
        var notification = new Notification(title, {
          body: desc,
          icon: "/img/logo1.webp",
        });
      }

      // Otherwise, ask the user for permission
      else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
          if (permission === "granted") {
            var notification = new Notification(title, {
              body: desc,
              icon: "/img/logo1.webp",
            });
          }
        });
      }
    },

    showEditFeedbackModal(feedback) {
      this.closeFeedbacksModal();
      this.showingEditFeedbackModalData = feedback;
      this.showingEditFeedbackModal = true;
    },

    closeEditFeedbackModal() {
      this.showingEditFeedbackModal = false;
    },

    showEnlargeModal(post) {
      this.showingEnlargeModalData = post;
      this.showingEnlargeModal = true;
    },

    closeEnlargeModal() {
      this.showingEnlargeModal = false;
    },

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

    closeReportModal() {
      this.showingReportModal = false;
    },

    showReportModal(postID, userID) {
      this.showingReportData = { postID: postID, userID: userID };
      this.showingReportModal = true;
    },

    showFeedbacks(feedbacks) {
      this.feedbacks = feedbacks;
      this.showingFeedbacksModal = true;
    },

    closeFeedbacksModal() {
      this.showingFeedbacksModal = false;
    },

    showOffersModal(postID, postTitle) {
      this.showingOffersData = { id: postID, title: postTitle };
      this.showingOffersModal = true;
    },

    closeOffersModal() {
      this.showingOffersModal = false;
    },

    addToCart(postID) {
      const form = this.$inertia.form({
        post_id: postID,
      });

      form.post(route("cart.store"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => this.$refs.post_title.focus(),
        onFinish: () => form.reset(),
      });
    },

    showAddPostModal() {
      this.showingPostModal = true;
    },

    closeAddPostModal() {
      this.showingPostModal = false;
    },

    showEditPostModal(postData) {
      this.editPostData = postData;
      this.showingEditModal = true;
    },

    closeEditPostModal() {
      this.showingEditModal = false;
    },

    showDeletePostModal(id, title) {
      this.deletePostData = { id: id, title: title };
      this.showingDeleteModal = true;
    },

    closeDeletePostModal() {
      this.showingDeleteModal = false;
    },

    showMakeOfferModal(postID) {
      this.makeOfferData = postID;
      this.showingMakeOfferModal = true;
    },

    closeMakeOfferModal() {
      this.showingMakeOfferModal = false;
    },

    hideFabOnBottom(event) {
      if (
        window.innerHeight + window.scrollY >
        document.body.clientHeight - 20
      ) {
        if (window.scrollY === 0) {
          document.getElementById("fab").style.display = "unset";
        } else {
          document.getElementById("fab").style.display = "none";
        }
      } else {
        document.getElementById("fab").style.display = "unset";
      }
    },
  },
};
</script>
