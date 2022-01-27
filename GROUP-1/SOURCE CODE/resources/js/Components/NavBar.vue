<template>
  <nav class="p-4 bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <div class="flex-shrink-0 flex items-center">
            <inertia-link
              :href="route('dashboard')"
              class="
                flex
                title-font
                font-medium
                items-center
                md:justify-start
                justify-center
                text-gray-900
              "
            >
              <img
                src="/img/logo1.webp"
                alt=""
                class="w-10 h-10 text-white p-2 rounded-full"
              />
              <span class="text-gray-600 ml-3 text-xl">E-Barter</span>
            </inertia-link>
          </div>

          <!-- Search input on desktop screen -->
          <div
            v-if="route().current('dashboard')"
            class="hidden sm:flex sm:items-center sm:ml-6"
          >
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg
                  class="w-5 h-5 text-gray-400"
                  viewBox="0 0 24 24"
                  fill="none"
                >
                  <path
                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </span>

              <jet-input
                type="text"
                class="
                  mt-1
                  block
                  w-full
                  py-2
                  pl-10
                  pr-4
                  text-gray-700
                  bg-white
                  border border-gray-300
                  rounded-md
                  focus:border-green-500 focus:outline-none focus:ring-0
                "
                placeholder="Search for a product..."
                id="searchKeyword"
                ref="searchKeyword"
                v-model="form.searchKeyword"
                @keyup.enter="search"
              />
            </div>
          </div>
        </div>

        <div class="hidden md:flex md:items-center md:ml-6">
          <!-- Navigation Links -->
          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <!-- Home -->
            <jet-nav-link
              :href="route('dashboard')"
              :active="route().current('dashboard')"
            >
              Home
            </jet-nav-link>

            <!-- Messages -->
            <jet-nav-link
              :href="route('messages')"
              :active="route().current('messages')"
            >
              Messages
            </jet-nav-link>

            <!-- Cart -->
            <jet-nav-link
              :href="route('cart')"
              :active="route().current('cart')"
            >
              Cart
            </jet-nav-link>
          </div>

          <div class="ml-3 relative">
            <!-- Teams Dropdown -->
            <jet-dropdown
              align="right"
              width="60"
              v-if="$page.props.jetstream.hasTeamFeatures"
            >
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="
                      inline-flex
                      items-center
                      px-3
                      py-2
                      border border-transparent
                      text-sm
                      leading-4
                      font-medium
                      rounded-md
                      text-gray-500
                      bg-white
                      hover:bg-gray-50 hover:text-gray-700
                      focus:outline-none focus:bg-gray-50
                      active:bg-gray-50
                      transition
                    "
                  >
                    {{ $page.props.user.current_team.name }}

                    <svg
                      class="ml-2 -mr-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <div class="w-60">
                  <!-- Team Management -->
                  <template v-if="$page.props.jetstream.hasTeamFeatures">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Manage Team
                    </div>

                    <!-- Team Settings -->
                    <jet-dropdown-link
                      :href="route('teams.show', $page.props.user.current_team)"
                    >
                      Team Settings
                    </jet-dropdown-link>

                    <jet-dropdown-link
                      :href="route('teams.create')"
                      v-if="$page.props.jetstream.canCreateTeams"
                    >
                      Create New Team
                    </jet-dropdown-link>

                    <div class="border-t border-gray-100"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Switch Teams
                    </div>

                    <template
                      v-for="team in $page.props.user.all_teams"
                      :key="team.id"
                    >
                      <form @submit.prevent="switchToTeam(team)">
                        <jet-dropdown-link as="button">
                          <div class="flex items-center">
                            <svg
                              v-if="team.id == $page.props.user.current_team_id"
                              class="mr-2 h-5 w-5 text-green-400"
                              fill="none"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              stroke="currentColor"
                              viewBox="0 0 24 24"
                            >
                              <path
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                              ></path>
                            </svg>
                            <div>{{ team.name }}</div>
                          </div>
                        </jet-dropdown-link>
                      </form>
                    </template>
                  </template>
                </div>
              </template>
            </jet-dropdown>
          </div>

          <!-- Settings Dropdown -->
          <div class="ml-3 relative">
            <jet-dropdown align="right" width="48">
              <template #trigger>
                <button
                  v-if="$page.props.jetstream.managesProfilePhotos"
                  class="
                    flex
                    text-sm
                    border-2 border-transparent
                    rounded-full
                    focus:outline-none focus:border-gray-300
                    transition
                  "
                >
                  <img
                    class="h-8 w-8 rounded-full object-cover"
                    :src="getProfilePhoto($page.props.authUser)"
                    :alt="$page.props.user.name"
                  />
                </button>

                <span v-else class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="
                      inline-flex
                      items-center
                      px-3
                      py-2
                      border border-transparent
                      text-sm
                      leading-4
                      font-medium
                      rounded-md
                      text-gray-500
                      bg-white
                      hover:text-gray-700
                      focus:outline-none
                      transition
                    "
                  >
                    {{ $page.props.user.name }}

                    <svg
                      class="ml-2 -mr-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Account
                </div>

                <jet-dropdown-link
                  :href="route('userProfile', $page.props.user.id)"
                >
                  Profile
                </jet-dropdown-link>

                <jet-dropdown-link :href="route('profile.show')">
                  Account Settings
                </jet-dropdown-link>

                <jet-dropdown-link
                  :href="route('api-tokens.index')"
                  v-if="$page.props.jetstream.hasApiFeatures"
                >
                  API Tokens
                </jet-dropdown-link>

                <!-- Trading Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Trading
                </div>

                <jet-dropdown-link :href="route('transactionHistory')">
                  Transaction History
                </jet-dropdown-link>

                <jet-dropdown-link :href="route('offersMade')">
                  Offers Made
                </jet-dropdown-link>

                <!-- Divider -->
                <div class="border-t border-gray-100"></div>

                <!-- Admin Management -->
                <div>
                  <div
                    v-if="$page.props.user.access_level === 1"
                    class="block px-4 py-2 text-xs text-gray-400"
                  >
                    Admin Management
                  </div>

                  <jet-dropdown-link
                    v-if="$page.props.user.access_level === 1"
                    :href="route('modifyTypes')"
                  >
                    Modify Types
                  </jet-dropdown-link>

                  <jet-dropdown-link
                    v-if="
                      $page.props.user.access_level === 1 ||
                      $page.props.user.access_level === 2
                    "
                    :href="route('viewReports')"
                  >
                    View Reports
                  </jet-dropdown-link>

                  <jet-dropdown-link
                    v-if="$page.props.user.access_level === 1"
                    :href="route('viewModerators')"
                  >
                    View Moderators
                  </jet-dropdown-link>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100"></div>

                <!-- Log out -->
                <form @submit.prevent="logout">
                  <jet-dropdown-link as="button"> Log Out </jet-dropdown-link>
                </form>
              </template>
            </jet-dropdown>
          </div>
        </div>

        <!-- Hamburger -->
        <div class="-mr-2 flex items-center md:hidden">
          <button
            @click="showingNavigationDropdown = !showingNavigationDropdown"
            class="
              inline-flex
              items-center
              justify-center
              p-2
              rounded-md
              text-gray-400
              hover:text-gray-500 hover:bg-gray-100
              focus:outline-none focus:bg-gray-100 focus:text-gray-500
              transition
            "
          >
            <svg
              class="h-6 w-6"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                :class="{
                  hidden: showingNavigationDropdown,
                  'inline-flex': !showingNavigationDropdown,
                }"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
              <path
                :class="{
                  hidden: !showingNavigationDropdown,
                  'inline-flex': showingNavigationDropdown,
                }"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
      :class="{
        block: showingNavigationDropdown,
        hidden: !showingNavigationDropdown,
      }"
      class="md:hidden"
    >
      <div class="pt-2 pb-3 space-y-1">
        <div v-if="route().current('dashboard')" class="relative mb-5">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
              <path
                d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              ></path>
            </svg>
          </span>

          <jet-input
            type="text"
            class="
              mt-1
              block
              w-full
              py-2
              pl-10
              pr-4
              text-gray-700
              bg-white
              border border-gray-300
              rounded-md
              focus:border-green-500 focus:outline-none focus:ring-0
            "
            placeholder="Search for a product..."
            id="searchKeywordResponsive"
            ref="searchKeywordResponsive"
            v-model="form.searchKeyword"
            @keyup.enter="search"
          />
        </div>

        <jet-responsive-nav-link
          :href="route('dashboard')"
          :active="route().current('dashboard')"
        >
          Home
        </jet-responsive-nav-link>

        <jet-responsive-nav-link
          :href="route('messages')"
          :active="route().current('messages')"
        >
          Messages
        </jet-responsive-nav-link>

        <jet-responsive-nav-link
          :href="route('cart')"
          :active="route().current('cart')"
        >
          Cart
        </jet-responsive-nav-link>
      </div>

      <!-- Responsive Settings Options -->
      <div class="pt-4 pb-1 border-t border-gray-200">
        <div class="flex items-center px-4">
          <div
            v-if="$page.props.jetstream.managesProfilePhotos"
            class="flex-shrink-0 mr-3"
          >
            <img
              class="h-8 w-8 rounded-full object-cover"
              :src="getProfilePhoto($page.props.authUser)"
              :alt="$page.props.user.name"
            />
          </div>

          <div>
            <div class="font-medium text-base text-gray-800">
              {{ $page.props.user.name }}
            </div>
            <div class="font-medium text-sm text-gray-500">
              {{ $page.props.user.email }}
            </div>
          </div>
        </div>

        <div class="mt-3 space-y-1">
          <jet-responsive-nav-link
            :href="route('userProfile', $page.props.user.id)"
            :active="route().current('userProfile', $page.props.user.id)"
          >
            Profile
          </jet-responsive-nav-link>

          <jet-responsive-nav-link
            :href="route('api-tokens.index')"
            :active="route().current('api-tokens.index')"
            v-if="$page.props.jetstream.hasApiFeatures"
          >
            API Tokens
          </jet-responsive-nav-link>

          <jet-responsive-nav-link
            :href="route('profile.show')"
            :active="route().current('profile.show')"
          >
            Account Settings
          </jet-responsive-nav-link>

          <jet-responsive-nav-link
            :href="route('transactionHistory')"
            :active="route().current('transaction')"
          >
            Transaction History
          </jet-responsive-nav-link>

          <jet-responsive-nav-link
            :href="route('offersMade')"
            :active="route().current('offersMade')"
          >
            Offers Made
          </jet-responsive-nav-link>

          <jet-responsive-nav-link
            :href="route('modifyTypes')"
            :active="route().current('modifyTypes')"
          >
            Modify Types
          </jet-responsive-nav-link>

          <jet-responsive-nav-link
            :href="route('offersMade')"
            :active="route().current('offersMade')"
          >
            View Reports
          </jet-responsive-nav-link>

          <jet-responsive-nav-link
            :href="route('viewModerators')"
            :active="route().current('viewModerators')"
          >
            View Moderators
          </jet-responsive-nav-link>

          <!-- Authentication -->
          <form method="POST" @submit.prevent="logout">
            <jet-responsive-nav-link as="button">
              Log Out
            </jet-responsive-nav-link>
          </form>

          <!-- Team Management -->
          <template v-if="$page.props.jetstream.hasTeamFeatures">
            <div class="border-t border-gray-200"></div>

            <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>

            <!-- Team Settings -->
            <jet-responsive-nav-link
              :href="route('teams.show', $page.props.user.current_team)"
              :active="route().current('teams.show')"
            >
              Team Settings
            </jet-responsive-nav-link>

            <jet-responsive-nav-link
              :href="route('teams.create')"
              :active="route().current('teams.create')"
              v-if="$page.props.jetstream.canCreateTeams"
            >
              Create New Team
            </jet-responsive-nav-link>

            <div class="border-t border-gray-200"></div>

            <!-- Team Switcher -->
            <div class="block px-4 py-2 text-xs text-gray-400">
              Switch Teams
            </div>

            <template v-for="team in $page.props.user.all_teams" :key="team.id">
              <form @submit.prevent="switchToTeam(team)">
                <jet-responsive-nav-link as="button">
                  <div class="flex items-center">
                    <svg
                      v-if="team.id == $page.props.user.current_team_id"
                      class="mr-2 h-5 w-5 text-green-400"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                      ></path>
                    </svg>
                    <div>{{ team.name }}</div>
                  </div>
                </jet-responsive-nav-link>
              </form>
            </template>
          </template>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import JetInput from "@/Jetstream/Input";

export default {
  components: {
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    JetInput,
  },

  data() {
    return {
      authUser: {},
      showingNavigationDropdown: false,
      form: this.$inertia.form({
        searchKeyword: null,
      }),
    };
  },

  methods: {
    search() {
      this.form.get(route("dashboard"), {
        preserveScroll: false,
        onSuccess: () => this.form.reset(),
        onError: (error) => console.log(error),
        onFinish: () => this.form.reset(),
      });
    },

    getProfilePhoto(user) {
      if (user.profile_photo_path) {
        return "/storage/" + user.profile_photo_path;
      } else {
        return `https://ui-avatars.com/api/?name=${user.name}&color=059669&background=ECFDF5`;
      }
    },

    switchToTeam(team) {
      this.$inertia.put(
        route("current-team.update"),
        {
          team_id: team.id,
        },
        {
          preserveState: false,
        }
      );
    },

    logout() {
      this.$inertia.post(route("logout"));
    },
  },
};
</script>