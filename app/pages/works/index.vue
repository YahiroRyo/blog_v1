<template>
  <div class="mx-auto">
    <Title title="作品一覧" />
    <Works num="10" />
  </div>
</template>
<script lang="ts">
import Works from "~/components/Works.vue";
import Title from "~/components/Title.vue";

export default {
  components: {
    Works,
    Title,
  },
  data(): void {
    return {} as any;
  },
};
</script>
