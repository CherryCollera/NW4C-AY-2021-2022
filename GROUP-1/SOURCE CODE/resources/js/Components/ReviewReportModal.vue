<template>
  <jet-dialog-modal :show="showing" @close="close">
    <template #title>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Review the report
      </h2>
    </template>

    <template #content>
      <div
        class="
          block
          bg-white
          shadow-md
          hover:shadow-xl
          rounded-lg
          cursor-pointer
        "
      >
        <vueper-slides
          :parallax="1"
          :parallax-fixed-content="false"
          fixed-height="20rem"
          :touchable="false"
        >
          <vueper-slide
            class="cursor-pointer"
            v-for="(image, index) in reportImages"
            :key="image.id"
            :image="image.image"
            @click.stop="
              $emit('show-lightbox', {
                index: index,
                images: reportImages,
              })
            "
          >
          </vueper-slide>
        </vueper-slides>

        <div class="p-4">
          <span
            v-if="reportData.is_resolved"
            class="
              inline-block
              px-2
              mx-1
              py-1
              leading-none
              bg-green-100
              text-green-900
              rounded-full
              font-semibold
              uppercase
              tracking-wide
              text-xs
            "
            >Resolved</span
          >
          <span
            v-else
            class="
              inline-block
              px-2
              mx-1
              py-1
              leading-none
              bg-red-100
              text-red-900
              rounded-full
              font-semibold
              uppercase
              tracking-wide
              text-xs
            "
            >Unresolved</span
          >
          <span
            class="
              inline-block
              px-2
              mx-1
              py-1
              leading-none
              bg-yellow-100
              text-yellow-900
              rounded-full
              font-semibold
              uppercase
              tracking-wide
              text-xs
            "
            >{{ getReportCategory(reportData.report_type) }}</span
          >

          <span
            class="
              inline-block
              px-2
              mx-1
              py-1
              leading-none
              bg-red-100
              text-red-900
              rounded-full
              font-semibold
              uppercase
              tracking-wide
              text-xs
            "
            >{{ getOffenseLevelEquivalent() }}</span
          >

          <!-- Report Description -->
          <p class="text-sm mt-3">{{ reportData.description }}</p>

          <!-- Time Reported | Edited -->
          <div class="mt-5 flex item-center text-gray-600">
            <span class="text-sm font-semibold">
              {{ getTimeAgo(reportData.created_at) }}
            </span>
          </div>

          <!-- Reported User -->
          <div class="mt-3 flex items-center">
            <span class="text-sm font-semibold">Reported User: </span
            >&nbsp;<span class="font-semibold">
              <inertia-link
                @click.stop=""
                :href="route('userProfile', reportedUser.id)"
                class="flex items-center"
              >
                <span>
                  <img
                    class="h-6 w-6 mr-2 rounded-full object-cover"
                    :src="getProfilePhoto(reportedUser)"
                    :alt="reportedUser.name"
                  />
                </span>
                {{ reportedUser.name }}
              </inertia-link>
            </span>
          </div>

          <!-- Reported By -->
          <div class="mt-1 flex items-center">
            <span class="text-sm font-semibold">Reported by: </span>&nbsp;<span
              class="font-semibold"
            >
              <inertia-link
                @click.stop=""
                :href="route('userProfile', reporterId)"
                class="flex items-center"
              >
                <span>
                  <img
                    class="h-6 w-6 mr-2 rounded-full object-cover"
                    :src="getProfilePhoto(reporter)"
                    :alt="reporterName"
                  />
                </span>
                {{ reporterName }}
              </inertia-link>
            </span>
          </div>

          <!-- Mod Assigned -->
          <div class="mt-1 flex items-center">
            <span class="text-sm font-semibold">Mod Assigned: </span>&nbsp;<span
              class="font-semibold"
            >
              <inertia-link
                @click.stop=""
                :href="route('userProfile', modData ? modData.id : 1)"
                class="flex items-center"
              >
                <span>
                  <img
                    v-if="modData && modData.id"
                    class="h-6 w-6 mr-2 rounded-full object-cover"
                    :src="getProfilePhoto(modData)"
                    :alt="modData ? modData.name : 'N/A'"
                  />
                </span>
                {{ modData && modData.id ? modData.name : "N/A" }}
              </inertia-link>
            </span>
          </div>

          <!-- Action Taken -->
          <div class="mt-1 flex items-center">
            <span class="text-sm font-semibold">Action Taken: </span>&nbsp;<span
              class="font-semibold"
            >
              {{ getActionTaken(reportData) }}
            </span>
          </div>

          <!-- Reported Post -->
          <div
            v-if="reportedPost && reportedPost.id"
            class="mt-7 flex items-center justify-center w-full"
          >
            <post-card
              class="flex items-center justify-center w-full"
              v-on:show-feedbacks="showFeedbacks"
              :id="reportedPost ? reportedPost.id : 1"
              :title="reportedPost ? reportedPost.title : ''"
              :description="reportedPost ? reportedPost.description : ''"
              :created_at="reportedPost ? reportedPost.created_at : ''"
              :updated_at="reportedPost ? reportedPost.updated_at : ''"
              :price="reportedPost ? reportedPost.est_price : 0"
              :views="reportedPost ? reportedPost.views : 0"
              :preferredItem="reportedPost ? reportedPost.preferred_prod : ''"
              :status="reportedPost ? reportedPost.status : ''"
              :userID="reportedPost ? reportedPost.user_id : 1"
              :showOffersModal="showOffersModal"
              :showReportModal="showReportModal"
              :prodName="reportedPost ? reportedPost.prod_name : ''"
              :qty="reportedPost ? reportedPost.prod_qty : 0"
              :qtyType="reportedPost ? reportedPost.qty_type : 0"
              :dateProduced="reportedPost ? reportedPost.date_produced : ''"
              :showDeletePostModal="showDeletePostModal"
              :dateExpiree="reportedPost ? reportedPost.date_expiree : ''"
              :category="reportedPost ? reportedPost.category : ''"
              :datePosted="reportedPost ? reportedPost.created_at : ''"
              :showEditPostModal="showEditPostModal"
              :addToCart="addToCart"
              :showLighbox="showLighbox"
              :categories="categories"
              :qtyTypes="qtyTypes"
              :enlarge="showEnlargeModal"
            />
          </div>
        </div>
      </div>
    </template>

    <template #footer>
      <!-- Cancel Button -->
      <jet-secondary-button @click="close"> Cancel </jet-secondary-button>

      <!-- Absolve Button -->
      <jet-button class="ml-2" v-if="!reportData.is_resolved" @click="absolve">
        Absolve
      </jet-button>

      <!-- Warning Button -->
      <warning-button class="ml-2" v-if="!reportData.is_resolved" @click="warn">
        Warn
      </warning-button>

      <!-- Ban Button -->
      <danger-button
        class="ml-2"
        v-if="!reportData.is_resolved"
        @click="showConfirmBan"
      >
        {{ reportData.reported_post_id ? "Delete" : "Ban" }}
      </danger-button>
    </template>
  </jet-dialog-modal>

  <!-- Ban User Modal -->
  <confirmation-modal :show="showingConfirmBan" class="z-50">
    <template #title>
      <h2>Ban User</h2>
    </template>

    <template #content>
      <p>Are you sure you want to ban this user?</p>
    </template>

    <template #footer>
      <jet-secondary-button @click="closeConfirmBan">
        Cancel
      </jet-secondary-button>

      <danger-button
        class="ml-2"
        @click="ban()"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Ban
      </danger-button>
    </template>
  </confirmation-modal>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal";
