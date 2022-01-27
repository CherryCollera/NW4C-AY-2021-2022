<template>
  <section class="text-gray-400 bg-gray-900 body-font">
    <div class="container px-5 py-24 mx-auto">
      <div class="flex flex-col text-center w-full mb-20">
        <h1
          class="
            text-2xl
            font-medium
            title-font
            mb-4
            text-white
            tracking-widest
          "
        >
          The E-Barter Team
        </h1>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
          The team that brought you, the E-Barter Website.
        </p>
      </div>

      <div class="flex flex-wrap -m-4">
        <member-card
          name="John Michael Miguel"
          title="Member"
          description="Lead the software development phase, and responsible for the overall system development"
          photo="/img/jmcmiguel.webp"
        />
        <member-card
          name="Justine Marie Padilla"
          title="Team Leader"
          description="In-charge of team management and the overall system documentation."
          photo="/img/jmrpadilla.webp"
        />
        <member-card
          name="Elaisa Mae Magpantay"
          title="Member"
          description="Associate for research and documentation of the system."
          photo="/img/emcmagpantay.webp"
        />
        <member-card
          name="Gamel Iloco"
          title="Member"
          description="Leading the data gathering for the system requirements, as well as system testing."
          photo="/img/giiloco.webp"
        />
      </div>
    </div>
  </section>
</template>

<script>
import MemberCard from "@/Components/TeamMemberCard";
export default {
  components: {
    MemberCard,
  },
};
</script>