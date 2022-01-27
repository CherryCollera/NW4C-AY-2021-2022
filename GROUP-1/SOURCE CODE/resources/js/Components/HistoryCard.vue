<template>
  <div class="flex md:contents">
    <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
      <div class="h-full w-6 flex items-center justify-center">
        <div class="h-full w-1 pointer-events-none" :class="bgColor"></div>
      </div>
      <div
        class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full shadow text-center"
        :class="bgColor"
      >
        <i class="fas fa-check-circle text-white"></i>
      </div>
    </div>

    <div
      class="
        col-start-4 col-end-12
        p-4
        rounded-xl
        my-4
        mr-auto
        shadow-md
        w-full
      "
      :class="bgColor"
    >
      <h3 class="font-semibold text-xl mb-3">{{ header }}</h3>
      <h3 class="font-semibold text-md mb-1">Post Title: {{ title }}</h3>
      <h3 class="font-semibold text-md mb-1">Posted Product: {{ product }}</h3>
      <h3 class="font-semibold text-md mb-1">{{ tradedItem }}</h3>
      <h3 class="font-semibold text-md mb-3">
        <inertia-link :href="route('userProfile', otherUserID)"
          >{{ displayOtherNameUser }}
        </inertia-link>
      </h3>
      <p class="leading-tight text-justify w-full">{{ date }}</p>
    </div>
  </div>
</template>

<script>
import PostServices from "@services/Post";
import ConvoServices from "@services/Conversation";
import UserServices from "@services/User";
import OfferServices from "@services/Offer";

export default {
  props: [
    "postID",
    "date",
    "color",
    "convoID",
    "status",
    "ogOffer",
    "categories",
    "qtyTypes",
  ],

  computed: {
    bgColor() {
      switch (this.status) {
        case "sold":
          return "bg-green-500";
        case "negotiating":
          return "bg-yellow-500";
        case "post deleted":
          return "bg-gray-400";
        case "rejected":
          return "bg-red-500";

        default:
          return "bg-gray-500";
      }
    },

    displayOtherNameUser() {
      if (!this.status || this.status === "rejected")
        return `Made offer to: ${this.otherUserName}`;

      if (this.status === "negotiating")
        return `Negotiating with: ${this.otherUserName}`;

      if (this.status != "negotiating")
        return `Traded with: ${this.otherUserName}`;
    },

    header() {
      switch (this.status) {
        case "sold":
          return "Barter Complete";
        case "negotiating":
          return this.$page.props.authUser.id === this.ogOffer.user_id
            ? "Negotiating [Made Offer]"
            : "Negotiating [Received Offer]";
        case "post deleted":
          return "Post Deleted";
        case "rejected":
          return this.$page.props.authUser.id === this.ogOffer.user_id
            ? "Rejected [Made Offer]"
            : "Rejected [Received Offer]";
        default:
          return this.$page.props.authUser.id === this.ogOffer.user_id
            ? "Pending [Made Offer]"
            : "Pending [Received Offer]";
      }
    },

    title() {
      if (this.post && Object.keys(this.post).length > 0)
        return this.post.title;

      return "Deleted Post";
    },

    product() {
      if (this.post && Object.keys(this.post).length)
        return `${this.post.prod_name}, ${this.post.prod_qty} ${this.getQty(
          this.post.qty_type
        )}`;

      return "Deleted Post";
    },

    tradedItem() {
      if (this.status === "rejected" || !this.status)
        return `Offer: ${this.ogOffer.prod_name}, ${
          this.ogOffer.prod_qty
        } ${this.getQty(this.ogOffer.qty_type)}`;

      if (this.status === "negotiating" || !this.status)
        return `Offer: ${this.ogOffer.prod_name}, ${
          this.ogOffer.prod_qty
        } ${this.getQty(this.ogOffer.qty_type)}`;

      if (this.offer && Object.keys(this.offer).length)
        return `Traded for: ${this.offer.prod_name}, ${
          this.offer.prod_qty
        } ${this.getQty(this.offer.qty_type)}`;

      return "Deleted Offer";
    },

    otherUserID() {
      if (this.otherUser) return this.otherUser.id;

      return "";
    },

    otherUserName() {
      if (this.otherUser) return this.otherUser.name;

      return "";
    },
  },

  data() {
    return {
      post: null,
      convo: null,
      otherUser: null,
      authUser: null,
      offer: null,
    };
  },

  methods: {
    async getUserOffer(postID, otherUserID) {
      this.offer = await OfferServices.getOfferOfAuthUser(postID, otherUserID);
    },

    getQty(qtyType) {
      if (qtyType && this.qtyTypes) {
        let results = this.qtyTypes.filter((qty) => qty.value === qtyType);

        if (results.length) return results[0].name;
        else return "Unknown";
      } else {
        return "Unknown";
      }
    },

    async getPost(postID) {
      this.post = await PostServices.getPost(postID);
    },

    async getConvo(postID) {
      if (
        this.status === "negotiating" ||
        !this.status ||
        this.status === "rejected"
      )
        return false;

      this.convo = await ConvoServices.getConvoFromPost(postID);
      this.getOtherUser();
    },

    async getOtherUser() {
      if (!this.status && this.ogOffer.user_id === this.authUser.id) {
        this.otherUser = await PostServices.getPostAuthor(this.postID);
      } else if (!this.status && this.ogOffer.user_id != this.authUser.id) {
        this.otherUser = await UserServices.getUser(this.ogOffer.user_id);
      }

      if (
        this.status === "rejected" &&
        this.ogOffer.user_id === this.authUser.id
      ) {
        this.otherUser = await PostServices.getPostAuthor(this.postID);
      } else if (
        this.status === "rejected" &&
        this.ogOffer.user_id != this.authUser.id
      ) {
        this.otherUser = await UserServices.getUser(this.ogOffer.user_id);
      }

      if (
        this.status === "negotiating" &&
        this.ogOffer.user_id === this.authUser.id
      ) {
        this.otherUser = await PostServices.getPostAuthor(this.postID);
      } else if (
        this.status === "negotiating" &&
        this.ogOffer.user_id != this.authUser.id
      ) {
        this.otherUser = await UserServices.getUser(this.ogOffer.user_id);
      }

      if (!this.convo) return;

      if (this.convo.receiver_user_id === this.authUser.id) {
        this.otherUser = await UserServices.getUser(this.convo.sender_user_id);
      } else {
        this.otherUser = await UserServices.getUser(
          this.convo.receiver_user_id
        );
      }

      if (this.otherUser) {
        this.getUserOffer(this.postID, this.otherUser.id);
      }
    },
  },

  mounted() {
    this.authUser = this.$page.props.authUser;
    this.getPost(this.postID);
    this.getConvo(this.postID);
    this.getOtherUser();
  },
};
</script>