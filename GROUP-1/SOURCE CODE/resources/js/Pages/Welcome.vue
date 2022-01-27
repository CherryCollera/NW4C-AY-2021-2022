<template>
  <div class="relative overflow-hidden h-screen">
    <img
      src="/img/landing_nologo.webp"
      class="absolute h-full w-full object-cover"
    />

    <div class="inset-0 absolute"></div>

    <header class="absolute top-0 left-0 right-0 z-20">
      <nav class="container mx-auto px-6 md:px-12 py-4">
        <div class="md:flex justify-center items-center">
          <div class="flex justify-between items-center">
            <dropdown align="left" width="48">
              <template #trigger>
                <div class="md:hidden">
                  <button class="text-gray-500 focus:outline-none">
                    <svg
                      class="h-12 w-12"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M4 6H20M4 12H20M4 18H20"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      ></path>
                    </svg>
                  </button>
                </div>
              </template>

              <template #content>
                <dropdown-link
                  v-if="$page.props.user"
                  :href="route('dashboard')"
                >
                  Home
                </dropdown-link>

                <template v-else>
                  <dropdown-link :href="route('login')"> Login </dropdown-link>

                  <dropdown-link :href="route('register')">
                    Register
                  </dropdown-link>
                </template>
              </template>
            </dropdown>
          </div>
          <div class="hidden md:flex items-center">
            <div
              v-if="canLogin"
              class="
                hidden
                fixed
                top-0
                right-0
                px-6
                py-4
                w-1/2
                text-right
                bg-gradient-to-r
                from-transparent
                to-black
                sm:block
                opacity-50
              "
            >
              <inertia-link
                v-if="$page.props.user"
                href="/dashboard"
                class="
                  text-lg
                  uppercase
                  mx-3
                  text-white
                  cursor-pointer
                  hover:text-gray-300
                "
              >
                Home
              </inertia-link>

              <template v-else>
                <inertia-link
                  :href="route('login')"
                  class="
                    text-lg
                    uppercase
                    mx-3
                    text-white
                    cursor-pointer
                    hover:text-gray-300
                    mrws
                  "
                >
                  Log in
                </inertia-link>

                <inertia-link
                  v-if="canRegister"
                  :href="route('register')"
                  class="
                    text-lg
                    uppercase
                    mx-3
                    text-white
                    cursor-pointer
                    hover:text-gray-300
                    mrws
                  "
                >
                  Register
                </inertia-link>
              </template>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <!-- Landing Page Hero Section -->
    <div
      class="
        container
        mx-auto
        relative
        z-10
        px-6
        md:px-12
        flex
        items-center
        py-32
        xl:py-40
      "
    >
      <div
        class="w-full flex flex-col sm:items-start items-center relative z-10"
      >
        <img src="/img/logo3.webp" class="h-32" />

        <h1
          class="
            font-extrabold
            text-5xl text-center
            sm:text-left sm:text-6xl
            leading-tight
            mt-4
            mrws
            bg-gradient-to-br
            from-green-450
            to-green-900
            text-transparent
            bg-clip-text
          "
        >
          A Platform for
          <br />
          Trading Agricultural
          <br />
          Products
        </h1>
        <a
          v-if="$page.props.user"
          :href="route('dashboard')"
          class="
            block
            bg-green-600
            hover:bg-green-900
            rounded-md
            py-3
            px-4
            text-lg text-white
            font-bold
            uppercase
            mt-10
            mrws
          "
        >
          Home Page
        </a>
        <a
          v-else
          :href="route('register')"
          class="
            block
            bg-brown-500
            hover:bg-brown-900
            rounded-md
            py-3
            px-4
            text-lg text-white
            font-bold
            uppercase
            mt-10
            mrws
          "
        >
          Register Now
        </a>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <features />

  <!-- Team Section -->
  <team-section />

  <!-- Footer -->
  <welcome-footer />
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@800&display=swap");

.mrws {
  font-family: "Merriweather Sans", sans-serif;
}
</style>

<script>
import Dropdown from "@/Jetstream/Dropdown";
import DropdownLink from "@/Jetstream/DropdownLink";
import Features from "@/Components/Features";
import TeamSection from "@/Components/TeamSection";
import WelcomeFooter from "@/Components/WelcomeFooter";

export default {
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
  },

  components: {
    Dropdown,
    DropdownLink,
    Features,
    TeamSection,
    WelcomeFooter,
  },
};
</script>
