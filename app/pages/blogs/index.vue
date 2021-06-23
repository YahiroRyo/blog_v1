<template>
  <div>
    <Blogs num="10" />
  </div>
</template>
<script lang="ts">
import Blogs from "~/components/Blogs.vue";

export default {
  components: {
    Blogs,
  },
  data(): void {
    return {} as any;
  },
};
</script>
