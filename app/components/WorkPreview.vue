<template>
  <div>
    <v-row class="v-cursor-pointer" align-content="center" justify="center">
      <v-card
        :width="$store.state.windowState.isMobile ? '300' : '500'"
        :height="$store.state.windowState.isMobile ? '169' : '281'"
        @mouseover="isHover = true"
        @mouseleave="isHover = false"
        @click="$router.push(to)"
        :style="'background-image: url(' + img + '); background-size: cover'"
      >
        <v-overlay absolute :value="isHover" class="text-h4">
          {{ title }}
        </v-overlay>
      </v-card>
    </v-row>
  </div>
</template>

<script lang="ts">
export default {
  props: ["img", "title", "to"],
  data(): any {
    return {
      isHover: false as boolean,
    } as any;
  },
};
</script>
