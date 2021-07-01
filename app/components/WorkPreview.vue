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
        <v-row cols="15" align-content="center" justify="center">
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
  props: ["img", "title", "to"],
  data(): any {
    return {
      isHover: false as boolean,
    } as any;
  },
};
</script>
