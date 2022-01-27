<template>
  <div class="w-full mx-auto bg-white rounded-lg shadow-2xl mt-10">
    <vueper-slides
      :parallax="1"
      :parallax-fixed-content="false"
      fixed-height="20rem"
      :touchable="false"
    >
      <vueper-slide
        v-for="(image, index) in offerImages"
        :key="image.id"
        :image="image.image"
        @click="showLighbox(index, offerImages)"
      >
      </vueper-slide>
    </vueper-slides>

    <div class="p-6">
      <div>
        <span
          v-if="isPostDeleted()"
          class="
            inline-block
            px-2
            py-1
            leading-none
            bg-red-100
            text-red-900
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
        >
          Post Deleted
        </span>
        <span
          v-if="isSold()"
          class="
            inline-block
            px-2
            py-1
            leading-none
            bg-red-100
            text-red-900
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
        >
          Traded
        </span>
        <span
          v-if="isNegotiating()"
          class="
            inline-block
            px-2
            py-1
            leading-none
            bg-green-100
            text-green-900
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
        >
          Negotiating
        </span>
        <span
          v-if="isRejected()"
          class="
            inline-block
            px-2
            py-1
            leading-none
            bg-red-100
            text-red-900
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
        >
          Rejected
        </span>
        <span
          v-if="isPending && !isRejected() && !isNegotiating() && !isSold()"
          class="
            inline-block
            px-2
            mx-1
            py-1
            leading-none
            bg-green-100
            text-green-900
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
        >
          Pending
        </span>
        <span
          class="
            inline-block
            px-2
            mx-1
            py-1
            leading-none
            bg-green-100
            text-green-900
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
        >
          {{ getCategory(offer.category) }}
        </span>
        <span
          v-if="isExpired(offer.dateExpiree)"
          class="
            inline-block
            px-2
            mx-1
            py-1
            leading-none
            bg-red-100
            text-red-900
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
          >Expired</span
        >
        <span
          v-else-if="isExpiree(offer.dateExpiree)"
          class="
            inline-block
            px-2
            mx-1
            py-1
            leading-none
            bg-yellow-100
            text-yellow-900
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
          >Expiree</span
        >

        <p class="block mt-2 text-2xl font-semibold text-gray-800">
          {{ offer.prod_name }}
        </p>

        <p class="mt-2 text-sm text-gray-600">
          Quantity: {{ offer.prod_qty }} {{ getQuantityType(offer.qty_type) }}
        </p>

        <p class="mt-2 text-sm text-gray-600">
          Date Produced: {{ formatDate(offer.date_produced) }}
        </p>

        <p class="mt-2 text-sm text-gray-600">
          Date Expiree: {{ formatDate(offer.date_expiree) }}
        </p>

        <p class="mt-2 text-sm text-gray-600">Location: {{ user.city }}</p>
      </div>

      <div class="flex justify-between">
        <div>
          <div v-if="offerror" class="mt-4">
            <div class="flex items-center">
              <div class="flex items-center">
                <span class="mx-1 text-xs text-gray-600 dark:text-gray-300"
                  >You made an offer to &nbsp;
                </span>
                <div v-if="isPostDeleted()">
                  <span class="mx-1 text-xs text-gray-600 dark:text-gray-300"
                    >a deleted post &nbsp;
                  </span>
                </div>
                <div v-else class="flex justify-center">
                  <img
                    class="object-cover h-5 w-5 rounded-full"
                    :src="
                      getProfilePhoto(
                        this.offeree.profile_photo_path,
                        this.offeree.name
                      )
                    "
                    :alt="this.offeree.name"
                  />
                  <inertia-link
                    :href="route('userProfile', this.offeree.id)"
                    class="mx-1 text-xs text-gray-600 dark:text-gray-300"
                    >{{ this.offeree.name }}</inertia-link
                  >
                </div>
              </div>
              <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">
                ·
              </span>
              <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">{{
                getTimeAgo(offer.created_at)
              }}</span>
              <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">
                ·
              </span>
              <span v-if="isEdited()" class="mx-1 text-xs text-gray-600">
                Edited
              </span>
            </div>
          </div>
          <div v-else class="mt-4">
            <div class="flex items-center">
              <div class="flex items-center">
                <img
                  class="object-cover h-10 w-10 rounded-full"
                  :src="
                    getProfilePhoto(
                      this.user.profile_photo_path,
                      this.user.name
                    )
                  "
                  :alt="user.name"
                />
                <inertia-link
                  :href="route('userProfile', user.id)"
                  class="mx-2 font-semibold text-gray-700 dark:text-gray-200"
                  >{{ user.name }}</inertia-link
                >
              </div>
              <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">
                ·
              </span>
              <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">{{
                getTimeAgo(offer.created_at)
              }}</span>
              <span class="mx-1 text-xs text-gray-600 dark:text-gray-300">
                ·
              </span>
              <span v-if="isEdited()" class="mx-1 text-xs text-gray-600">
                Edited
              </span>
            </div>
          </div>
        </div>

        <div>
          <dropup align="right" width="48" popupPosition="right-0">
            <template #trigger>
              <button
                class="
                  relative
                  z-10
                  mt-5
                  block
                  p-2
                  transition-colors
                  duration-200
                  transform
                  bg-gray-300
                  rounded-md
                  hover:bg-green-500
                  focus:outline-none focus:bg-green-300
                "
              >
                <svg
                  class="w-6 h-6 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                  />
                </svg>
              </button>
            </template>

            <template #content>
              <div>
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Actions Available
                </div>

                <div v-if="this.offerror">
                  <jet-dropdown-link
                    :disabled="
                      isPostDeleted() ||
                      isSold() ||
                      isRejected() ||
                      isNegotiating()
                    "
                    as="button"
                    @click="showEditOffer(offer, offerImages)"
                  >
                    Edit Offer
                  </jet-dropdown-link>
                  <jet-dropdown-link
                    :disabled="
                      isPostDeleted() ||
                      isSold() ||
                      isRejected() ||
                      isNegotiating()
                    "
                    as="button"
                    @click="showCancelOffer(offer.id)"
                  >
                    Cancel Offer
                  </jet-dropdown-link>
                </div>

                <div v-else>
                  <jet-dropdown-link
                    :disabled="
                      isPostDeleted() ||
                      isSold() ||
                      isSold() ||
                      isRejected() ||
                      isNegotiating()
                    "
                    @click="acceptOffer(offer.id)"
                    as="button"
                  >
                    Accept Offer
                  </jet-dropdown-link>
                  <jet-dropdown-link
                    :disabled="
                      isPostDeleted() ||
                      isSold() ||
                      isSold() ||
                      isRejected() ||
                      isNegotiating()
                    "
                    @click="showRejectOfferModal(offer.id)"
                    as="button"
                  >
                    Reject Offer
                  </jet-dropdown-link>
                </div>
              </div>
            </template>
          </dropup>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import UserServices from "@services/User";
