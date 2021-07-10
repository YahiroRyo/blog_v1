<template>
  <v-app>
    <TheHeader />
    <v-main>
      <v-container fluid>
        <transition name="router-anim">
          <nuxt keep-alive />
        </transition>
      </v-container>
    </v-main>
    <TheFooter />
  </v-app>
</template>

<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap");
body {
  font-family: "Noto Sans JP", system-ui;
}
.v-cursor-pointer {
  cursor: pointer;
  user-select: none;
}
.router-anim-enter {
  opacity: 0;
}
.router-anim-enter-active {
  transition: opacity 1s;
}
</style>

<script lang="ts">
import { Store } from "vuex";

import TheHeader from "~/components/TheHeader.vue";
const TheFooter = () => import("~/components/TheFooter.vue");

export default {
  components: {
    TheHeader,
    TheFooter,
  },
  head(this: { $store: Store<any> }): any {
    return {
      title: this.$store.state.windowState.title,
    };
  },
  data(this: { $ROUTERS: Array<any> }): any {
    return {
      header: {
        isClickNavIcon: false as boolean,
      },
      routers: this.$ROUTERS as Array<any>,
    };
  },
  methods: {
    scrollHandle(this: { $store: any }): void {
      if (process.browser) {
        this.$store.commit("windowState/setScrollX", window.pageXOffset);
        this.$store.commit("windowState/setScrollY", window.pageYOffset);
      }
    },
  },
  created(this: { scrollHandle: Function; resizeHandle: Function }): void {
    if (process.browser) {
      window.addEventListener("scroll", () => {
        this.scrollHandle();
      });
      this.scrollHandle();
    }
  },
};
</script>
