<template>
  <div class="mx-auto">
    <Title title="ブログ一覧" />
    <Blogs num="10" />
  </div>
</template>
<script lang="ts">
import Blogs from "~/components/Blogs.vue";
import Title from "~/components/Title.vue";

export default {
  components: {
    Blogs,
    Title,
  },
  data(): void {
    return {} as any;
  },
};
</script>
