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
            @click="$emit('click')"
          ></v-app-bar-nav-icon>
        </v-scroll-y-transition>
      </v-scroll-y-reverse-transition>
    </v-app-bar>
  </div>
</template>

<script lang="ts">
export default {
  data(this: { $ROUTERS: Array<any> }): any {
    return {
      header: {
        isHover: false as boolean,
      },
      routers: this.$ROUTERS as Array<any>,
    };
  },
};
</script>
