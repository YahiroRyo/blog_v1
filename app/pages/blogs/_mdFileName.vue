<template>
  <MdFileName genre="blog" :route-file-id="$route.params.mdFileName" />
</template>

<script lang="ts">
import MdFileName from "~/components/MdFileName.vue";

export default {
  components: {
    MdFileName,
  },
};
</script>
