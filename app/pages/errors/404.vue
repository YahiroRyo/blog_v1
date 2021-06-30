<template>
  <v-row style="height: 80vh" justify="center" align-content="center">
    <div class="text-h2">ページが見つかりません</div>
  </v-row>
</template>
<script lang="ts">
import { Store } from "vuex";

export default {
  created(this: { $store: Store<any> }): void {
    this.$store.commit("windowState/setTitle", "ページが見つかりません");
    this.$store.commit(
      "windowState/setDescription",
      "YAPPIブログ | 404 エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます"
    );
  },
};
</script>
