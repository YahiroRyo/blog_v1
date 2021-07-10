<template>
  <div>
    <v-row class="main-img" justify="center" align-content="center">
      <h1
        class="font-weight-thin main-img__title"
        :class="{
          'text-h2': !$vuetify.breakpoint.mobile,
          'text-h3': $vuetify.breakpoint.mobile,
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
  head(this: { meta: any }): any {
    if (process.server) {
      return {
        title: "YAPPIブログ | ホーム",
        meta: [
          {
            hid: "description",
            name: "description",
            content:
              "YAPPIブログ | ホーム エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます",
          },
          {
            hid: "og:description",
            property: "og:description",
            content:
              "YAPPIブログ | ホーム エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます",
          },
          { hid: "og:title", property: "og:title", content: "ホーム" },
          {
            hid: "og:image",
            property: "og:image",
            content: "https://yappi-blog.herokuapp.com/favicon.png",
          },
          {
            hid: "og:url",
            property: "og:url",
            content: "https://yappi-blog.herokuapp.com",
          },
        ],
      };
    }
  },
};
</script>
