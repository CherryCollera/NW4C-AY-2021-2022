<template>
  <tr class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100">
    <!-- Promotion ID -->
    <td class="py-3 px-6 text-center">{{ promotion.id }}</td>

    <!-- Promoted User -->
    <td class="py-3 px-6 text-center">
      <div class="flex items-center">
        <div class="mr-2">
          <inertia-link
            @click.stop=""
            :href="route('userProfile', promotion.user_id)"
          >
            <img
              class="
                w-6
                h-6
                rounded-full
                border-gray-200 border
                transform
                hover:scale-125
              "
              :src="getProfilePhoto(user)"
            />
          </inertia-link>
        </div>
        <span class="font-semibold">{{ user ? user.name : "" }}</span>
      </div>
    </td>

    <!-- Created At -->
    <td class="py-3 px-6 text-center">
      {{ formatDate(promotion.created_at) }}
    </td>

    <!-- Promoted By -->
    <td class="py-3 px-6 text-center">
      <div class="flex items-center">
        <div class="mr-2">
          <inertia-link
            @click.stop=""
            :href="route('userProfile', promoter ? promoter.id : 0)"
          >
            <img
              class="
                w-6
                h-6
                rounded-full
                border-gray-200 border
                transform
                hover:scale-125
              "
              :src="getProfilePhoto(promoter)"
            />
          </inertia-link>
        </div>
        <span class="font-semibold">{{ promoter ? promoter.name : "" }}</span>
      </div>
    </td>

    <td class="py-3 px-6 text-center">
      {{ getPromotion(promotion) }}
    </td>
  </tr>
</template>

<script>
import UserServices from "@/Services/User";
var dayjs = require("dayjs");

export default {
  props: ["promotion"],

  data() {
    return {
      user: null,
      promoter: null,
    };
  },

  methods: {
    formatDate(date) {
      return dayjs(new Date(date)).format("MMM DD, YYYY hh:mm:ss a");
    },

    getPromotion(promotion) {
      if (promotion && promotion.promoted_to) {
        if (promotion.promoted_to == 2) return "Promoted to Moderator";
        if (promotion.promoted_to == 3) return "Demoted to Normal User";
      }
    },

    async getUser(id) {
      this.user = await UserServices.getUser(id);
    },

    async getPromoter(id) {
      this.promoter = await UserServices.getUser(id);
    },

    getProfilePhoto(user) {
      if (user) {
        if (user.profile_photo_path) {
          return "/storage/" + user.profile_photo_path;
        } else {
          return `https://ui-avatars.com/api/?name=${user.name}&color=059669&background=ECFDF5`;
        }
      }
    },
  },

  mounted() {
    this.getUser(this.promotion.user_id);
    this.getPromoter(this.promotion.promoted_by);
  },
};
</script>