<template>
  <WorkController
    :genre="$route.params.genre"
    :mode="$route.query.mode"
    :fileId="$route.query.fileId ? $route.query.fileId : ''"
  />
</template>

<script lang="ts">
const WorkController = () => import("~/components/WorkController.vue");

export default {
  components: {
    WorkController,
  },
  head(): any {
    return {
      meta: [{ name: "robots", content: "noindex" }],
    };
  },
};
</script>
