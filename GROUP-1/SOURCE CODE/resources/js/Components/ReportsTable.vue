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
              <tr
                class="
                  bg-gray-300
                  text-gray-700
                  uppercase
                  text-sm
                  leading-normal
                "
              >
                <th class="py-3 px-6 text-center" colspan="6">
                  List of User Reports
                </th>
              </tr>
              <tr
                class="
                  bg-gray-200
                  text-gray-600
                  uppercase
                  text-sm
                  leading-normal
                "
              >
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Type</th>
                <th class="py-3 px-6 text-left">Assigned</th>
                <th class="py-3 px-6 text-left">Action</th>
                <th class="py-3 px-6 text-left">Status</th>
              </tr>
            </thead>
            <tbody
              class="text-gray-600 text-sm font-light"
              v-for="(report, i) in reports"
              :key="i"
            >
              <reports-table-row
                v-on:show-review-report="
                  (user, modData) =>
                    $emit('show-review-report', {
                      user: user,
                      report: report,
                    })
                "
                :report="report"
              />
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ReportsTableRow from "@/Components/ReportsTableRow";

export default {
  props: ["reports"],

  components: {
    ReportsTableRow,
  },

  methods: {
    showReviewReportModal(user) {
      this.$emit("show-review-report", {
        user: user,
        report: report,
      });
    },
  },
};
</script>