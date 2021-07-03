<template>
  <MdFileName genre="work" :route-file-id="$route.query.fi" />
</template>

<script lang="ts">
const MdFileName = () => import("~/components/MdFileName.vue");

export default {
  components: {
    MdFileName,
  },
};
</script>
