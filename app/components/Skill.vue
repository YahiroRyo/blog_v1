<template>
  <v-card>
    <v-card-title
      ><v-icon class="mr-2">mdi-{{ icon }}</v-icon
      >{{ lang }}</v-card-title
    >
  </v-card>
</template>

<script lang="ts">
export default {
  props: {
    lang: { type: String },
    explain: { type: String },
    icon: { type: String },
  },
};
</script>
