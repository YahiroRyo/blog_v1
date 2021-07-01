<template>
  <div>
    <!-- headerのbar -->
    <v-app-bar flat app color="white">
      <v-toolbar-title
        class="font-weight-bold text-h4 v-cursor-pointer grey--text text--darken-1"
        @click="$router.push('/')"
        >YAPPI BLOG</v-toolbar-title
      >
      <client-only>
        <template
          v-for="(router, index) in routers"
          v-if="
            $store.state.windowState.scrollY == 0 &&
            !$store.state.windowState.isMobile &&
            !router.isHide
          "
        >
          <v-scroll-y-reverse-transition>
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
      </client-only>
      <v-spacer> </v-spacer>
      <v-scroll-y-reverse-transition>
        <v-scroll-y-transition>
          <v-app-bar-nav-icon
            v-if="
              $store.state.windowState.scrollY != 0 || $store.state.windowState.isMobile
            "
            :class="{
              'white--text grey': !header.isOpen,
              'black--text white': header.isOpen,
            }"
            @click="header.isOpen = !header.isOpen"
          ></v-app-bar-nav-icon>
        </v-scroll-y-transition>
      </v-scroll-y-reverse-transition>
    </v-app-bar>
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
        <v-list-item
          v-for="(router, index) in routers"
          :key="index"
          v-if="!router.isHide"
          @click="$router.push(router.to)"
        >
          <v-icon>
            {{ router.icon }}
          </v-icon>
          <v-list-item-title class="ml-3">{{ router.title }}</v-list-item-title>
        </v-list-item>
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
};
</script>
