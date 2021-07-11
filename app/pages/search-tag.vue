<template>
  <div>
    <Title :title="$route.query.tag" />
    <v-row
      v-if="result.length != 0"
      justify="center"
      align-content="center"
      class="mt-10"
    >
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
          :genre="`${item.genre}s`"
          :to="`/${item.genre}s/watch?fi=${item.fileId}`"
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
const WorkPreview = () => import("~/components/WorkPreview.vue");
const Title = () => import("~/components/Title.vue");

export default {
  components: {
    WorkPreview,
    Title,
  },
  async asyncData({ $axios, route }: { $axios: any; route: any }): Promise<any> {
    const param = {
      params: {
        tag: route.query.tag,
      },
    };
    console.log(param);
    return $axios.get("/tag/contents/get", param).then((res: any) => {
      const result = res.data;
      return {
        result: result as Array<any>,
      };
    });
  },
  watch: {
    "$route.query.tag": function (this: { $route: any; $axios: any; result: any }): void {
      const param = {
        params: {
          tag: this.$route.query.tag,
        },
      };
      console.log(param);
      return this.$axios.get("/tag/contents/get", param).then((res: any) => {
        this.result = res.data;
      });
    },
  },
};
</script>
