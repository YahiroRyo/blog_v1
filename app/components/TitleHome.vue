<template>
  <v-row justify="center" align-content="center">
    <v-list>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h4 mt-5">{{ title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
    </v-list>
  </v-row>
</template>

<script lang="ts">
export default {
  props: ["title"],
};
</script>
