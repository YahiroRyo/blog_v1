<template>
  <v-app>
    <TheHeader
      @click="header.isClickNavIcon = !header.isClickNavIcon"
      :is-open="header.isClickNavIcon"
    />
    <TheHeaderNav
      :is-open-header-nav="header.isClickNavIcon && $store.state.windowState.scrollY != 0"
    />
    <v-main>
      <v-container style="min-height: 100vh" class="d-flex" fluid>
        <nuxt />
      </v-container>
    </v-main>
    <TheFooter />
  </v-app>
</template>

<style lang="scss">
.v-cursor-pointer {
  cursor: pointer;
}
</style>

<script lang="ts">
import TheHeader from "~/components/TheHeader.vue";
import TheHeaderNav from "~/components/TheHeaderNav.vue";
import TheFooter from "~/components/TheFooter.vue";
export default {
  components: {
    TheHeader,
    TheHeaderNav,
    TheFooter,
  },
  data(): any {
    return {
      header: {
        isClickNavIcon: false as boolean,
      },
    };
  },
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
