<template>
  <div>
    <v-row class="main-img" justify="center" align-content="center">
      <h1 class="text-h2 font-weight-thin main-img__title">
        知識欲のままに学習を続ける.
      </h1>
    </v-row>
    <Title title="WORKS" />
    <Genre genre="works" num="3" />
    <Title title="BLOGS" />
    <Genre genre="blogs" num="3" />
  </div>
</template>

<style lang="scss" scoped>
@import "~assets/scss/index.scss";
</style>

<script>
import Genre from "~/components/Genre.vue";
import Title from "~/components/Title.vue";
export default {
  components: {
    Genre,
    Title,
  },
};
</script>
