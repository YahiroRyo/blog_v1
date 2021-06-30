<template>
  <div class="mx-auto">
    <Title title="作品一覧" />
    <Genre genre="works" num="10" />
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
      "YAPPIブログ | 作品一覧 エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます"
    );
  },
};
</script>
