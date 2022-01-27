<template>
  <jet-dialog-modal :show="showingModal" @close="closeModal">
    <template #title> Edit Category </template>

    <template #content>
      Please enter all the details required. We don't recommend doing this
      unless you really know what you're doing.
      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="category_name" value="Category Name" />
        <jet-input
          type="text"
          class="mt-1 block w-full"
          placeholder="Type category name here"
          id="category_name"
          ref="category_name"
          v-model="form.category_name"
          required
          @keyup.enter="editCategory"
        />
        <jet-input-error :message="form.errors.category_name" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="category_value" value="Value" />
        <jet-input
          type="text"
          class="mt-1 block w-full"
          placeholder="Type category value here"
          id="category_value"
          ref="category_value"
          v-model="form.category_value"
          required
          @keyup.enter="editCategory"
        />
        <jet-input-error :message="form.errors.category_value" class="mt-2" />
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
      this.form.put("/category/edit", {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.category_name.focus(),
        onFinish: () => this.form.reset(),
      });
    },
  },

  beforeUpdate() {
    this.form = this.$inertia.form({
      category_name: this.data.name,
      category_value: this.data.value,
      category_id: this.data.id,
    });
  },

  unmounted() {
    if (this.showingModal) {
      this.form.reset();
    }
  },
};
</script>