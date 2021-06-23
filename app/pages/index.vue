<template>
  <div>
    <v-row class="main-img" justify="center" align-content="center">
      <h1 class="text-h2 font-weight-thin main-img__title">
        知識欲のままに学習を続ける.
      </h1>
    </v-row>
    <TitleHome title="WORKS" />
    <Works num="3" />
    <TitleHome title="BLOGS" />
    <Blogs num="3" />
  </div>
</template>

<style lang="scss" scoped>
@import "~assets/scss/index.scss";
</style>

<script>
import Blogs from "~/components/Blogs.vue";
import Works from "~/components/Works.vue";
import TitleHome from "~/components/TitleHome.vue";
export default {
  components: {
    Blogs,
    Works,
    TitleHome,
  },
};
</script>
