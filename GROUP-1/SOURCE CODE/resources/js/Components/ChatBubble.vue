<template>
  <!-- Initiated Barter Bubble -->
  <div
    v-if="
      message.content ===
      'J0bZVYAygIsovtriXs23uXejc6bU85BjWQuTM8aeEptFCEeDlWmB5Uh41LoqhNaBQAV8EGkP6aRkcW8YE5ed2J8ygrk78yyM6xSxzRBzIwCVvXZHEDSnj96d0sAhLlzqaSMmPUsL4QIyqQbO0BxHqCCo65iNXzsWpP7KvTmq4LMtMPnY3YLA4a6EYixkgBEddE0XY3po2MjnpUgODprZkzJNgS3l9A4KOQnabCEjw2mCuIYKPZrCAB1VGTLYnj8H'
    "
    class="relative flex flex-col px-3 py-1 m-auto"
  >
    <div
      class="
        self-center
        px-2
        py-1
        mx-0
        my-1
        text-sm text-gray-700
        bg-white
        border border-gray-200
        rounded-full
        shadow
        rounded-tg
      "
    >
      {{ name }} Iniated Barter
    </div>
  </div>

  <!-- Deleted Post Bubble -->
  <div
    v-else-if="
      message.content ===
      'Y44OpG1tkc6XXe1eJD0U6zkjpz2WSg5EQwUqCzktqNFLQyZZnnjMcHo1NuWIg3TgXZ8y6FASjOZX97NR5NJ4IslpmFeao6ZK3fDJISMyQ1wdcJjdnIqSudjbwSxEa6H6W0sHli5Dr1eLASnhfNUuqLd0qfrXtQCaJsuNMcsXQIqMHSNY8SruMpj4gCANUmbiHMezuYcSF4Ir3WHzgkbK7vmbeTkMrT8lGoE4v8roHvH5TAK1UAQoODgK8fGzeJk3'
    "
    class="relative flex flex-col px-3 py-1 m-auto"
  >
    <div
      class="
        self-center
        px-2
        py-1
        mx-0
        my-1
        text-sm text-gray-700
        bg-white
        border border-gray-200
        rounded-full
        shadow
        rounded-tg
      "
    >
      {{ name }} Deleted the post
    </div>
  </div>

  <!-- Barter Done -->
  <div
    v-else-if="
      message.content ===
      'lCKgxW4lj8cUGg2nnqGziCsw7pp9uJo4xHFOIS9THC0r5OOdhZZvTL8HJNzUXUv7qajYPqcw9VY4HrEjox0NcR13jp8dSXpaUYsh8yxEAtvCxQ6HGbNKTRe2kvJBT16XBTIjtIcM669bPbuxs27VvMtThBkZfznEgRcZvP3sZH5Eq1g9VbPsBVSb4kdaAGA41vC6xmfW7YZFM8MWY0QrjnzoMiwSrAf0hCE5XlErHZpCH9IRI913yDx7m5S1PBjO'
    "
    class="relative flex flex-col px-3 py-1 m-auto"
  >
    <div
      class="
        self-center
        px-2
        py-1
        mx-0
        my-1
        text-sm text-gray-700
        bg-white
        border border-gray-200
        rounded-full
        shadow
        rounded-tg
      "
    >
      {{ name }} Marked the barter as done
    </div>
  </div>

  <div
    v-else
    class="w-full flex"
    :class="fromAuthUser ? 'justify-start' : 'justify-end'"
  >
    <div class="flex">
      <div
        class="flex flex-wrap content-end px-1"
        :class="fromAuthUser ? 'order-first' : 'order-last'"
      >
        <img
          :src="getProfilePhoto()"
          alt="photo"
          class="w-5 h-5 rounded-full order-1"
        />
      </div>

      <div
        class="bg-gray-100 rounded-md px-5 py-2 my-2 text-gray-700 relative"
        style="max-width: 300px"
      >
        <div v-if="message.post_id">
          <div v-if="postExists">
            <div
              class="
                shadow-lg
                rounded-2xl
                w-64
                p-4
                bg-white
                relative
                overflow-hidden
              "
            >
              <img
                alt="pic"
                :src="getPostPhoto()"
                class="absolute -right-20 -bottom-8 h-40 w-40 mb-4"
              />
              <div class="w-4/6">
                <p class="text-gray-800 text-lg font-medium mb-2">My post</p>
                <p class="text-gray-400 text-xs">
                  {{ this.post ? getCategory(this.post.category) : "" }}
                </p>
                <p class="text-green-500 text-xl font-medium">
                  {{ this.post ? this.post.prod_name : "" }}
                </p>
              </div>
            </div>

            <div
              class="
                mt-2
                mb-2
                shadow-lg
                rounded-2xl
                w-64
                p-4
                bg-white
                relative
                overflow-hidden
              "
            >
              <img
                alt="pic"
                :src="getOfferPhoto()"
                class="absolute -right-20 -bottom-8 h-40 w-40 mb-4"
              />
              <div class="w-4/6">
                <p class="text-gray-800 text-lg font-medium mb-2">Your Offer</p>
                <p class="text-gray-400 text-xs">
                  {{ this.offer ? getCategory(this.offer.category) : "" }}
                </p>
                <p class="text-green-500 text-xl font-medium">
                  {{ this.offer ? this.offer.prod_name : "" }}
                </p>
              </div>
            </div>
          </div>

          <div v-else>
            <div
              class="
                shadow-lg
                rounded-2xl
                w-64
                p-4
                bg-white
                relative
                overflow-hidden
              "
            >
              <img
                alt="pic"
                src="/img/logo1.webp"
                class="absolute -right-20 -bottom-8 h-40 w-40 mb-4"
              />
              <div class="w-4/6">
                <p class="text-gray-800 text-lg font-medium mb-2">
                  This post has been deleted
                </p>
              </div>
            </div>
          </div>
        </div>

        <img
          v-if="message.image_path"
          :src="`/storage/${message.image_path}`"
          class="p-1 rounded-2xl"
        />
        <span class="block">{{ message.content }}</span>
        <span
          :class="fromAuthUser ? 'text-right' : 'text-left'"
          class="block text-xs"
          >{{ getTimeAgo(message.created_at) }}</span
        >
      </div>
    </div>
  </div>
