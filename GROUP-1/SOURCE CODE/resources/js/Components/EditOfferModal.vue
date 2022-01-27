<template>
  <jet-dialog-modal :show="show" @close="close">
    <template #title> Edit Post </template>

    <template #content>
      Please enter all the details required to edit product

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
        <jet-label value="Product Images" />
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
              onload: (response) => {
                removeFilePath(response);
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
      <jet-secondary-button @click="close"> Cancel </jet-secondary-button>

      <jet-button
        class="ml-2"
        @click="editOffer"
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
import TextArea from "@/Components/TextArea";
import Select from "@/Components/Select";
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

  props: ["editOfferData", "show", "close", "categories", "qtyTypes"],

  data() {
    return {
      csrfToken: this.$page.props.csrf_token,

      form: null,

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

    removeFilePath(data) {
      console.log(data);
      this.form.offerimg_filepath = [];
    },

    editOffer() {
      this.form.put(route("offer.update", this.editOfferData.offer.id), {
        preserveScroll: true,
        onSuccess: () => this.close(),
        onError: (e) => {
          console.log(e);
          this.$refs.prod_name.focus();
        },
        onFinish: () => this.form.reset(),
      });
    },

    handleFilePondInit: function () {
      setTimeout(() => this.$refs.prod_name.focus(), 250); // Should be on Mounted Hook
      // FilePond instance methods are available on `this.$refs.pond`
    },
  },

  beforeUpdate() {
    this.form = this.$inertia.form({
      prod_name: this.editOfferData.offer.prod_name,
      prod_qty: this.editOfferData.offer.prod_qty,
      category: this.editOfferData.offer.category,
      qty_type: this.editOfferData.offer.qty_type,
      date_produced: this.editOfferData.offer.date_produced,
      date_expired: this.editOfferData.offer.date_expiree,
      est_price: parseInt(this.editOfferData.offer.est_price),
      offerimg_filepath: [],
      post_id: this.editOfferData.offer.post_id,
    });

    if (
      this.editOfferData.offerImages.length === 1 &&
      this.editOfferData.offerImages[0].image === "/img/noimage.svg"
    ) {
      this.myFiles = null;
    } else {
      this.myFiles = this.editOfferData.offerImages.map((img) => {
        return {
          source: `${img.image}`,
        };
      });
    }
  },

  unmounted() {
    if (this.show) {
      this.form.reset();
    }
  },
};
</script>