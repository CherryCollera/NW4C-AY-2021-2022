<template>
  <button
    :type="type"
    class="
      animate-pulse
      fixed
      z-40
      bottom-10
      right-10
      p-0
      w-16
      h-16
      bg-green-600
      rounded-full
      hover:bg-green-700
      active:shadow-lg
      mouse
      shadow
      transition
      ease-in
      duration-200
      focus:outline-none
    "
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: "submit",
    },
  },
};
</script>