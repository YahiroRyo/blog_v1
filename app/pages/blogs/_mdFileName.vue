<template>
  <div>
    <div v-if="md" v-html="md"></div>
    <v-overlay :value="true" v-else>
      <v-row cols="15" justify="center" align-content="center">
        <v-col class="text-center">
          <v-progress-circular indeterminate size="96"></v-progress-circular>
          <p class="display-1 mt-10">サーバを起動中か、データを取得中です。</p>
          <p class="body-1">
            ※30秒立っても見れない場合は、ページを抜けていただいて構いません
          </p>
        </v-col>
      </v-row>
    </v-overlay>
  </div>
</template>

<script lang="ts">
import { $axios } from "~/utils/api";
import { Route } from "vue-router";

export default {
  data(this: { $route: any }): any {
    return {
      result: null as any,
      md: "" as string,
    } as any;
  },
  async created(this: {
    result: any;
    md: string;
    $md: { render: Function };
    $route: Route;
  }): Promise<void> {
    // ここでmdファイルをfetch
    const param = {
      params: {
        fileId: this.$route.params.mdFileName,
      },
    };
    this.result = await $axios.$get("/blog/get", param);
    this.md = this.$md.render(this.result.md);
  },
};
</script>