import JetButton from "@/Jetstream/Button";
import DangerButton from "@/Jetstream/DangerButton";
import WarningButton from "@/Jetstream/WarningButton";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import { VueperSlides, VueperSlide } from "vueperslides";
import "vueperslides/dist/vueperslides.css";
import ReportImageServices from "@/Services/ReportImage";
import UserServices from "@/Services/User";
import PostServices from "@/Services/Post";
import DateHelpers from "@utils/date-helpers";
import PostCard from "@/Components/PostCard";
import ConfirmationModal from "@/Jetstream/ConfirmationModal";

export default {
  components: {
    JetDialogModal,
    JetButton,
    JetSecondaryButton,
    VueperSlides,
    VueperSlide,
    PostCard,
    DangerButton,
    ConfirmationModal,
    WarningButton,
  },

  props: ["showing", "close", "data"],

  emits: ["show-lightbox"],

  data() {
    return {
      showingConfirmBan: false,
      reportImages: null,
      reporter: null,
      reportedPost: null,
      offenseLevel: null,
      form: this.$inertia.form({
        report: null,
      }),
    };
  },

  computed: {
    modData() {
      if (this.data.user.modData) {
        return this.data.user.modData;
      }
    },

    reportData() {
      return this.data.report;
    },
    reportedUser() {
      if (this.data) {
        return this.data.user.user;
      }
    },
    reporterName() {
      if (this.reporter) return this.reporter.name;
      else return "Anonymous User";
    },
    reporterId() {
      if (this.reporter) return this.reporter.id;
      else return 0;
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

    nth(d) {
      if (d > 3 && d < 21) return "th";
      switch (d % 10) {
        case 1:
          return "st";
        case 2:
          return "nd";
        case 3:
          return "rd";
        default:
          return "th";
      }
    },

    getOffenseLevelEquivalent() {
      if (this.offenseLevel) {
        const index =
          this.offenseLevel.map((e) => e.id).indexOf(this.reportData.id) + 1;

        return `${index}${this.nth(index)} Offense`;
      }
    },

    showConfirmBan() {
      this.showingConfirmBan = true;
    },

    closeConfirmBan() {
      this.showingConfirmBan = false;
    },

    warn() {
      this.form.report = this.reportData;

      this.form.post("/report/warn", {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.close();
        },
        onFinish: () => this.form.reset(),
      });
    },

    ban() {
      this.form.report = this.reportData;

      this.form.post("/report/ban", {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.close();
        },
        onFinish: () => {
          this.form.reset();
          this.closeConfirmBan();
        },
      });
    },

    absolve() {
      this.form.report = this.reportData;

      this.form.post("/report/absolve", {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.close();
        },
        onFinish: () => this.form.reset(),
      });
    },

    getTimeAgo(date) {
      return DateHelpers.getTimeAgo(date);
    },

    async getReportImages() {
      if (this.reportData) {
        const reportImages = await ReportImageServices.get(this.reportData.id);

        if (reportImages.length === 0) {
          this.reportImages = [
            {
              id: 1,
              image: "/img/noimage.svg",
            },
          ];
        } else {
          this.reportImages = reportImages.map((image) => {
            return {
              id: image.id,
              image: `/storage/${image.report_image_file_path}`,
            };
          });
        }
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

    async getReporter(id) {
      if (id !== null) {
        this.reporter = await UserServices.getUser(id);
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

    async getPost(postID) {
      this.reportedPost = await PostServices.getPost(postID);
    },

    async getOffenseLevel(userID) {
      this.offenseLevel = await UserServices.getOffenseLevel(userID);
    },
  },

  beforeUpdate() {
    if (this.showing) {
      this.getReportImages();

      this.getReporter(this.reportData.user_id);

      this.getPost(this.reportData.reported_post_id);

      this.getOffenseLevel(this.reportData.reported_user_id);
    }
  },
};
</script>