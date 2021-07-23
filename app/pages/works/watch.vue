<template>
  <div>
    <link href="/mdFileName.css" rel="stylesheet" />
    <link rel="stylesheet" href="/atom-one-light.min.css" />
    <script src="/highlight.min.js"></script>
    <script>
      hljs.initHighlightingOnLoad();
    </script>
    <v-row v-if="result.isExists" justify="center" align-content="center">
      <v-col :cols="$vuetify.breakpoint.mobile ? '12' : '10'">
        <v-card-title class="py-0 pr-0 pl-1 grey--text text--darken-3 subtitle-1"
          >更新日</v-card-title
        >
        <v-card-text class="py-0 pr-0 pl-1 button">{{
          result.update.split("T")[0]
        }}</v-card-text>
        <div v-html="$md.render(`[[toc]]\n${md}`)"></div>
      </v-col>
      <v-col
        :cols="$vuetify.breakpoint.mobile ? '12' : '2'"
        :class="{ 'self-intro': !$vuetify.breakpoint.mobile }"
      >
        <v-divider class="mt-10" v-if="$vuetify.breakpoint.mobile"></v-divider>
        <v-card flat>
          <v-img class="mx-auto" max-width="250" src="/favicon.ico" alt="YAPPI BLOG" />
          <v-card-title>ヤッピー </v-card-title>
          <v-card-subtitle>専門学生一年生</v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text
            ><span class="body-1" style="color: #224047">自己紹介</span
            ><br />知識欲のままに行動をしてたまに空回りする男<br />現在はWeb系を中心に勉強をしている</v-card-text
          >
          <v-card-text
            ><span class="body-1" style="color: #224047"
              >ある程度使える言語とかフレームワーク達</span
            ><br />Laravel / Vue / Nuxt / Python / C#</v-card-text
          >
          <v-card-actions class="d-flex">
            <v-icon
              class="mx-auto text-h3 v-icon-hover"
              @click="linkToOtherWindow('https://github.com/YahiroRyo')"
              >mdi-github</v-icon
            >
            <v-icon
              class="mx-auto text-h3 v-icon-hover"
              @click="linkToOtherWindow('https://twitter.com/Yappisec')"
              >mdi-twitter</v-icon
            >
          </v-card-actions>
          <v-chip
            color="#666"
            class="ml-3 mr-1 mt-2"
            draggable
            outlined
            pill
            v-for="(tag, index) in result.tags"
            :key="index"
            @click.stop="$router.push(`/search-tag?tag=${tag}`)"
            >{{ tag }}</v-chip
          >
        </v-card>
      </v-col>
    </v-row>
    <v-overlay :value="true" v-else>
      <v-row cols="15" justify="center" align-content="center">
        <v-col cols="10" class="text-center">
          <v-progress-circular indeterminate size="96"></v-progress-circular>
          <p
            class="mt-10"
            :class="{
              'display-1': !$vuetify.breakpoint.mobile,
              'text-h6': $vuetify.breakpoint.mobile,
            }"
          >
            サーバを起動中か、データを取得中です。
          </p>
          <p class="body-1">
            ※30秒立っても見れない場合は、ページを抜けていただいて構いません
          </p>
        </v-col>
      </v-row>
    </v-overlay>
    <component :is="'style'">
      .theme--light.v-application code { background-color: black; }
    </component>
  </div>
</template>

<style lang="scss" scoped>
.v-icon-hover {
  padding: 10px;
  border-radius: 50%;
}
.v-icon-hover:hover {
  background-color: #eee;
}
.self-intro {
  position: sticky;
  top: 0;
  height: 100px;
}
.theme--light.v-application code {
}
</style>

<script lang="ts">
import { Store } from "vuex";

export default {
  async asyncData({
    store,
    $axios,
    route,
  }: {
    store: Store<any>;
    $axios: any;
    route: any;
  }): Promise<any> {
    const routePath = route.path.split("/")[1];
    const mode = routePath.substr(0, routePath.length - 1);
    const param = {
      params: {
        fileId: route.query.fi,
      } as any,
    };
    return $axios.get(`/${mode}/get`, param).then((res: any) => {
      const result = res.data;
      const md = result.md;
      let keywords = "ヤッピーブログ,YAPPI BLOG,";
      for (let i = 0; i < result.tags.length; i++) {
        keywords += `${result.tags[i]}${i != result.tags.length - 1 ? "," : ""}`;
      }
      store.commit("windowState/setTitle", result.title);
      const meta = {
        description: result.md
          .replaceAll("#", "")
          .replaceAll("\n", "")
          .replaceAll("-", "")
          .replaceAll("1.", "")
          .replaceAll("~~.", ""),
        title: result.title,
        image: result.img,
        keywords: keywords,
        url: "https://stupefied-ramanujan-ce7604.netlify.app" + route.fullPath,
      };
      return {
        result: result,
        meta: meta,
        md: md,
      };
    });
  },
  methods: {
    linkToOtherWindow(url: string): void {
      window.open(url, "_blank");
    },
  },
  head(this: { meta: any }): any {
    if (process.server) {
      return {
        title: this.meta.title,
        meta: [
          { hid: "description", name: "description", content: this.meta.description },
          { hid: "keywords", name: "keywords", content: this.meta.keywords },
          {
            hid: "og:description",
            property: "og:description",
            content: this.meta.description,
          },
          { hid: "og:title", property: "og:title", content: this.meta.title },
          { hid: "og:image", property: "og:image", content: this.meta.image },
          { hid: "og:url", property: "og:url", content: this.meta.url },
        ],
      };
    }
  },
};
</script>
