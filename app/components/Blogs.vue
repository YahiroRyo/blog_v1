<template>
  <div class="mt-10">
    <v-row cols="15" v-if="result.length != 0" justify="center" align-content="center">
      <v-col v-for="(item, index) in result" :key="index" class="mb-10 mx-5">
        <WorkPreview :title="item.title" :img="item.img" :to="`/blogs/${item.fileId}`" />
      </v-col>
    </v-row>
    <v-row v-else justify="center" align-content="center" style="height: 300px">
      <v-progress-circular
        size="64"
        indeterminate
        color="gray darken-1"
      ></v-progress-circular>
    </v-row>
  </div>
</template>
<script lang="ts">
import WorkPreview from "~/components/WorkPreview.vue";
import { $axios } from "~/utils/api";

export default {
  props: { num: { type: String } },
  components: {
    WorkPreview,
  },
  data(props: { num: String }): any {
    return {
      fetchNum: Number(props.num) as Number,
      result: [] as Array<any>,
    } as any;
  },
  async created(this: {
    result: Array<any>;
    fetchNum: Number;
    $config: any;
  }): Promise<void> {
    // Blogをnum分fetch
    // numが-1だったら50個ずつfetch
    const param = {
      params: {
        num: this.fetchNum as Number,
        sum: 0 as Number,
      } as any,
    } as any;
    if (this.fetchNum == -1) {
      // 50個fetch
      param.params.num = 50;
      this.result = await $axios.$get(`/blogs/get`, param);
    } else {
      // fetchNum分fetch
      this.result = await $axios.$get(`/blogs/get`, param);
    }
  },
};
</script>
