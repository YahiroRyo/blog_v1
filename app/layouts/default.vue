<template>
  <v-app>
    <Header />
    <v-main>
      <v-container class="d-flex" fluid>
        <nuxt />
      </v-container>
    </v-main>
  </v-app>
</template>

<style lang="scss">
.v-cursor-pointer {
  cursor: pointer;
}
</style>

<script lang="ts">
import Header from "~/components/header.vue";
export default {
  components: { Header },
  methods: {
    scrollHandle(this: { $store: any }): void {
      this.$store.commit("windowState/setScrollX", window.pageXOffset);
      this.$store.commit("windowState/setScrollY", window.pageYOffset);
    },
  },
  created(this: { scrollHandle: Function }): void {
    window.addEventListener("scroll", () => {
      this.scrollHandle();
    });
    this.scrollHandle();
  },
};
</script>
