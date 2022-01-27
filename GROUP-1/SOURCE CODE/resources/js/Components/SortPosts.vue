<template>
  <dropdown align="left" width="250">
    <template #trigger>
      <button
        class="
          flex
          mt-10
          mx-auto
          p-2
          transition-colors
          duration-200
          transform
          bg-gray-300
          rounded-md
          hover:bg-green-500
          focus:outline-none focus:bg-green-300
        "
      >
        <svg
          viewBox="0 0 24 24"
          preserveAspectRatio="xMidYMid meet"
          class="w-5 h-5 mr-1"
        >
          <g class="">
            <path d="M0 0h24v24H0z" fill="none" class=""></path>
            <path
              d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"
              class=""
            ></path>
          </g>
        </svg>
        Filter
      </button>
    </template>

    <template #content>
      <div class="container mx-auto">
        <div class="flex flex-col mx-4 px-8 py-6">
          <div class="flex justify-center text-sm text-gray-700 sm:flex-row">
            <div class="w-1/5 mr-10">
              <h3
                class="pb-2 border-b mb-3 text-md text-gray-900 font-semibold"
              >
                Location
              </h3>
              <div class="flex flex-col">
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'balanga',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('balanga')"
                    class="flex-1"
                    >Balanga</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'pilar',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('pilar')"
                    class="flex-1"
                    >Pilar</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'abucay',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('abucay')"
                    class="flex-1"
                    >Abucay</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'bagac',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('bagac')"
                    class="flex-1"
                    >Bagac</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'morong',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('morong')"
                    class="flex-1"
                    >Morong</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'dinalupihan',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('dinalupihan')"
                    class="flex-1"
                    >Dinalupihan</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'orani',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('orani')"
                    class="flex-1"
                    >Orani</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'hermosa',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('hermosa')"
                    class="flex-1"
                    >Hermosa</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'mariveles',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('mariveles')"
                    class="flex-1"
                    >Mariveles</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'limay',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('limay')"
                    class="flex-1"
                    >Limay</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'orion',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('orion')"
                    class="flex-1"
                    >Orion</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: 'samal',
                        price: route().params.price,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                      })
                    "
                    :active="isLocationFilterActive('samal')"
                    class="flex-1"
                    >Samal</jet-nav-link
                  >
                </div>
              </div>
            </div>
            <div class="w-28 mr-10">
              <h3
                class="pb-2 border-b mb-3 text-md text-gray-900 font-semibold"
              >
                Date Produced
              </h3>
              <div class="flex flex-col">
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        hideOwnPost: route().params.hideOwnPost,
                        expiredDate: route().params.expiredDate,
                        producedDate: 'month',
                      })
                    "
                    :active="isDateProducedFilterActive('month')"
                    class="flex-1"
                    >This month</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        hideOwnPost: route().params.hideOwnPost,
                        expiredDate: route().params.expiredDate,
                        producedDate: 'week',
                      })
                    "
                    :active="isDateProducedFilterActive('week')"
                    class="flex-1"
                    >This week</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        hideOwnPost: route().params.hideOwnPost,
                        expiredDate: route().params.expiredDate,
                        producedDate: 'today',
                      })
                    "
                    :active="isDateProducedFilterActive('today')"
                    class="flex-1"
                    >Today</jet-nav-link
                  >
                </div>
              </div>
            </div>
            <div class="w-28 mr-10">
              <h3
                class="pb-2 border-b mb-3 text-md text-gray-900 font-semibold"
              >
                Date Expired
              </h3>
              <div class="flex flex-col">
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        hideOwnPost: route().params.hideOwnPost,
                        producedDate: route().params.producedDate,
                        expiredDate: 'month',
                      })
                    "
                    :active="isDateExpiredFilterActive('month')"
                    class="flex-1"
                    >This month</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        hideOwnPost: route().params.hideOwnPost,
                        producedDate: route().params.producedDate,
                        expiredDate: 'week',
                      })
                    "
                    :active="isDateExpiredFilterActive('week')"
                    class="flex-1"
                    >This week</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        hideOwnPost: route().params.hideOwnPost,
                        producedDate: route().params.producedDate,
                        expiredDate: 'today',
                      })
                    "
                    :active="isDateExpiredFilterActive('today')"
                    class="flex-1"
                    >Today</jet-nav-link
                  >
                </div>
              </div>
            </div>
            <div class="w-28 mr-10">
              <h3
                class="pb-2 border-b mb-3 text-md text-gray-900 font-semibold"
              >
                Hide Own Post
              </h3>
              <div class="flex flex-col">
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: 'yes',
                      })
                    "
                    :active="isHideOwnPostFilterActive('yes')"
                    class="flex-1"
                    >Hide</jet-nav-link
                  >
                </div>
              </div>
            </div>
            <div class="w-28 mr-10">
              <h3
                class="pb-2 border-b mb-3 text-md text-gray-900 font-semibold"
              >
                Status
              </h3>
              <div class="flex flex-col">
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                        status: 'available',
                      })
                    "
                    :active="isStatusFilterActive('available')"
                    class="flex-1"
                    >Available</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                        status: 'negotiating',
                      })
                    "
                    :active="isStatusFilterActive('negotiating')"
                    class="flex-1"
                    >Negotiating</jet-nav-link
                  >
                </div>
                <div class="flex py-2">
                  <jet-nav-link
                    :href="
                      route('dashboard', {
                        category: route().params.category,
                        location: route().params.location,
                        price: route().params.price,
                        price2: route().params.price2,
                        producedDate: route().params.producedDate,
                        expiredDate: route().params.expiredDate,
                        hideOwnPost: route().params.hideOwnPost,
                        status: 'sold',
                      })
                    "
                    :active="isStatusFilterActive('sold')"
                    class="flex-1"
                    >Traded</jet-nav-link
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="flex mt-5">
            <inertia-link
              :href="clearFilter()"
              class="text-gray-700 font-normal text-sm hover:underline"
              >Clear Filter</inertia-link
            >
          </div>
        </div>
      </div>
    </template>
  </dropdown>
</template>

<script>
import Dropdown from "@/Jetstream/Dropdown";
import DropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";

export default {
  components: {
    Dropdown,
    DropdownLink,
    JetNavLink,
  },

  methods: {
    isStatusFilterActive(url) {
      if (url === route().params.status) return true;

      return false;
    },

    isDateExpiredFilterActive(url) {
      if (url === route().params.expiredDate) return true;

      return false;
    },

    isDateProducedFilterActive(url) {
      if (url === route().params.producedDate) return true;

      return false;
    },

    isLocationFilterActive(url) {
      if (url === route().params.location) return true;

      return false;
    },

    isPriceFilterActive(url) {
      if (url === route().params.price) return true;

      return false;
    },

    isHideOwnPostFilterActive(url) {
      if (url === route().params.hideOwnPost) return true;

      return false;
    },

    clearFilter() {
      return route().params.category
        ? route("dashboard", route().params.category)
        : route("dashboard");
    },
  },
};
</script>