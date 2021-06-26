<template>
  <div class="mt-10">
    <v-row v-if="loopNum" justify="center" align-content="center">
      <div v-for="n in loopNum" :key="n" class="mb-10 mx-5">
        <WorkPreview :title="'テスト' + n" :img="n" :to="'/works/' + n" />
      </div>
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

export default {
  props: { num: { type: String } },
  components: {
    WorkPreview,
  },
  data(props: { num: String }): any {
    return {
      loopNum: Number(props.num) as Number,
    } as any;
  },
  created(): void {
    // Workをnum分fetch
    // numが-1だったら50個ずつfetch
  },
};
</script>
