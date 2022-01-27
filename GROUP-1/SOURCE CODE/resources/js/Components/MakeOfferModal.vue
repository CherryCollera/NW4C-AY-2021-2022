<template>
  <jet-dialog-modal :show="showingMakeOfferModal" @close="closeMakeOfferModal">
    <template #title> Make an offer </template>

    <template #content>
      Please enter all the details required to make offer

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="prod_name" value="Product Name" />
        <jet-input
          type="text"
          class="mt-1 block w-full"
          placeholder="Type product name here"
          id="prod_name"
          ref="prod_name"
          v-model="form.prod_name"
          required
        />
        <jet-input-error :message="form.errors.prod_name" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="prod_qty" value="Product Quantity" />
        <jet-input
          type="number"
          class="mt-1 block w-full"
          placeholder="Type product quantity here"
          id="prod_qty"
          ref="prod_qty"
          v-model="form.prod_qty"
          required
        />
        <jet-input-error :message="form.errors.prod_qty" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="qty_type" value="Quantity Type" />
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
          id="qty_type"
          ref="qty_type"
          v-model="form.qty_type"
          required
        >
          <option disabled value="" selected>Select qty type here</option>
          <option
            v-for="(option, index) in qtyOptions"
            v-bind:value="option.value"
            :key="index"
          >
            {{ option.text }}
          </option>
        </select>
        <jet-input-error :message="form.errors.qty_type" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="date_produced" value="Date Produced" />
        <jet-input
          type="date"
          class="mt-1 block w-full"
          placeholder="Choose the date when the product was produced"
          id="date_produced"
          ref="date_produced"
          v-model="form.date_produced"
          required
        />
        <jet-input-error :message="form.errors.date_produced" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="date_expired" value="Estimated Expiree Date" />
        <jet-input
          type="date"
          class="mt-1 block w-full"
          placeholder="Choose the date when the product was produced"
          id="date_expired"
          ref="date_expired"
          v-model="form.date_expired"
          required
        />
        <jet-input-error :message="form.errors.date_expired" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="category" value="Category" />
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
          id="category"
          ref="category"
          v-model="form.category"
          required
        >
          <option disabled value="" selected>Select category here</option>
          <option
            v-for="(option, index) in categoryOptions"
            v-bind:value="option.value"
            :key="index"
          >
            {{ option.text }}
          </option>
        </select>
        <jet-input-error :message="form.errors.category" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label value="Offer Images" />
        <file-pond
          name="postimg"
          ref="pond"
          label-idle="Drop files here or <span class='filepond--label-action'>Browse</span>"
          v-bind:allow-multiple="true"
          accepted-file-types="image/jpeg, image/png,"
          :allowFileSizeValidation="true"
          maxFileSize="5MB"
          maxTotalFileSize="5MB"
          v-bind:server="{
            url: '/postImg',
            timeout: 7000,
            process: {
              url: '/process',
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
              },
              onload: (response) => {
                logFilePath(response);
              },
              withCredentials: false,
            },
            revert: {
              url: '/revert',
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                _method: 'DELETE',
              },
            },
          }"
          v-bind:files="myFiles"
          v-on:init="handleFilePondInit"
        />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-input
          type="hidden"
          id="offerimg_filepath"
          ref="offerimg_filepath"
          v-model="form.offerimg_filepath"
        />
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="closeMakeOfferModal">
        Cancel
      </jet-secondary-button>

      <jet-button
        class="ml-2"
        @click="createOffer"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Offer
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
import TextArea from "../Components/TextArea";
import Select from "../Components/Select";
import JetLabel from "@/Jetstream/Label";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Create FilePond Component
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

export default {
  components: {
    JetDialogModal,
    JetInput,
    JetInputError,
    JetButton,
    JetSecondaryButton,
    TextArea,
    Select,
    JetLabel,
    FilePond,
  },

  props: [
    "data",
    "errors",
    "showingMakeOfferModal",
    "closeMakeOfferModal",
    "postID",
    "categories",
    "qtyTypes",
  ],

  data() {
    return {
      csrfToken: this.$page.props.csrf_token,

      form: this.$inertia.form({
        prod_name: null,
        prod_qty: null,
        category: null,
        qty_type: null,
        date_produced: null,
        date_expired: null,
        est_price: null,
        offerimg_filepath: [],
        post_id: null,
      }),

      categoryOptions: this.categories
        .filter((category) => category.id !== 1)
        .map((category) => {
          return {
            text: category.name,
            value: category.value,
          };
        }),

      qtyOptions: this.qtyTypes.map((qtyType) => {
        return {
          text: qtyType.name,
          value: qtyType.value,
        };
      }),

      myFiles: [],
    };
  },

  methods: {
    logFilePath(data) {
      this.form.offerimg_filepath.push(data);
    },

    createOffer() {
      this.form.post(route("offer.store"), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length,
        onSuccess: () => this.closeMakeOfferModal(),
        onError: () => this.$refs.prod_name.focus(),
        onFinish: () => this.form.reset(),
      });
    },

    handleFilePondInit: function () {
      setTimeout(() => this.$refs.prod_name.focus(), 250); // Should be on Mounted Hook
      // FilePond instance methods are available on `this.$refs.pond`
    },
  },

  beforeUpdate() {
    this.form.post_id = this.postID;
  },

  beforeUnmount() {
    this.form.reset();
  },
};
</script>