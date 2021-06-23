<template>
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
</template>

<script lang="ts">
export default {
  props: ["isOpenHeaderNav"],
  data(this: { $ROUTERS: Array<any> }): any {
    return {
      routers: this.$ROUTERS as Array<any>,
    };
  },
};
</script>
