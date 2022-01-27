<template>
  <jet-dialog-modal :show="showingReportModal" @close="closeReportModal">
    <template #title>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        File a report
      </h2>
    </template>

    <template #content>
      Please enter all the details required so we can process your report. It is
      highly recommended to attach an image to make the report investigation
      easier.

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="report_type" value="Report Type" />
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
          id="report_type"
          ref="report_type"
          v-model="form.report_type"
          required
        >
          <option disabled value="" selected>Select report type</option>
          <option
            v-for="(option, index) in reportOptions"
            v-bind:value="option.value"
            :key="index"
          >
            {{ option.text }}
          </option>
        </select>
        <jet-input-error :message="form.errors.report_type" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label for="report_desc" value="Report Description" />
        <text-area
          rows="5"
          class="mt-1 block w-full"
          placeholder="Tell us why you reported"
          id="report_desc"
          ref="report_desc"
          v-model="form.report_desc"
          required
        />
        <jet-input-error :message="form.errors.report_desc" class="mt-2" />
      </div>

      <div class="mt-4 flex flex-col justify-center">
        <jet-label value="Report Images" />
        <file-pond
          name="reportimg"
          ref="reportimg"
          label-idle="Drop files here or <span class='filepond--label-action'>Browse</span>"
          v-bind:allow-multiple="true"
          accepted-file-types="image/jpeg, image/jpg,"
          :allowFileSizeValidation="true"
          maxFileSize="5MB"
          maxTotalFileSize="5MB"
          v-bind:server="{
            url: '/reportImg',
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
          id="reportimg_filepath"
          ref="reportimg_filepath"
          v-model="form.reportimg_filepath"
        />
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="closeReportModal">
        Cancel
      </jet-secondary-button>

      <jet-button
        class="ml-2"
        @click="createReport"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Report
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
    "showingReportModal",
    "closeReportModal",
    "reportData",
  ],

  data() {
    return {
      csrfToken: this.$page.props.csrf_token,

      form: this.$inertia.form({
        report_type: null,
        report_desc: null,
        reported_post_id: null,
        reported_user_id: null,
        reportimg_filepath: [],
      }),

      reportOptions: [
        { text: "Offensive Language", value: "categ-1" },
        { text: "Harassment", value: "categ-2" },
        { text: "Sexually Explicit Contents", value: "categ-3" },
        { text: "Fraud", value: "categ-4" },
        { text: "Inappropriate Contents", value: "categ-5" },
      ],

      myFiles: [],
    };
  },

  methods: {
    logFilePath(data) {
      this.form.reportimg_filepath.push(data);
    },

    createReport() {
      this.form.post("/report/store", {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length,
        onSuccess: () => this.closeReportModal(),
        onError: (e) => {
          this.$refs.report_desc.focus();
          console.log(e);
        },
        onFinish: () => this.form.reset(),
      });
    },

    handleFilePondInit: function () {
      this.form.reported_post_id = this.reportData.postID;
      this.form.reported_user_id = this.reportData.userID;

      setTimeout(() => this.$refs.report_desc.focus(), 250); // Should be on Mounted Hook
      // FilePond instance methods are available on `this.$refs.pond`
    },
  },

  beforeUnmount() {
    this.form.reset();
  },
};
</script>