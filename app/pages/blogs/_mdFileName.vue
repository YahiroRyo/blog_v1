<template>
  <MdFileName genre="blog" :route-file-id="$route.params.mdFileName" />
</template>

<script lang="ts">
const MdFileName = () => import("~/components/MdFileName.vue");

export default {
  components: {
    MdFileName,
  },
};
</script>
