<template>
  <jet-dialog-modal :show="showing" @close="close">
    <template #title>
      <h2 class="mt-2 mb-2 text-xl font-bold">{{ post.title }}</h2>
    </template>

    <template #content>
      <vueper-slides
        :parallax="1"
        :parallax-fixed-content="false"
        fixed-height="20rem"
        :touchable="false"
      >
        <vueper-slide
          class="cursor-pointer"
          v-for="(image, index) in post.images"
          :key="image.id"
          :image="image.image"
          @click.stop="showLighbox(index, post.images)"
        >
        </vueper-slide>
      </vueper-slides>

      <div class="p-4">
        <span
          v-if="post.status === 'sold'"
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
          v-else
          class="
            inline-block
            px-2
            py-1
            leading-none
            rounded-full
            font-semibold
            uppercase
            tracking-wide
            text-xs
          "
          :class="
            post.status == 'negotiating'
              ? 'bg-yellow-100 text-yellow-900'
              : 'bg-green-100 text-green-900'
          "
        >
          {{ post.status }}
        </span>

        <inertia-link
          @click.stop=""
          :href="
            route('dashboard', {
              category: post.category,
              location: route().params.location,
              price: route().params.price,
              price2: route().params.price2,
              hideOwnPost: route().params.hideOwnPost,
            })
          "
        >
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
            {{ getCategory(post.category) }}
          </span>
        </inertia-link>

        <span
          v-if="isExpired(post.dateExpiree) && post.status !== 'sold'"
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
          v-else-if="isExpiree(post.dateExpiree) && post.status !== 'sold'"
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

        <h2 class="mt-2 mb-2 text-xl font-bold">{{ post.title }}</h2>

        <p class="text-sm">{{ post.description }}</p>

        <div class="mt-3 flex items-center">
          <span class="text-sm font-semibold">Preferred Item: </span>&nbsp;<span
            class="font-bold"
          >
            {{ post.preferredItem }}
          </span>
        </div>

        <div class="mt-3 flex items-center text-xs text-gray-700">
          <inertia-link
            @click.stop=""
            :href="route('userProfile', post.user.id)"
            class="flex items-center"
          >
            <span>
              <img
                class="h-6 w-6 mr-2 rounded-full object-cover"
                :src="getProfilePhoto()"
                :alt="$page.props.user.name"
              />
            </span>
            <span class="overflow-ellipsis overflow-hidden"
              >{{ post.user.id === authUser.id ? "You" : post.user.name }}
            </span>
            &nbsp; · &nbsp;
          </inertia-link>
          <span> {{ getTimeAgo(post.datePosted) }} </span>
          <span v-if="isEdited()">&nbsp; · &nbsp; edited</span>
        </div>
      </div>

      <div class="p-4 border-t border-b text-xs text-gray-700">
        <span class="flex items-center mb-1">
          <span class="far fa-address-card fa-fw text-gray-900 mr-2"
            >Product:
          </span>
          {{ post.prodName }}
        </span>

        <span class="flex items-center mb-1">
          <span class="far fa-address-card fa-fw text-gray-900 mr-2"
            >Quantity:
          </span>
          {{ post.qty }} {{ getQuantityType(post.qtyType) }}
        </span>

        <span class="flex items-center mb-1">
          <span class="far fa-address-card fa-fw text-gray-900 mr-2"
            >Date Produced:
          </span>
          {{ formatDate(post.dateProduced) }}
        </span>

        <span class="flex items-center mb-1">
          <span class="far fa-address-card fa-fw text-gray-900 mr-2"
            >Date Expiree:
          </span>
          {{ formatDate(post.dateExpiree) }}
        </span>

        <span class="flex items-center mb-1">
          <span class="far fa-address-card fa-fw text-gray-900 mr-2"
            >Location:
          </span>
          {{ post.user.city }}
        </span>
      </div>

      <div class="flex justify-between">
        <div class="p-4 flex items-center text-sm text-gray-600">
          <div class="flex flex-row mt-1">
            <svg
              v-for="(star, index) in post.feedback.length
                ? post.feedback[0].amount
                : 0"
              :key="index"
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              class="w-4 h-4 text-yellow-500"
              fill="currentColor"
              viewBox="0 0 1792 1792"
            >
              <path
                d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"
              ></path>
            </svg>

            <svg
              v-for="(star, index) in 5 -
              (post.feedback.length ? post.feedback[0].amount : 0)"
              :key="index"
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="20"
              class="w-4 h-4 text-gray-300"
              fill="currentColor"
              viewBox="0 0 1792 1792"
            >
              <path
                d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"
              ></path>
            </svg>
          </div>

          <span
            @click.stop="showRatingsModal(post.feedback)"
            class="ml-2 cursor-pointer"
            >{{ post.feedback.length ? post.feedback.length : 0 }} Ratings</span
          >
        </div>

        <div class="relative p-4">
          <dropup align="right" width="48" popupPosition="right-0">
            <template #trigger>
              <button
                class="
                  relative
                  z-10
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
              <div v-if="post.user.id === authUser.id">
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Post
                </div>
                <jet-dropdown-link
                  :disabled="this.post.status === 'sold'"
                  @click.stop="showEditModal(post)"
                  as="button"
                >
                  Edit Post
                </jet-dropdown-link>
                <jet-dropdown-link
                  @click.stop="showDeletePostModal(post.id, post.title)"
                  as="button"
                >
                  Delete Post
                </jet-dropdown-link>
                <jet-dropdown-link
                  @click.stop="showOffers(post.id, post.title)"
                  as="button"
                >
                  View Offers
                </jet-dropdown-link>
              </div>

              <div v-if="post.userID !== authUser.id">
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Actions Available
                </div>
                <jet-dropdown-link
                  :disabled="
                    this.post.offerExists || this.post.status == 'sold'
                  "
                  @click.stop="showMakeOfferModal(post.id)"
                  as="button"
                >
                  Make offer
                </jet-dropdown-link>
                <jet-dropdown-link
                  v-if="route().current('cart')"
                  @click.stop="removeFromCart(post.id)"
                  as="button"
                >
                  Remove from cart
                </jet-dropdown-link>
                <jet-dropdown-link
                  :disabled="this.post.status == 'sold'"
                  v-if="!route().current('cart')"
                  @click.stop="addToCart(post.id)"
                  as="button"
                >
                  Add To Cart
                </jet-dropdown-link>
                <jet-dropdown-link
                  @click.stop="showReportModal(post.id, post.userID)"
                  as="button"
                >
                  Report Post
                </jet-dropdown-link>
              </div>
            </template>
          </dropup>
        </div>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="close"> Close </jet-secondary-button>
    </template>
  </jet-dialog-modal>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import { VueperSlides, VueperSlide } from "vueperslides";
