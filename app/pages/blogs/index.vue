<template>
  <div class="mx-auto">
    <Title title="ブログ一覧" />
    <Genre genre="blogs" num="10" />
  </div>
</template>
<script lang="ts">
import { Store } from "vuex";
const Genre = () => import("~/components/Genre.vue");
const Title = () => import("~/components/Title.vue");

export default {
  components: {
    Genre,
    Title,
  },
  data(): void {
    return {} as any;
  },
  created(this: { $store: Store<any> }): void {
    this.$store.commit(
      "windowState/setDescription",
      "YAPPIブログ | ブログ一覧 エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます"
    );
  },
};
</script>
