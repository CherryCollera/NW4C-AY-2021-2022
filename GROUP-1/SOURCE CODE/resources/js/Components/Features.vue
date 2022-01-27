<template>
  <div class="w-full">
    <div
      class="
        flex flex-col
        items-center
        md:items-stretch md:flex-row
        flex-wrap
        md:justify-center
        max-w-screen-lg
        mx-auto
        py-20
        md:py-24
      "
    >
      <h5 class="font-bold text-green-500 mb-4">Features</h5>
      <h2
        class="text-4xl sm:text-5xl font-black tracking-wide text-center w-full"
      >
        System Overview
      </h2>
      <p
        class="
          mt-4
          text-sm
          md:text-base
          lg:text-lg
          font-medium
          leading-relaxed
          text-gray-700
          max-w-xl
          w-full
          text-center
        "
      >
        E-Barter is a web application that can enhance the process of exchanging
        agricultural goods and supplies. It can help small to medium-scale
        farmers, agricultural entrepreneurs and other agricultural-related
        sectors promote their products and supplies and innovate their means of
        finding potential consumers through online bartering.
      </p>
      <div class="mt-10 w-full"></div>

      <div
        class="md:w-1/2 lg:w-1/3 max-w-sm"
        v-for="(card, index) in defaultCards"
        :key="index"
      >
        <div
          class="
            flex flex-col
            sm:flex-row
            items-center
            sm:items-start
            text-center
            sm:text-left
            h-full
            mx-4
            px-2
            py-8
          "
        >
          <span class="border text-center rounded-full p-5 flex-shrink-0">
            <img class="w-6 h-6" :src="card.imageSrc" alt="" />
          </span>
          <span class="sm:ml-4 mt-4 sm:mt-2">
            <span class="mt-4 tracking-wide font-bold text-2xl leading-none">{{
              card.title
            }}</span>
            <p class="mt-1 sm:mt-4 font-medium text-gray-700 leading-loose">
              {{ card.description }}
            </p>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;600;700&display=swap");

* {
  font-family: "Inter", system-ui;
}

h2,
span {
  color: rgba(36, 62, 99, 0.99);
}

p {
  color: rgba(36, 62, 99, 0.7);
}
</style>

<script>
export default {
  data() {
    return {
      defaultCards: [
        {
          imageSrc: "/img/shield.svg",
          title: "Secure",
          description:
            "We follow the right security protocols to protect your data.",
        },
        {
          imageSrc: "/img/message-circle.svg",
          title: "Messaging",
          description:
            "Our application have built-in messaging capabilities so that you can directly message other users.",
        },
        {
          imageSrc: "/img/sliders.svg",
          title: "Customizable",
          description:
            "You can customize feed to your own liking. Find exactly what you are looking for.",
        },
        {
          imageSrc: "/img/home.svg",
          title: "Convenient",
          description:
            "Start trading at the comfort of your own home. Hassle-Free.",
        },
        {
          imageSrc: "/img/map-pin-green.svg",
          title: "Geo-Based",
          description:
            "Want to trade within a specified vicinity? No worries, we got you.",
        },
        {
          imageSrc: "/img/user-check.svg",
          title: "User-Friendly",
          description: "UI is designed to be as simple as possible.",
        },
      ],
    };
  },
};
</script>