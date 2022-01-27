<template>
  <div class="col-span-2 bg-white">
    <div class="w-full">
      <div class="flex justify-between border-b border-gray-300 pl-3 py-3">
        <div>
          <inertia-link
            class="flex items-center"
            :href="route('userProfile', getUserID())"
          >
            <img
              class="h-10 w-10 rounded-full object-cover"
              :src="convo.photo"
              alt="username"
            />
            <span class="block ml-2 font-bold text-base text-gray-600">{{
              convo.name
            }}</span>
          </inertia-link>
        </div>

        <!-- Barter Dropdown -->
        <div class="mr-5">
          <dropdown>
            <template #trigger>
              <button
                class="
                  relative
                  z-10
                  block
                  p-2
                  transition-colors
                  duration-200
                  transform
                  bg-gray-300
                  rounded-md
                  hover:bg-green-500
                  focus:outline-none focus:bg-green-300
                "
              >
                <svg
                  class="w-6 h-6 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                  />
                </svg>
              </button>
            </template>

            <template #content>
              <div class="block px-4 py-2 text-xs text-gray-400">Barter</div>
              <jet-dropdown-link
                :disabled="!postExists || barterDone"
                v-if="!hasStartedBarter"
                @click="startBarter()"
                as="button"
              >
                Start Barter
              </jet-dropdown-link>
              <jet-dropdown-link
                :disabled="!postExists || barterDone || isPoster()"
                v-if="hasStartedBarter"
                @click="showFeedbackModal()"
                as="button"
              >
                Mark Barter as Done
              </jet-dropdown-link>
            </template>
          </dropdown>
        </div>
      </div>
      <div
        id="chat"
        class="w-full overflow-y-auto p-10 relative"
        style="height: calc(100vh - 14.5rem)"
      >
        <ul>
          <li class="clearfix2">
            <chat-bubble
              v-for="message in convo.convo.message"
              :key="message.id"
              :message="message"
              :otherUserPhoto="convo.photo"
              :categories="categories"
              :qtyType="qtyType"
            />
          </li>
        </ul>
      </div>

      <feedback-modal
        :showingModal="showingFeedbackModal"
        :closeModal="closeFeedbackModal"
        :convoDetails="convoDetails"
      />

      <!-- Chat Input Buttons -->
      <chat-box-input
        v-if="postExists"
        :openAddPhoto="openAddPhoto"
        :convo="convo"
        :form="form"
      />

      <!-- Add Photo Modal -->
      <jet-dialog-modal :show="showingAddPhoto" @close="closeAddPhoto">
        <template #title> Add a photo </template>

        <template #content>
          <file-pond
            name="msgimg"
            ref="pond"
            label-idle="Drop files here or <span class='filepond--label-action'>Browse</span>"
            v-bind:allow-multiple="false"
            accepted-file-types="image/jpeg, image/png,"
            v-bind:server="{
              url: '/msgImg',
              timeout: 7000,
              process: {
                url: '/process',
                method: 'POST',
                headers: {
                  'X-CSRF-TOKEN': this.$page.props.csrf_token,
                },
                onload: (response) => {
                  logFilePath(response);
                },
                withCredentials: false,
              },
            }"
            v-bind:files="msgimgFiles"
            v-on:init="handleFilePondInit"
          />
          <jet-input
            type="hidden"
            id="msgimg_filepath"
            ref="msgimg_filepath"
            v-model="msgimgForm.msgimg_filepath"
          />
        </template>

        <template #footer>
          <jet-secondary-button @click="closeAddPhoto">
            Cancel
          </jet-secondary-button>

          <jet-button
            class="ml-2"
            @click="createMsgImg"
            :class="{ 'opacity-25': msgimgForm.processing }"
            :disabled="msgimgForm.processing"
          >
            Send
          </jet-button>
        </template>
      </jet-dialog-modal>
    </div>
  </div>
</template>

