<template>
  <jet-dialog-modal :show="show" @close="close">
    <template #title>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Feedbacks
      </h2>
      <h2
        v-if="feedbacks.length > 1"
        class="
          flex
          justify-center
          font-semibold
          text-xl text-gray-800
          leading-tight
        "
      >
        Average Rating:&nbsp;
        <span v-if="averageRating()" class="flex flex-row mt-1">
          <svg
            v-for="(star, index) in Math.floor(averageRating())"
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
            v-for="(star, index) in Math.round(5 - averageRating())"
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
        </span>
      </h2>
    </template>

    <template #content>
      <div v-if="feedbacks.length">
        <feedback-card
          v-for="feedback in feedbacks"
          :key="feedback.id"
          :feedback="feedback"
          @show-edit-feedback-modal="
            this.$emit('show-edit-feedback-modal', feedback)
          "
        />
      </div>

      <!-- Show if no feedbacks found -->
      <div v-else class="flex justify-center flex-col mt-10 pb-36">
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

        <div class="mx-auto -mt-10">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            No feedbacks yet
          </h2>
        </div>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="close"> Cancel </jet-secondary-button>
    </template>
  </jet-dialog-modal>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import FeedbackCard from "@/Components/FeedbackCard";
import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";

export default {
  props: ["show", "close", "feedbacks"],
  emits: ["show-edit-feedback-modal"],

  components: {
    JetDialogModal,
    JetButton,
    JetSecondaryButton,
    FeedbackCard,
    LottieAnimation,
  },

  data() {
    return {
      form: this.$inertia.form({}),
    };
  },

  methods: {
    averageRating() {
      const reducer = (a, b) => a.amount + b.amount;
      let sumOfRatings = this.feedbacks.reduce(reducer);

      let average = sumOfRatings / this.feedbacks.length;

      return average;
    },
  },
};
</script>