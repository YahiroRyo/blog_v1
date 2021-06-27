<template>
  <div class="mx-auto">
    <Title title="ブログ一覧" />
    <Genre genre="blogs" num="10" />
  </div>
</template>
<script lang="ts">
import Genre from "~/components/Genre.vue";
import Title from "~/components/Title.vue";

export default {
  components: {
    Genre,
    Title,
  },
  data(): void {
    return {} as any;
  },
};
</script>
