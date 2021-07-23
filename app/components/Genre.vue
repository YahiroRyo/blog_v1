<template>
  <div class="mt-10">
    <v-row v-if="result.length != 0" justify="center" align-content="center">
      <v-col
        xl="2"
        lg="3"
        md="4"
        sm="5"
        xs="10"
        v-for="(item, index) in result"
        :key="index"
        class="mb-10 mx-5"
      >
        <WorkPreview
          :title="item.title"
          :img="item.img"
          :tags="item.tags"
          :genre="genre"
          :to="`/${mode}/watch?fi=${item.fileId}`"
          :time="item.update.split('T')[0]"
        />
      </v-col>
    </v-row>
    <v-row v-else justify="center" align-content="center">
      <v-col
        xl="2"
        lg="3"
        md="4"
        sm="5"
        xs="10"
        v-for="n in 3"
        :key="n"
        class="mb-10 mx-5"
      >
        <v-row align-content="center" justify="center">
          <v-sheet
            :width="$vuetify.breakpoint.mobile ? '400' : '600'"
            height="550"
            color="grey lighten-5"
          >
            <v-skeleton-loader
              class="pa-2"
              type="image, table-cell, text, divider, table-cell, text"
            >
            </v-skeleton-loader>
          </v-sheet>
        </v-row>
      </v-col>
    </v-row>
  </div>
</template>
<script lang="ts">
import WorkPreview from "~/components/WorkPreview.vue";
import { $axios } from "~/utils/api";
import { Store } from "vuex";

export default {
  props: { num: { type: String }, genre: { type: String } },
  components: {
    WorkPreview,
  },
  data(props: { num: String; genre: String }): any {
    return {
      fetchNum: Number(props.num) as Number,
      result: [] as Array<any>,
      mode: props.genre as string,
    } as any;
  },
  async created(this: {
    result: Array<any>;
    fetchNum: Number;
    mode: String;
    $config: any;
    $store: Store<any>;
  }): Promise<void> {
    // Blogをnum分fetch
    // numが-1だったら50個ずつfetch
    if (process.client) {
      const param = {
        params: {
          num: this.fetchNum as Number,
          sum: 0 as Number,
        } as any,
      } as any;
      if (this.fetchNum == -1) {
        // 50個fetch
        param.params.num = 50;
      }
      this.result = await $axios.$get(`/${this.mode}/get`, param);
      console.log(this.result);
    }
  },
};
</script>
