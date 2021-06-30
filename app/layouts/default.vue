<template>
  <v-app>
    <TheHeader />
    <v-main>
      <v-container fluid>
        <transition name="router-anim">
          <nuxt />
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
const TheHeader = () => import("~/components/TheHeader.vue");
const TheFooter = () => import("~/components/TheFooter.vue");

export default {
  components: {
    TheHeader,
    TheFooter,
  },
  data(this: { $ROUTERS: Array<any> }): any {
    return {
      header: {
        isClickNavIcon: false as boolean,
      },
      routers: this.$ROUTERS as Array<any>,
    };
  },
  head(this: { $store: any }): any {
    return {
      title: this.$store.state.windowState.title as string,
      meta: [
        { charset: "utf-8" },
        { name: "viewport", content: "width=device-width, initial-scale=1" },
        {
          hid: "description",
          name: "description",
          content: this.$store.state.windowState.description,
        },
      ],
    };
  },
  methods: {
    scrollHandle(this: { $store: any }): void {
      if (process.browser) {
        this.$store.commit("windowState/setScrollX", window.pageXOffset);
        this.$store.commit("windowState/setScrollY", window.pageYOffset);
      }
    },
    resizeHandle(this: { $store: any }): void {
      if (process.browser) {
        if (window.innerWidth <= 1260) {
          this.$store.commit("windowState/setIsMobile", true);
        } else {
          this.$store.commit("windowState/setIsMobile", false);
        }
      }
    },
  },
  created(this: { scrollHandle: Function; resizeHandle: Function }): void {
    if (process.browser) {
      window.addEventListener("scroll", () => {
        this.scrollHandle();
      });
      this.scrollHandle();

      window.addEventListener("resize", () => {
        this.resizeHandle();
      });
      this.resizeHandle();
    }
  },
};
</script>
