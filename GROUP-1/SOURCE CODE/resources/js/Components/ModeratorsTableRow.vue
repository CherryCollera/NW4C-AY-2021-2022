<template>
  <tr
    @click="$emit('show-review-report', { moderator })"
    class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100 cursor-pointer"
  >
    <!-- Mod User ID -->
    <td class="py-3 px-6 text-left">{{ moderator.id }}</td>

    <!-- Mod Name -->
    <td class="py-3 px-6 text-center">
      <div class="flex items-center">
        <div class="mr-2">
          <inertia-link
            @click.stop=""
            :href="route('userProfile', moderator.id)"
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
              :src="getProfilePhoto(moderator)"
            />
          </inertia-link>
        </div>
        <span class="font-semibold">{{ moderator ? moderator.name : "" }}</span>
      </div>
    </td>

    <!-- Mod Date Promoted -->
    <td class="py-3 px-6 text-left">
      {{ promotion ? formatDate(promotion.created_at) : "N/A" }}
    </td>

    <!-- Promoted By -->
    <td class="py-3 px-6 text-left">
      <div class="flex items-center">
        <div class="mr-2">
          <inertia-link
            @click.stop=""
            :href="route('userProfile', promoter ? promoter.id : 1)"
          >
            <img
              v-if="promoter && promoter.id"
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
        <span class="font-semibold">{{
          promoter && promoter.id ? promoter.name : "N/A"
        }}</span>
      </div>
    </td>
  </tr>
</template>

<script>
import UserServices from "@/Services/User";
var dayjs = require("dayjs");

export default {
  props: ["moderator"],

  data() {
    return {
      promoter: null,
      promotion: null,
    };
  },

  computed: {},

  methods: {
    formatDate(date) {
      return dayjs(new Date(date)).format("MMM DD, YYYY | hh:mm:ss a");
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

    async getPromotion(id) {
      this.promotion = await UserServices.getPromotion(id);

      this.promoter = await UserServices.getUser(this.promotion.promoted_by);
    },
  },

  mounted() {
    // get promotion info
    this.getPromotion(this.moderator.id);
  },
};
</script>