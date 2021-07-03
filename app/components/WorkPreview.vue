<template>
  <div>
    <v-row class="v-cursor-pointer" align-content="center" justify="center">
      <v-card
        :width="$store.state.windowState.isMobile ? '300' : '500'"
        height="550"
        @mouseover="isHover = true"
        @mouseleave="isHover = false"
        @click="$router.push(to)"
      >
        <v-img
          :src="img"
          :width="$store.state.windowState.isMobile ? '300' : '600'"
          :height="$store.state.windowState.isMobile ? '169' : '200'"
        >
        </v-img>
        <v-card-text
          class="body-1 font-weight-bold"
          :class="{ 'orange--text': genre == 'blogs', 'green--text': genre == 'works' }"
          >{{ genre }}</v-card-text
        >
        <v-card-title>{{ title }}</v-card-title>
        <v-row justify="center" align-content="center">
          <v-col cols="11">
            <v-divider></v-divider>
            <v-card-title>筆者</v-card-title>
            <v-card-subtitle>ヤッピー</v-card-subtitle>
          </v-col>
        </v-row>
        <v-row align-content="center" justify="center">
          <v-overlay
            absolute
            :value="isHover"
            :class="{
              'text-h4': !$store.state.windowState.isMobile,
              'text-h6': $store.state.windowState.isMobile,
            }"
          >
            <v-col cols="12">
              {{ title }}
            </v-col>
          </v-overlay>
        </v-row>
      </v-card>
    </v-row>
  </div>
</template>

<script lang="ts">
export default {
  props: ["img", "title", "genre", "to"],
  data(): any {
    return {
      isHover: false as boolean,
    } as any;
  },
};
</script>
