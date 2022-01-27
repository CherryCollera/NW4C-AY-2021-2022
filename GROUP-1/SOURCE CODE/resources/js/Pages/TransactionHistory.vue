<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Transaction History
      </h2>
    </template>

    <div class="container pt-5 px-5 min-w-full flex justify-center">
      <!-- Success Transaction -->
      <div class="py-3 px-1 flex">
        <inertia-link
          :href="
            route('transactionHistory', {
              category: 'success',
            })
          "
        >
          <span
            class="py-1 px-3 rounded-full text-xs bg-green-500 text-white"
            :class="isActive('success')"
          >
            Success
          </span>
        </inertia-link>
      </div>

      <!-- Negotiating Transaction -->
      <div class="flex py-3 px-1">
        <inertia-link
          :href="
            route('transactionHistory', {
              category: 'negotiating',
            })
          "
        >
          <span
            class="py-1 px-3 rounded-full text-xs bg-yellow-500 text-white"
            :class="isActive('negotiating')"
          >
            Negotiating
          </span>
        </inertia-link>
      </div>

      <!-- Rejected Transaction -->
      <div class="flex py-3 px-1">
        <inertia-link
          :href="
            route('transactionHistory', {
              category: 'rejected',
            })
          "
        >
          <span
            class="py-1 px-3 rounded-full text-xs bg-red-500 text-white"
            :class="isActive('rejected')"
          >
            Rejected
          </span>
        </inertia-link>
      </div>

      <!-- Pending Transaction -->
      <div class="flex py-3 px-1">
        <inertia-link
          :href="
            route('transactionHistory', {
              category: 'pending',
            })
          "
        >
          <span
            class="py-1 px-3 rounded-full text-xs bg-gray-500 text-white"
            :class="isActive('pending')"
          >
            Pending
          </span>
        </inertia-link>
      </div>

      <!-- Deleted Transaction -->
      <div class="flex py-3 px-1">
        <inertia-link
          :href="
            route('transactionHistory', {
              category: 'deleted',
            })
          "
        >
          <span
            class="py-1 px-3 rounded-full text-xs bg-gray-400 text-white"
            :class="isActive('deleted')"
          >
            Deleted
          </span>
        </inertia-link>
      </div>
    </div>

    <div
      v-if="hasParams()"
      class="container min-w-full flex justify-center text-gray-400 text-xs"
    >
      <inertia-link :href="route('transactionHistory')"> Reset </inertia-link>
    </div>

    <div class="container p-5 min-w-full">
      <div
        v-if="offers.data.length"
        class="flex flex-col md:grid grid-cols-12 text-gray-50"
      >
        <history-card
          v-for="offer in offers.data"
          :key="offer.id"
          :ogOffer="offer"
          :postID="offer.post_id"
          :convoID="offer.convo_id"
          :date="getDate(offer.created_at)"
          :status="offer.status"
          :categories="categories"
          :qtyTypes="qtyTypes"
        />
      </div>

      <div v-else class="flex flex-col text-gray-50">
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
            No transactions found yet
          </h2>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import HistoryCard from "@/Components/HistoryCard";
import DateHelpers from "@utils/date-helpers";
import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";
import { registerRuntimeCompiler } from "@vue/runtime-core";

export default {
  props: ["offers", "categories", "qtyTypes"],

  components: {
    AppLayout,
    HistoryCard,
    LottieAnimation,
  },

  methods: {
    hasParams() {
      if (route().params.category) return true;
      else return false;
    },

    isActive(url) {
      // null check
      if (!url) return;

      let params = route().params.category;

      if (url == "success" && params == "success") {
        return "border-4 border-green-900";
      } else if (url == "negotiating" && params == "negotiating") {
        return "border-4 border-yellow-900";
      } else if (url == "rejected" && params == "rejected") {
        return "border-4 border-yellow-900";
      } else if (url == "pending" && params == "pending") {
        return "border-4 border-gray-900";
      } else if (url == "deleted" && params == "deleted") {
        return "border-4 border-gray-800";
      }
    },

    getDate(date) {
      return DateHelpers.formatDate(date);
    },

    getIsComplete(finishedAt) {
      return finishedAt ? true : false;
    },
  },
};
</script>