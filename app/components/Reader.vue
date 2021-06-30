<template>
  <div>
    <link href="/mdFileName.css" rel="stylesheet" />
    <v-card flat v-html="mdFunc.render(md)" class="markdown"> </v-card>
  </div>
</template>

<script lang="ts">
export default {
  props: ["md"],
  data(this: { $md: Function }): any {
    return {
      mdFunc: this.$md as Function,
    };
  },
};
</script>
