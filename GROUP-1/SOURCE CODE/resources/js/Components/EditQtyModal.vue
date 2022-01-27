<template>
  <jet-dialog-modal :show="showingModal" @close="closeModal">
    <template #title> Edit Quantity type </template>

    <template #content>
      Please enter all the details required. We don't recommend doing this
      unless you really know what you're doing.
      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="qty_type" value="Quantity Type" />
        <jet-input
          type="text"
          class="mt-1 block w-full"
          placeholder="Type Quantity Type here"
          id="qty_type"
          ref="qty_type"
          v-model="form.qty_type"
          required
          @keyup.enter="editCategory"
        />
        <jet-input-error :message="form.errors.qty_type" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="qty_value" value="Value" />
        <jet-input
          type="text"
          class="mt-1 block w-full"
          placeholder="Type Qty value here"
          id="qty_value"
          ref="qty_value"
          v-model="form.qty_value"
          required
          @keyup.enter="editCategory"
        />
        <jet-input-error :message="form.errors.qty_value" class="mt-2" />
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="closeModal"> Cancel </jet-secondary-button>

      <jet-button
        class="ml-2"
        @click="editCategory"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
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

  props: ["showingModal", "closeModal", "data"],

  data() {
    return {
      form: null,
    };
  },

  methods: {
    editCategory() {
      this.form.put("/qty/edit", {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.qty_type.focus(),
        onFinish: () => this.form.reset(),
      });
    },
  },

  beforeUpdate() {
    this.form = this.$inertia.form({
      qty_type: this.data.name,
      qty_value: this.data.value,
      qty_id: this.data.id,
    });
  },

  unmounted() {
    if (this.showingModal) {
      this.form.reset();
    }
  },
};
</script>