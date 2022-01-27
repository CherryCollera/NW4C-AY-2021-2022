<template>
  <div class="overflow-x-auto">
    <div
      class="
        my-20
        bg-gray-100
        flex
        items-center
        justify-center
        bg-gray-100
        font-sans
        overflow-hidden
      "
    >
      <div class="w-full lg:w-5/6 sm:w-5/6">
        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
          <table class="min-w-max w-full table-auto">
            <thead>
              <!-- Table Title Row -->
              <tr
                class="
                  bg-gray-300
                  text-gray-700
                  uppercase
                  text-sm
                  leading-normal
                "
              >
                <th class="py-3 px-6 text-center" colspan="3">
                  List of Moderators
                </th>
                <th
                  class="py-3 px-6 text-center text-green-500 cursor-pointer"
                  @click="showAddModerator()"
                >
                  Promote/Demote
                </th>
              </tr>

              <!-- Table Headings -->
              <tr
                class="
                  bg-gray-200
                  text-gray-600
                  uppercase
                  text-sm
                  leading-normal
                "
              >
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Date promoted</th>
                <th class="py-3 px-6 text-left">Promoted by</th>
              </tr>
            </thead>

            <!-- Table Body -->
            <tbody
              class="text-gray-600 text-sm font-light"
              v-for="(moderator, i) in moderators"
              :key="i"
            >
              <moderators-table-row :moderator="moderator" />
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ModeratorsTableRow from "@/Components/ModeratorsTableRow";
var dayjs = require("dayjs");

export default {
  props: ["moderators", "showAddModerator"],

  components: {
    ModeratorsTableRow,
  },

  methods: {
    formatDate(date) {
      return dayjs(new Date(date)).format("MMM DD, YYYY hh:mm:ss a");
    },

    getProfilePhoto(user) {
      if (user) {
        if (user.profile_photo_path) {
          return "/storage/" + photo;
        } else {
          return `https://ui-avatars.com/api/?name=${user.name}&color=059669&background=ECFDF5`;
        }
      }
    },
  },
};
</script>