import PostServices from "@services/Post";
import ConversationServices from "@services/Conversation";
import OfferServices from "@services/Offer";
var dayjs = require("dayjs");
var relativeTime = require("dayjs/plugin/relativeTime");
var isBetween = require("dayjs/plugin/isBetween");
dayjs.extend(isBetween);
import { VueperSlides, VueperSlide } from "vueperslides";
import "vueperslides/dist/vueperslides.css";
import OfferImageServices from "@/Services/OfferImage";
import Dropup from "@/Components/Dropup";
import JetDropdownLink from "@/Jetstream/DropdownLink";

export default {
  props: [
    "offer",
    "offerror",
    "showCancelOffer",
    "showEditOffer",
    "showRejectOfferModal",
    "categories",
    "qtyTypes",
    "showLighbox",
  ],

  components: {
    VueperSlides,
    VueperSlide,
    Dropup,
    JetDropdownLink,
  },

  data() {
    return {
      user: {},

      offeree: {},

      offerImages: [],

      isPending: false,
    };
  },

  computed: {
    categoryOptions() {
      if (!this.categories) {
        return {};
      }

      return this.categories
        .filter((category) => category.id !== 1)
        .map((category) => {
          return {
            text: category.name,
            value: category.value,
          };
        });
    },

    qtyOptions() {
      if (!this.qtyTypes) {
        return {};
      }

      return this.qtyTypes.map((qtyType) => {
        return {
          text: qtyType.name,
          value: qtyType.value,
        };
      });
    },
  },

  methods: {
    isPostDeleted() {
      return this.offer.status === "post deleted" ? true : false;
    },

    isSold() {
      return this.offer.status === "sold" ? true : false;
    },

    isNegotiating() {
      return this.offer.status === "negotiating" ? true : false;
    },

    isEdited() {
      return dayjs(new Date(this.offer.updated_at)).isAfter(
        new Date(this.offer.created_at)
      )
        ? true
        : false;
    },

    isRejected() {
      return this.offer.status === "rejected" ? true : false;
    },

    async acceptOffer(offerID) {
      await OfferServices.acceptOffer(offerID);
      this.$inertia.get("/messages");
    },

    numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },

    formatDate(date) {
      return dayjs(new Date(date)).format("MMM DD, YYYY");
    },

    getTimeAgo(date) {
      dayjs.extend(relativeTime);
      return dayjs(new Date(date)).fromNow();
    },

    isExpiree(date) {
      if (
        dayjs(new Date()).isBetween(
          dayjs(new Date(date)).subtract(1, "week"),
          dayjs(new Date(date))
        )
      ) {
        return true;
      } else {
        return false;
      }
    },

    isExpired(date) {
      if (dayjs(new Date()).isAfter(new Date(date))) {
        return true;
      } else {
        return false;
      }
    },

    getQuantityType(qtyType) {
      if (qtyType && this.qtyTypes) {
        let results = this.qtyTypes.filter((qty) => qty.value === qtyType);

        if (results.length) return results[0].name;
        else return "Unknown";
      } else {
        return "Unknown";
      }
    },

    getCategory(category) {
      if (category && this.categories) {
        let results = this.categories.filter(
          (categ) => categ.value === category
        );

        if (results.length) return results[0].name;
        else return "Unknown";
      } else {
        return "Unknown";
      }
    },

    getProfilePhoto(path, name) {
      if (path) {
        return "/storage/" + path;
      } else {
        return `https://ui-avatars.com/api/?name=${name}&color=059669&background=ECFDF5`;
      }
    },

    async checkIfPostExists() {
      this.isPending = !(await ConversationServices.checkIfPostExists(
        this.offer.post_id
      ));
    },

    async getPostAuthor() {
      this.offeree = await PostServices.getPostAuthor(this.offer.post_id);
    },

    async getUser() {
      this.user = await UserServices.getUser(this.offer.user_id);
    },

    async getOfferImages() {
      const offerImages = await OfferImageServices.getOfferImages(
        this.offer.id
      );

      if (offerImages.length === 0) {
        this.offerImages = [
          {
            id: 1,
            image: "/img/noimage.svg",
          },
        ];
      } else {
        this.offerImages = offerImages.map((image) => {
          return {
            id: image.id,
            image: `/storage/${image.offer_image_path}`,
          };
        });
      }
    },
  },

  created() {
    this.checkIfPostExists();

    // If showing from offerror, display offeree info
    if (this.offerror) this.getPostAuthor();

    // Fetch user data of offerror
    this.getUser();

    // Get Offer Images
    this.getOfferImages();
  },
};
</script>