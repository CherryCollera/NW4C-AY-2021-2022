<template>
  <div
    class="
      bg-white
      dark:bg-gray-800
      w-full
      rounded-lg
      p-4
      mb-6
      shadow
      sm:inline-block
    "
  >
    <div class="flex items-start text-left">
      <div class="flex-shrink-0">
        <div class="inline-block relative">
          <inertia-link
            :href="`/profile/${feedback.rater_user_id}`"
            class="block relative"
          >
            <img
              alt="profile"
              :src="profilePhoto"
              class="mx-auto object-cover rounded-full h-16 w-16"
            />
          </inertia-link>
          <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current text-white bg-green-600 rounded-full p-1 absolute bottom-0 right-0 w-6 h-6 -mx-1 -my-1">
                        <path d="M19 11a7.5 7.5 0 0 1-3.5 5.94L10 20l-5.5-3.06A7.5 7.5 0 0 1 1 11V3c3.38 0 6.5-1.12 9-3 2.5 1.89 5.62 3 9 3v8zm-9 1.08l2.92 2.04-1.03-3.41 2.84-2.15-3.56-.08L10 5.12 8.83 8.48l-3.56.08L8.1 10.7l-1.03 3.4L10 12.09z">
                        </path>
                    </svg> -->
        </div>
      </div>
      <div class="ml-6">
        <p class="flex items-baseline">
          <span class="text-gray-600 dark:text-gray-200 font-bold">
            {{ userData ? userData.name : "" }}
          </span>
          <span class="text-gray-500 dark:text-gray-300 ml-2 text-sm">
            {{ dateAgo }}
          </span>
        </p>

        <div class="flex flex-row mt-1">
          <svg
            v-for="(star, index) in feedback.amount"
            :key="index"
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            class="w-4 h-4 text-yellow-500"
            fill="currentColor"
            viewBox="0 0 1792 1792"
          >
            <path
              d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"
            ></path>
          </svg>

          <svg
            v-for="(star, index) in 5 - feedback.amount"
            :key="index"
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            class="w-4 h-4 text-gray-300"
            fill="currentColor"
            viewBox="0 0 1792 1792"
          >
            <path
              d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"
            ></path>
          </svg>
        </div>

        <div class="mt-3">
          <p class="mt-1 max-w-xs dark:text-white">
            {{ feedback.description }}
          </p>
        </div>
      </div>

      <div
        v-if="feedback.created_at !== feedback.updated_at"
        class="text-gray-500 dark:text-gray-300 ml-2 text-sm flex"
      >
        · &nbsp; edited
      </div>

      <div
        v-if="userData && userData.id === this.$page.props.authUser.id"
        @click.stop="this.$emit('show-edit-feedback-modal', feedback)"
        class="
          ml-auto
          w-4
          mr-2
          transform
          text-gray-400
          hover:text-yellow-500 hover:scale-150
          justify-right
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
          />
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
import UserServices from "@services/User";
import DateHelpers from "@utils/date-helpers";

export default {
  props: ["feedback"],

  data() {
    return {
      userData: null,
      profilePhoto: null,
      dateAgo: null,
    };
  },

  emits: ["show-edit-feedback-modal"],

  methods: {
    fetchProfilePhoto() {
      if (this.userData.profile_photo_path) {
        this.profilePhoto = "/storage/" + this.userData.profile_photo_path;
      } else {
        this.profilePhoto = `https://ui-avatars.com/api/?name=${this.userData.name}&color=059669&background=ECFDF5`;
      }
    },

    getTimeAgo() {
      this.dateAgo = DateHelpers.getTimeAgo(this.feedback.created_at);
    },

    async getUser(userID) {
      this.userData = await UserServices.getUser(userID);
      this.fetchProfilePhoto();
      this.getTimeAgo();
    },
  },

  created() {
    this.getUser(this.feedback.rater_user_id);
  },
};
</script>