</template>

<script>
import DateHelpers from "@utils/date-helpers";
import PostServices from "@services/Post";
import OfferServices from "@services/Offer";
import PostImageServices from "@services/PostImage";
import OfferImageServices from "@services/OfferImage";
import UserServices from "@services/User";

export default {
  props: ["message", "otherUserPhoto", "categories", "qtyType"],

  data() {
    return {
      fromAuthUser:
        this.$page.props.authUser.id === this.message.sender_id ? false : true,
      post: null,
      offer: null,
      postPhotos: null,
      offerPhotos: null,
      name: null,
      postExists: null,
    };
  },

  methods: {
    getCategory(category) {
      if (category && this.categories) {
        let results = this.categories.filter(
          (categ) => categ.value === category
        );

        if (results.length) return results[0].name;
        else return "Unknown";
      } else {
        return "Unknown";
      }
    },

    async isPostExists(postID) {
      this.postExists = await PostServices.exists(postID);
    },

    getPostPhoto() {
      if (this.postPhotos === null) return "/img/logo1.webp";

      return this.postPhotos.length > 0
        ? `/storage/${this.postPhotos[0].post_image_path}`
        : "/img/logo1.webp";
    },

    getOfferPhoto() {
      if (this.offerPhotos === null) return "/img/logo1.webp";

      return this.offerPhotos.length > 0
        ? `/storage/${this.offerPhotos[0].offer_image_path}`
        : "/img/logo1.webp";
    },

    getProfilePhoto() {
      if (!this.fromAuthUser) {
        return this.$page.props.authUser.profile_photo_path
          ? "/storage/" + this.$page.props.authUser.profile_photo_path
          : `https://ui-avatars.com/api/?name=${this.$page.props.authUser.name}&color=059669&background=ECFDF5`;
      } else {
        return this.otherUserPhoto;
      }
    },

    getTimeAgo(date) {
      return DateHelpers.getTimeAgo(date);
    },

    async getName() {
      this.name = await UserServices.getName(this.message.sender_id);
    },

    async getPost() {
      this.post = await PostServices.getPost(this.message.post_id);
    },

    async getOffer() {
      this.offer = await OfferServices.getOffer(this.message.offer_id);
    },

    async getPhotos() {
      this.postPhotos = await PostImageServices.get(this.message.post_id);
      this.offerPhotos = await OfferImageServices.getOfferImages(
        this.message.offer_id
      );
    },

    numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
  },

  created() {
    // Initiated Barter
    if (
      this.message.content ===
      "J0bZVYAygIsovtriXs23uXejc6bU85BjWQuTM8aeEptFCEeDlWmB5Uh41LoqhNaBQAV8EGkP6aRkcW8YE5ed2J8ygrk78yyM6xSxzRBzIwCVvXZHEDSnj96d0sAhLlzqaSMmPUsL4QIyqQbO0BxHqCCo65iNXzsWpP7KvTmq4LMtMPnY3YLA4a6EYixkgBEddE0XY3po2MjnpUgODprZkzJNgS3l9A4KOQnabCEjw2mCuIYKPZrCAB1VGTLYnj8H"
    ) {
      this.getName();

      // Deleted Post
    } else if (
      this.message.content ===
      "Y44OpG1tkc6XXe1eJD0U6zkjpz2WSg5EQwUqCzktqNFLQyZZnnjMcHo1NuWIg3TgXZ8y6FASjOZX97NR5NJ4IslpmFeao6ZK3fDJISMyQ1wdcJjdnIqSudjbwSxEa6H6W0sHli5Dr1eLASnhfNUuqLd0qfrXtQCaJsuNMcsXQIqMHSNY8SruMpj4gCANUmbiHMezuYcSF4Ir3WHzgkbK7vmbeTkMrT8lGoE4v8roHvH5TAK1UAQoODgK8fGzeJk3"
    ) {
      this.getName();
    }

    // Barter Done
    else if (
      this.message.content ===
      "lCKgxW4lj8cUGg2nnqGziCsw7pp9uJo4xHFOIS9THC0r5OOdhZZvTL8HJNzUXUv7qajYPqcw9VY4HrEjox0NcR13jp8dSXpaUYsh8yxEAtvCxQ6HGbNKTRe2kvJBT16XBTIjtIcM669bPbuxs27VvMtThBkZfznEgRcZvP3sZH5Eq1g9VbPsBVSb4kdaAGA41vC6xmfW7YZFM8MWY0QrjnzoMiwSrAf0hCE5XlErHZpCH9IRI913yDx7m5S1PBjO"
    ) {
      this.getName();
    } else if (this.message.post_id) {
      this.isPostExists(this.message.post_id);
      this.getPost();
      this.getOffer();
      this.getPhotos();
    }
  },
};
</script>