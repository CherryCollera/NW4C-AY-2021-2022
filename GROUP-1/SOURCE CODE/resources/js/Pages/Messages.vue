<template>
  <app-layout>
    <chat
      :conversations="conversations"
      :categories="categories"
      :qtyType="qtyType"
    />
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Chat from "@/Components/Chat";

export default {
  props: ["conversations", "categories", "qtyType"],

  components: {
    AppLayout,
    Chat,
  },
};
</script>