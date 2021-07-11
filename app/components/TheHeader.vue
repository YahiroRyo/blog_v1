<template>
  <div>
    <client-only>
      <!-- headerのbar -->
      <v-app-bar flat app color="white">
        <v-toolbar-title
          class="font-weight-bold text-h4 v-cursor-pointer grey--text text--darken-1"
          @click="$router.push('/')"
          >YAPPI BLOG</v-toolbar-title
        >
        <template v-for="(router, index) in routers">
          <template
            v-if="
              $store.state.windowState.scrollY == 0 &&
              !$vuetify.breakpoint.mobile &&
              !router.isHide
            "
          >
            <v-scroll-y-reverse-transition :key="index">
              <v-scroll-y-transition>
                <div
                  class="black--text v-cursor-pointer ml-5"
                  @click="$router.push(router.to)"
                  :key="index"
                >
                  {{ router.title }}
                </div>
              </v-scroll-y-transition>
            </v-scroll-y-reverse-transition>
          </template>
        </template>
        <v-spacer> </v-spacer>
        <v-scroll-y-reverse-transition>
          <v-scroll-y-transition>
            <v-app-bar-nav-icon
              v-show="$store.state.windowState.scrollY != 0 || $vuetify.breakpoint.mobile"
              :class="{
                'white--text grey': !header.isOpen,
                'black--text white': header.isOpen,
              }"
              @click="header.isOpen = !header.isOpen"
            ></v-app-bar-nav-icon>
          </v-scroll-y-transition>
        </v-scroll-y-reverse-transition>
      </v-app-bar>
    </client-only>
    <!-- 右のdrawer -->
    <v-navigation-drawer
      v-model="header.isOpen"
      :expand-on-hover="header.isOpen && $store.state.windowState.scrollY == 0"
      right
      app
    >
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h6"> メニュー </v-list-item-title>
          <v-list-item-subtitle>MENU</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
      <v-list nav rounded>
        <template v-for="(router, index) in routers">
          <v-list-item
            :key="index"
            v-if="!router.isHide"
            @click="$router.push(router.to)"
          >
            <v-icon>
              {{ router.icon }}
            </v-icon>
            <v-list-item-title class="ml-3">{{ router.title }}</v-list-item-title>
          </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script lang="ts">
export default {
  data(this: { $ROUTERS: Array<any> }): any {
    return {
      header: {
        isHover: false as boolean,
        isOpen: false as boolean,
      },
      routers: this.$ROUTERS as Array<any>,
    };
  },
  mounted(this: { header: any }): void {
    setTimeout(() => {
      this.header.isOpen = false;
    }, 100);
  },
};
</script>
