<template>
  <div>
    <v-row class="v-cursor-pointer" align-content="center" justify="center">
      <v-card
        width="500"
        height="300"
        @mouseover="isHover = true"
        @mouseleave="isHover = false"
        :style="'background-image: url(' + img + ')'"
      >
        <v-overlay absolute :value="isHover" class="text-h6">
          {{ title }}
        </v-overlay>
      </v-card>
    </v-row>
  </div>
</template>

<script lang="ts">
export default {
  props: ["img", "title"],
  data(): any {
    return {
      isHover: false as boolean,
    } as any;
  },
};
</script>
