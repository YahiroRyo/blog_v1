<template>
  <v-row justify="center" align-content="center" class="mt-10">
    <div v-for="n in loopNum" :key="n" class="mb-10 mx-5">
      <WorkPreview :title="'テスト' + n" :img="n" />
    </div>
  </v-row>
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
