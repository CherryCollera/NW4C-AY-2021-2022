<template>
  <jet-dialog-modal :show="showing" @close="closeModal">
    <template #title>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Add a Quantity Type
      </h2>
    </template>

    <template #content>
      Please enter all the details required to create a category
      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="qty_name" value="Quantity Type" />
        <jet-input
          type="text"
          class="mt-1 block w-full"
          placeholder="Type Quantity Type here"
          id="qty_name"
          ref="qty_name"
          v-model="form.qty_name"
          required
          @keyup.enter="createCategory"
        />
        <jet-input-error :message="form.errors.qty_name" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="value" value="Value" />
        <jet-input
          type="text"
          class="mt-1 block w-full"
          placeholder="Type category value here"
          id="value"
          ref="value"
          v-model="form.value"
          required
          @keyup.enter="createCategory"
        />
        <jet-input-error :message="form.errors.value" class="mt-2" />
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="closeModal"> Cancel </jet-secondary-button>

      <jet-button
        class="ml-2"
        @click="createCategory"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Post
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

  props: ["showing", "closeModal", "qtyTypes"],

  data() {
    return {
      form: this.$inertia.form({
        qty_name: null,
        value: null,
      }),
    };
  },

  methods: {
    createCategory() {
      this.form.post("/qty/add", {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.closeModal();
        },
        onError: () => this.$refs.qty_name.focus(),
      });
    },
  },

  beforeUpdate() {
    const lastItem = this.qtyTypes[this.qtyTypes.length - 1];
    const split = lastItem.value.split("-");
    let result;

    if (split && split.length > 1) {
      result = parseInt(split[1]) + 1;
    }

    this.form.value = `categ-${result}`;
  },

  beforeUnmount() {
    this.form.reset();
  },
};
</script>