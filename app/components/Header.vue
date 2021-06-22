<template>
  <div>
    <v-app-bar flat app color="white">
      <v-toolbar-title
        class="font-weight-bold text-h4 v-cursor-pointer grey--text text--darken-1"
        @click="$router.push('/')"
        >YAPPI BLOG</v-toolbar-title
      >
      <template
        v-for="(router, index) in routers"
        v-if="$store.state.windowState.scrollY == 0 && !router.isHide"
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
      <v-spacer> </v-spacer>
      <v-scroll-y-reverse-transition>
        <v-scroll-y-transition>
          <v-app-bar-nav-icon
            v-if="$store.state.windowState.scrollY != 0"
            class="white--text grey"
            @click="header.isClickNavIcon = !header.isClickNavIcon"
          ></v-app-bar-nav-icon>
        </v-scroll-y-transition>
      </v-scroll-y-reverse-transition>
    </v-app-bar>
    <v-navigation-drawer v-model="isOpenHeaderNav" right app>
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
          @click="$router.push(router.to)"
          v-if="!router.isHide"
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
        isClickNavIcon: false as boolean,
      },
      routers: this.$ROUTERS as Array<any>,
    };
  },
  computed: {
    isOpenHeaderNav: {
      get(this: { header: any; $store: any }) {
        if (this.header.isClickNavIcon && this.$store.state.windowState.scrollY != 0) {
          return true;
        } else if (
          this.header.isClickNavIcon &&
          this.$store.state.windowState.scrollY == 0
        ) {
          this.header.isClickNavIcon = false;
        }
        return false;
      },
      set() {},
    },
  },
};
</script>
