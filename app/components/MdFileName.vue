<template>
  <div>
    <link href="/mdFileName.css" rel="stylesheet" />
    <v-row v-if="result.isExists" justify="center" align-content="center">
      <v-col :cols="$store.state.windowState.isMobile ? '12' : '10'">
        <div v-html="md"></div>
      </v-col>
      <v-col
        :cols="$store.state.windowState.isMobile ? '12' : '2'"
        :class="{ 'self-intro': !$store.state.windowState.isMobile }"
      >
        <v-divider class="mt-10" v-if="$store.state.windowState.isMobile"></v-divider>
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
              'display-1': !$store.state.windowState.isMobile,
              'text-h6': $store.state.windowState.isMobile,
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
</style>

<script lang="ts">
import { $axios } from "~/utils/api";
import { Store } from "vuex";

export default {
  props: { genre: { type: String }, routeFileId: { type: String } },
  data(props: { genre: string; routeFileId: string }): any {
    return {
      md: "" as string,
      mode: props.genre as string,
      result: {} as any,
      share: {
        title: "",
        url: "",
        description: "",
        img: "",
      } as any,
      fileId: props.routeFileId as string,
    } as any;
  },
  methods: {
    linkToOtherWindow(url: string): void {
      window.open(url, "_blank");
    },
    shareUrl(this: { share: any }): void {
      navigator.clipboard
        .writeText(
          encodeURI(
            `https://stupefied-ramanujan-ce7604.netlify.app/share?description=${this.share.description}&title=${this.share.title}&img=${this.share.img}&url=${this.share.url}`
          )
        )
        .catch((e) => {
          console.error(e);
        });
    },
  },
  async created(this: {
    md: string;
    mode: string;
    result: any;
    fileId: string;
    share: any;
    $md: { render: Function };
    $route: any;
    $store: Store<any>;
  }): Promise<void> {
    // ここでmdファイルをfetch
    const param = {
      params: {
        fileId: this.fileId as string,
      } as any,
    };
    this.result = await $axios.$get(`/${this.mode}/get`, param);
    this.md = this.$md.render("[[toc]]\n" + this.result.md);
    this.$store.commit("windowState/setTitle", this.result.title);
    this.share.title = this.result.title;
    if (process.browser) {
      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = this.md;
      this.$store.commit(
        "windowState/setDescription",
        tempDiv.innerText.replaceAll("\n", "")
      );
      this.share.description = tempDiv.innerText.substr(0, 99).replaceAll("\n", "");
    }
    this.$store.commit("windowState/setImg", this.result.img);

    this.share.img = String(this.result.img).replace("https://res.cloudinary.com", "");
    this.share.url = String(this.$route.fullPath).replace(
      "https://stupefied-ramanujan-ce7604.netlify.app",
      ""
    );
  },
};
</script>
