<template>
  <tr
    @click="$emit('show-review-report', { user: user, modData: modData })"
    class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100 cursor-pointer"
  >
    <!-- Report ID -->
    <td class="py-3 px-6 text-left">{{ report.id }}</td>

    <!-- Reported User Name -->
    <td class="py-3 px-6 text-center">
      <div class="flex items-center">
        <div class="mr-2">
          <inertia-link
            @click.stop=""
            :href="route('userProfile', report.reported_user_id)"
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

    <!-- Report Category -->
    <td class="py-3 px-6 text-left">
      {{ getReportCategory(report.report_type) }}
    </td>

    <!-- Mod Assigned -->
    <td class="py-3 px-6 text-left">
      <div class="flex items-center">
        <div class="mr-2">
          <inertia-link
            @click.stop=""
            :href="route('userProfile', modData ? modData.id : 1)"
          >
            <img
              v-if="modData && modData.id"
              class="
                w-6
                h-6
                rounded-full
                border-gray-200 border
                transform
                hover:scale-125
              "
              :src="getProfilePhoto(modData)"
            />
          </inertia-link>
        </div>
        <span class="font-semibold">{{
          modData && modData.id ? modData.name : "N/A"
        }}</span>
      </div>
    </td>

    <!-- Action Taken -->
    <td class="py-3 px-6 text-left">
      <span
        class="py-1 px-3 rounded-full text-xs"
        :class="getActionTakenClass(report.action_taken)"
        >{{ getActionTaken(report) }}</span
      >
    </td>

    <!-- Report Status -->
    <td class="py-3 px-6 text-left">
      <span
        class="py-1 px-3 rounded-full text-xs"
        :class="getStatusClass(report.is_resolved)"
        >{{ getReportStatus(report.is_resolved) }}</span
      >
    </td>
  </tr>
</template>

<script>
import UserServices from "@/Services/User";

export default {
  props: ["report"],

  data() {
    return {
      user: null,
      modData: null,
    };
  },

  computed: {
    modAssigned() {
      if (this.modData) {
        return this.modData;
      } else {
        return "N/A";
      }
    },
  },

  methods: {
    getActionTaken(report) {
      if (report && report.action_taken) {
        if (report.reported_post_id && report.action_taken == "Banned") {
          return "Post Deleted";
        } else {
          return report.action_taken;
        }
      } else {
        return "N/A";
      }
    },

    getReportStatus(status) {
      if (status) return "Resolved";
      else return "Unresolved";
    },

    getStatusClass(status) {
      if (status) return "text-green-600 bg-green-200";
      else return "text-red-600 bg-red-200";
    },

    getActionTakenClass(action) {
      if (action) {
        switch (action) {
          case "Banned":
            return "text-red-600 bg-red-200";

          case "Warned":
            return "text-yellow-600 bg-yellow-200";

          case "Absolved":
            return "text-green-600 bg-green-200";

          default:
            return "text-gray-600 bg-gray-200";
            break;
        }
      } else {
        return "text-gray-600 bg-gray-200";
      }
    },

    getReportCategory(type) {
      switch (type) {
        case "categ-1":
          return "Offensive Language";
        case "categ-2":
          return "Harassment";
        case "categ-3":
          return "Sexually Explicit Contents";
        case "categ-4":
          return "Fraud";
        case "categ-5":
          return "Inappropriate Contents";
        default:
          return "Unknown";
      }
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

    async getUser(id) {
      if (id !== null) {
        this.user = await UserServices.getUser(id);
      }
    },

    async getMod(report) {
      if (report && report.mod_assigned) {
        this.modData = await UserServices.getUser(report.mod_assigned);
      } else {
        this.modData = "N/A";
      }
    },
  },

  mounted() {
    this.getUser(this.report.reported_user_id);
    this.getMod(this.report);
  },
};
</script>