<template>
  <div v-html=""></div>
</template>

<script lang="ts">
export default {
  data(this: { $route: any }): any {
    return {
      md: null as any,
    } as any;
  },
  created(): void {
    // ここでmdファイルをfetch
  },
};
</script>
