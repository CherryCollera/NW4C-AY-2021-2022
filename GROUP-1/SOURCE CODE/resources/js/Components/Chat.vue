<template>
  <div
    class="grid grid-cols-3 min-w-full border rounded"
    style="height: calc(100vh - 11rem)"
  >
    <div class="col-span-1 bg-white border-r border-gray-300">
      <div class="my-3 mx-3">
        <div class="relative text-gray-600 focus-within:text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
              <path
                d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              ></path>
            </svg>
          </span>

          <input
            id="search"
            type="text"
            v-model="search"
            class="
              w-full
              py-2
              pl-10
              pr-4
              text-gray-700
              bg-white
              border border-gray-300
              rounded-md
              focus:border-green-500 focus:outline-none focus:ring-0
            "
            placeholder="Search"
          />
        </div>
      </div>

      <div v-if="isSearchResultsEmpty" class="flex justify-center flex-col">
        <div class="mx-auto">
          <lottie-animation
            path="animations/empty-search.json"
            :loop="true"
            :autoPlay="true"
            :speed="1"
            background="transparent"
            :width="300"
            :height="300"
          />
        </div>

        <div class="mx-auto">
          <h2
            class="
              text-center
              font-semibold
              text-xl text-gray-800
              leading-tight
            "
          >
            No search results
          </h2>
        </div>
      </div>

      <ul class="overflow-auto" style="height: calc(100vh - 11rem)">
        <li>
          <div v-if="convos.length">
            <conversation
              v-for="convo in convos"
              :key="convo.id"
              :convo="convo"
              :showConvo="showConvo"
              :search="search"
              v-on:messages-no-search-matches="displayEmptyResults()"
              v-on:messages-search-matches="displaySearchResults()"
            />
          </div>

          <div v-else>
            <div class="mx-auto">
              <lottie-animation
                path="animations/empty-box.json"
                :loop="true"
                :autoPlay="true"
                :speed="1"
                background="transparent"
                :width="300"
                :height="300"
              />
            </div>

            <div class="mx-auto">
              <h2
                class="
                  text-center
                  font-semibold
                  text-xl text-gray-800
                  leading-tight
                "
              >
                Empty Inbox
              </h2>
            </div>
          </div>
        </li>
      </ul>
    </div>

    <chat-box
      v-if="convo"
      :convo="convo"
      :categories="categories"
      :qtyType="qtyType"
    />

    <div v-else class="col-span-2 bg-white w-full">
      <div class="flex justify-center mt-24">
        <div
          class="
            border border-black
            rounded-full
            inline-flex
            p-5
            items-center
            justify-center
          "
        >
          <svg
            class="transform translate-y-1"
            height="52"
            viewBox="0 0 48 48"
            width="52"
          >
            <path
              d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l13.2 13c.5.4 1.1.6 1.7.3l16.6-8c.7-.3 1.6-.1 2 .5.4.7.2 1.6-.5 2l-15.6 9.9c-.5.3-.8 1-.7 1.6l4.6 19c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.5-.5.5-1.1.2-1.6z"
            ></path>
          </svg>
        </div>
      </div>
      <div class="space-y-0.5">
        <h1 class="text-center font-semibold text-xl mt-5">Your Messages</h1>
        <p class="text-center text-gray-600 min-w-46">
          Send private photos and messages to other traders
        </p>
        <p class="text-center text-xs text-gray-600 min-w-46 mt-24">
          No messages here yet!
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import Conversation from "@/Components/ChatConversation";
import ChatBox from "@/Components/ChatBox";
import ConvoServices from "@services/Conversation";
import Input from "@/Jetstream/Input";
import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";

export default {
  props: ["conversations", "categories", "qtyType"],

  components: {
    Conversation,
    ChatBox,
    Input,
    LottieAnimation,
  },

  data() {
    return {
      convos: this.conversations,
      convo: null,
      search: "",
      isSearchResultsEmpty: false,
    };
  },

  methods: {
    displaySearchResults() {
      this.isSearchResultsEmpty = false;
    },

    displayEmptyResults() {
      this.isSearchResultsEmpty = true;
    },

    connectToBroadcast(convoID) {
      let vm = this;

      window.Echo.private("chat." + convoID).listen(".message.new", (e) => {
        vm.getNewConversations();
      });
    },

    disconnectToBroadcast(convoID) {
      window.Echo.leave("chat." + convoID);
    },

    showConvo(convo, sender) {
      this.convo = {
        convo: convo,
        name: sender.name,
        photo: sender.profile_photo_path
          ? "/storage/" + sender.profile_photo_path
          : `https://ui-avatars.com/api/?name=${sender.name}&color=059669&background=ECFDF5`,
      };
    },

    async getNewConversations() {
      this.convos = []; // workaround to vuejs only mutating list to array.push
      this.convos.push(...(await ConvoServices.getConvos()));

      if (this.convo)
        this.convo.convo = this.convos.find(
          (convo) => convo.id === this.convo.convo.id
        );
    },
  },

  mounted() {
    this.convos.map((convo) => {
      this.connectToBroadcast(convo.id);
    });

    console.log("connected to broadcast");
  },

  beforeUnmount() {
    this.convos.map((convo) => {
      this.disconnectToBroadcast(convo.id);
    });
  },
};
</script>