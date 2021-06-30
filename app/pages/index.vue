<template>
  <div>
    <v-row class="main-img" justify="center" align-content="center">
      <h1
        class="font-weight-thin main-img__title"
        :class="{
          'text-h2': !$store.state.windowState.isMobile,
          'text-h3': $store.state.windowState.isMobile,
        }"
      >
        知識欲のままに学習を続ける.
      </h1>
    </v-row>
    <Title title="WORKS" />
    <Genre genre="works" num="3" />
    <Title title="BLOGS" />
    <Genre genre="blogs" num="3" />
  </div>
</template>

<style lang="scss" scoped>
@import "~assets/scss/index.scss";
</style>

<script lang="ts">
import { Store } from "vuex";
const Genre = () => import("~/components/Genre.vue");
const Title = () => import("~/components/Title.vue");

export default {
  components: {
    Genre,
    Title,
  },
  created(this: { $store: Store<any> }): void {
    this.$store.commit(
      "windowState/setDescription",
      "YAPPIブログ | ホーム エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます"
    );
  },
};
</script>
