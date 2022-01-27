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
                <th class="py-3 px-6 text-center" colspan="5">
                  History of Promotions
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
                <th class="py-3 px-6 text-center">ID</th>
                <th class="py-3 px-6 text-center">Name</th>
                <th class="py-3 px-6 text-center">Created At</th>
                <th class="py-3 px-6 text-center">Promoted By</th>
                <th class="py-3 px-6 text-center">Promoted/Demoted</th>
              </tr>
            </thead>
            <tbody
              class="text-gray-600 text-sm font-light"
              v-for="(promotion, i) in promotions"
              :key="i"
            >
              <promotion-table-row :promotion="promotion" />
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PromotionTableRow from "@/Components/PromotionTableRow";
export default {
  props: ["promotions"],

  components: {
    PromotionTableRow,
  },
};
</script>