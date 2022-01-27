<template>
  <jet-dialog-modal :show="showing" @close="close">
    <template #title>
      <h2 class="text-gray-800 text-3xl font-semibold">Edit Feedback</h2>
    </template>

    <template #content>
      <div class="bg-white min-w-1xl flex flex-col rounded-xl shadow-lg">
        <div class="bg-gray-200 w-full flex flex-col items-center">
          <div class="flex flex-col items-center py-6 space-y-3">
            <span class="text-lg text-gray-800">How was the barter?</span>

            <div class="flex space-x-3">
              <star-rating
                @update:rating="setRating"
                :rating="this.feedback.amount"
                :animate="true"
                :show-rating="false"
                :border-width="4"
                :active-color="['#ae0000', '#ffd055']"
                :star-points="[
                  23, 2, 14, 17, 0, 19, 10, 34, 7, 50, 23, 43, 38, 50, 36, 34,
                  46, 19, 31, 17,
                ]"
                :active-on-click="true"
                :padding="3"
              ></star-rating>
              <jet-input-error :message="form.errors.rating" class="mt-2" />
            </div>
          </div>

          <div class="w-3/4 flex flex-col p-5">
            <text-area
              v-model="form.feedbackMessage"
              placeholder="Leave a brief description of the barter"
            />
          </div>
        </div>
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="close"> Cancel </jet-secondary-button>

      <jet-button
        class="ml-2"
        @click="makeFeedback"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Rate
      </jet-button>
    </template>
  </jet-dialog-modal>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import StarRating from "vue-star-rating";
import TextArea from "@/Components/TextArea";
import JetInputError from "@/Jetstream/InputError";

export default {
  props: ["close", "showing", "feedback"],

  components: {
    JetDialogModal,
    JetButton,
    JetSecondaryButton,
    StarRating,
    TextArea,
    JetInputError,
  },

  data() {
    return {
      form: this.$inertia.form({
        feedback: null,
        rating: 0,
        feedbackMessage: "",
      }),
    };
  },

  methods: {
    setRating(rating) {
      this.form.rating = rating;
    },

    makeFeedback() {
      this.form.put("/feedback/edit", {
        preserveScroll: true,
        onSuccess: () => this.close(),
        onError: (e) => console.log(e),
        onFinish: () => this.form.reset(),
      });
    },
  },

  beforeUpdate() {
    if (this.showing && this.feedback) {
      this.form.feedbackMessage = this.feedback.description;
      this.form.feedback = this.feedback;
    }
  },
};
</script>