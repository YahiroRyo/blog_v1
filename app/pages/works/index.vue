<template>
  <div class="mx-auto">
    <Title title="作品一覧" />
    <Genre genre="works" num="-1" />
  </div>
</template>
<script lang="ts">
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
  head(this: { meta: any }): any {
    if (process.server) {
      return {
        title: "YAPPIブログ | 作品",
        meta: [
          {
            hid: "description",
            name: "description",
            content:
              "YAPPIブログ | 作品 エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます",
          },
          {
            hid: "og:description",
            property: "og:description",
            content:
              "YAPPIブログ | 作品 エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます",
          },
          { hid: "og:title", property: "og:title", content: "作品" },
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
