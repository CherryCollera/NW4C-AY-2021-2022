<template>
  <jet-dialog-modal :show="showing" @close="closeModal">
    <template #title>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Promote/Demote a User
      </h2>
    </template>

    <template #content>
      Please enter all the details required

      <!-- User ID -->
      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="user_id" value="User ID" />
        <jet-input
          type="text"
          class="mt-1 block w-full"
          placeholder="Type User ID here"
          id="user_id"
          ref="user_id"
          v-model="form.user_id"
          required
          @keyup.enter="createPromotion"
        />
        <jet-input-error :message="form.errors.user_id" class="mt-2" />
      </div>

      <!-- Promote / Demote To -->
      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="promoted_to" value="Promote / Demote" />
        <select
          class="
            mt-1
            block
            w-full
            border-gray-300
            focus:border-green-300
            focus:ring
            focus:ring-green-200
            focus:ring-opacity-50
            rounded-md
            shadow-sm
          "
          id="promoted_to"
          ref="promoted_to"
          v-model="form.promoted_to"
          required
        >
          <option disabled value="" selected>Select promotion</option>
          <option
            v-for="(option, index) in promotionOption"
            v-bind:value="option.value"
            :key="index"
          >
            {{ option.text }}
          </option>
        </select>
        <jet-input-error :message="form.errors.promoted_to" class="mt-2" />
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="closeModal"> Cancel </jet-secondary-button>

      <jet-button
        class="ml-2"
        @click="createPromotion"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Proceed
      </jet-button>
    </template>
  </jet-dialog-modal>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetLabel from "@/Jetstream/Label";

export default {
  components: {
    JetDialogModal,
    JetInput,
    JetInputError,
    JetButton,
    JetSecondaryButton,
    JetLabel,
  },

  props: ["showing", "closeModal"],

  data() {
    return {
      form: this.$inertia.form({
        user_id: null,
        promoted_to: null,
      }),

      promotionOption: [
        {
          text: "Promote To Moderator",
          value: 2,
        },
        {
          text: "Demote to Normal User",
          value: 3,
        },
      ],
    };
  },

  methods: {
    createPromotion() {
      this.form.post("/promotion", {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.closeModal();
        },
        onError: () => this.$refs.user_id.focus(),
        onFinish: () => this.form.reset(),
      });
    },
  },

  beforeUpdate() {
    if (this.showing) {
      this.form.reset();
    }
  },

  beforeUnmount() {
    if (this.showing) {
      this.form.reset();
    }
  },
};
</script>