import "vueperslides/dist/vueperslides.css";
var dayjs = require("dayjs");
var relativeTime = require("dayjs/plugin/relativeTime");
var isBetween = require("dayjs/plugin/isBetween");
dayjs.extend(isBetween);
import Dropup from "@/Components/Dropup";
import JetDropdownLink from "@/Jetstream/DropdownLink";

export default {
  props: [
    "showing",
    "close",
    "post",
    "showLighbox",
    "categories",
    "qtyTypes",
    "feedback",
    "showRatings",
    "showOffersModal",
    "showEditPostModal",
    "showDelete",
    "makeOffer",
    "showAddToCart",
    "showReport",
  ],

  components: {
    JetDialogModal,
    JetSecondaryButton,
    VueperSlides,
    VueperSlide,
    Dropup,
    JetDropdownLink,
  },

  data() {
    return {
      authUser: null,
    };
  },

  methods: {
    showReportModal(id, userID) {
      this.showReport(id, userID);
      this.close();
    },

    addToCart(id) {
      this.showAddToCart(id);
      this.close();
    },

    showMakeOfferModal(id) {
      this.makeOffer(id);
      this.close();
    },

    showDeletePostModal(id, title) {
      this.showDelete(id, title);
      this.close();
    },

    showEditModal(post) {
      this.showEditPostModal(post);
      this.close();
    },

    showRatingsModal(feedback) {
      this.showRatings(feedback);
      this.close();
    },

    showOffers(id, title) {
      this.showOffersModal(id, title);
      this.close();
    },

    numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },

    formatDate(date) {
      return dayjs(new Date(date)).format("MMM DD, YYYY");
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

    getProfilePhoto() {
      if (this.post.user.profile_photo_path) {
        return "/storage/" + this.post.user.profile_photo_path;
      } else {
        return `https://ui-avatars.com/api/?name=${this.post.user.name}&color=059669&background=ECFDF5`;
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

    isEdited() {
      return dayjs(new Date(this.post.updated_at)).isAfter(
        new Date(this.post.created_at)
      )
        ? true
        : false;
    },

    getTimeAgo(date) {
      dayjs.extend(relativeTime);
      return dayjs(new Date(date)).fromNow();
    },

    isExpired(date) {
      if (dayjs(new Date()).isAfter(new Date(date))) {
        return true;
      } else {
        return false;
      }
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
  },

  created() {
    this.authUser = this.$page.props.authUser;
  },
};
</script>