<script>
import ChatBubble from "@/Components/ChatBubble";
import JetDialogModal from "@/Jetstream/DialogModal";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetInput from "@/Jetstream/Input";
import ChatBoxInput from "@/Components/ChatBoxInput";
import Dropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import BarterServices from "@services/Barter";
import FeedbackModal from "@/Components/FeedbackModal";
import PostServices from "@services/Post";

// Create FilePond Component
const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

export default {
  props: ["convo", "categories", "qtyType"],

  components: {
    ChatBubble,
    JetDialogModal,
    JetButton,
    JetSecondaryButton,
    FilePond,
    JetInput,
    ChatBoxInput,
    Dropdown,
    JetDropdownLink,
    FeedbackModal,
  },

  data() {
    return {
      form: this.$inertia.form({
        msg_content: "",
        convo_id: this.convo.convo.id,
        sender_id: this.$page.props.authUser.id,
      }),

      chatDiv: null,

      showingAddPhoto: false,

      msgimgFiles: null,

      msgimgForm: this.$inertia.form({
        convo_id: this.convo.convo.id,
        sender_id: this.$page.props.authUser.id,
        msg_content: "",
        msgimg_filepath: null,
      }),

      showingFeedbackModal: false,

      convoDetails: {
        convoID: this.convo.convo.id,
        post: this.convo.convo.post_id,
        receiver: this.convo.convo.receiver_user_id, // this user is the one that posted
        sender: this.convo.convo.sender_user_id, // this user sent the offer
      },

      hasStartedBarter: null,

      postExists: null,

      barterDone: null,
    };
  },

  methods: {
    async checkIfBarterDone() {
      this.barterDone = await BarterServices.checkIfBarterDone(
        this.convo.convo.id
      );
    },

    isPoster() {
      return this.convoDetails.receiver === this.$page.props.authUser.id
        ? true
        : false;
    },

    showFeedbackModal() {
      this.showingFeedbackModal = true;
    },

    closeFeedbackModal() {
      this.showingFeedbackModal = false;
      this.getBarterStatus();
      this.checkIfPostExists();
      this.checkIfBarterDone();
    },

    async getBarterStatus() {
      this.hasStartedBarter = await BarterServices.checkIfBarterExists(
        this.convo.convo.id
      );
    },

    async checkIfPostExists() {
      this.postExists = await PostServices.exists(this.convo.convo.post_id);
    },

    startBarter() {
      let startBarterForm = this.$inertia.form({
        convo_id: this.convo.convo.id,
        post_id: this.convo.convo.post_id,
      });

      startBarterForm.post("/startBarter", {
        onSuccess: () => {
          this.getBarterStatus();
          this.checkIfPostExists();
        },
        onError: () => console.log("error"),
        onFinish: () => startBarterForm.reset(),
      });
    },

    createMsgImg() {
      this.msgimgForm.post(route("message.store"), {
        preserveScroll: true,
        onSuccess: () => this.closeAddPhoto(),
        onError: (e) => console.log(e),
        onFinish: () => this.form.reset(),
      });
    },

    logFilePath(data) {
      this.msgimgForm.msgimg_filepath = data;
    },

    handleFilePondInit: function () {
      // FilePond instance methods are available on `this.$refs.pond`
    },

    closeAddPhoto() {
      this.showingAddPhoto = false;
    },

    openAddPhoto() {
      this.showingAddPhoto = true;
    },

    getUserID() {
      return this.$page.props.authUser.id === this.convo.convo.sender_user_id
        ? this.convo.convo.receiver_user_id
        : this.convo.convo.sender_user_id;
    },
  },

  mounted() {
    // Make sure that the DOM finished rendering
    this.$nextTick(() => {
      this.chatDiv = document.getElementById("chat");
      this.chatDiv.scrollTop = chat.scrollHeight;
    });

    this.getBarterStatus();
    this.checkIfPostExists();
    this.checkIfBarterDone();
  },

  beforeUpdate() {
    this.chatDiv.scrollTop = {};
    this.form.convo_id = this.convo.convo.id;
  },

  updated() {
    this.chatDiv.scrollTop = chat.scrollHeight;
    this.getBarterStatus();
    this.checkIfPostExists();
    this.checkIfBarterDone();
  },
};
</script>