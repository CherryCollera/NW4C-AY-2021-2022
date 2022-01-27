<template>
  <div class="overflow-y-auto whitespace-nowrap scroll-hidden space-x-5">
    <jet-nav-link
      v-for="(category, i) in categories"
      :key="i"
      :href="
        route('dashboard', {
          category: category.value,
          location: route().params.location,
          hideOwnPost: route().params.hideOwnPost,
          price: route().params.price,
          price2: route().params.price2,
        })
      "
      :active="isRouteActive(category.value)"
    >
      {{ category.name }}
    </jet-nav-link>
  </div>
</template>

<script>
import JetNavLink from "@/Jetstream/NavLink";

export default {
  props: ["categories"],

  components: {
    JetNavLink,
  },

  methods: {
    isRouteActive(url) {
      if (url === "all" && route().params.category === undefined) return true;

      if (url === route().params.category) return true;

      return false;
    },
  },
};
</script>