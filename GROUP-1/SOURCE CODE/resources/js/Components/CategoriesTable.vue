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
                <th class="py-3 px-6 text-center" colspan="4">
                  List of Categories
                </th>
                <th
                  class="py-3 px-6 text-center text-green-500 cursor-pointer"
                  @click="showAddCategoryModal"
                >
                  Add a Category
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
                <th class="py-3 px-6 text-center">Category</th>
                <th class="py-3 px-6 text-center">Value</th>
                <th class="py-3 px-6 text-center">Created At</th>
                <th class="py-3 px-6 text-center">Updated At</th>
                <th class="py-3 px-6 text-center">Actions</th>
              </tr>
            </thead>
            <tbody
              class="text-gray-600 text-sm font-light"
              v-for="(category, i) in categories"
              :key="i"
            >
              <tr class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100">
                <td class="py-3 px-6 text-center">{{ category.name }}</td>
                <td class="py-3 px-6 text-center">{{ category.value }}</td>
                <td class="py-3 px-6 text-center">
                  {{ formatDate(category.created_at) }}
                </td>
                <td class="py-3 px-6 text-center">
                  {{ formatDate(category.updated_at) }}
                </td>
                <td class="py-3 px-6 text-center">
                  <div class="flex item-center justify-center">
                    <div
                      class="
                        w-4
                        mr-2
                        transform
                        hover:text-yellow-500 hover:scale-110
                      "
                      @click="showEditCategoryModal(category)"
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
                    <div
                      class="
                        w-4
                        mr-2
                        transform
                        hover:text-red-500 hover:scale-110
                      "
                      @click="showDeleteCategoryModal(category)"
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
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
var dayjs = require("dayjs");

export default {
  props: [
    "categories",
    "showDeleteCategoryModal",
    "showEditCategoryModal",
    "showAddCategoryModal",
  ],

  methods: {
    formatDate(date) {
      return dayjs(new Date(date)).format("MMM DD, YYYY hh:mm:ss a");
    },
  },
};
</script>