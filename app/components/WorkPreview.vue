<template>
  <div>
    <v-row class="v-cursor-pointer" align-content="center" justify="center">
      <v-card
        :width="$vuetify.breakpoint.mobile ? '300' : '500'"
        height="550"
        @click.stop="$router.push(to)"
      >
        <v-img
          :src="img"
          :width="$vuetify.breakpoint.mobile ? '300' : '600'"
          :height="$vuetify.breakpoint.mobile ? '169' : '200'"
        >
        </v-img>
        <v-card-text
          class="body-1 font-weight-bold"
          :class="{ 'orange--text': genre == 'blogs', 'green--text': genre == 'works' }"
          >{{ genre[0].toUpperCase() + genre.slice(1) }}</v-card-text
        >
        <v-card-title>{{ title }}</v-card-title>
        <v-row justify="center" align-content="center">
          <v-col cols="11">
            <v-divider></v-divider>
            <h3 class="font-weight-medium mt-5 grey--text text--darken-1">Tags</h3>
            <div class="mt-2">
              <v-chip
                color="orange"
                class="mr-2 white--text"
                draggable
                label
                v-for="(tag, index) in tags"
                :key="index"
                @click.stop="$router.push(`/${genre}/search-tag?tag=${tag}`)"
                >{{ tag }}</v-chip
              >
            </div>
          </v-col>
        </v-row>
      </v-card>
    </v-row>
  </div>
</template>

<script lang="ts">
export default {
  props: ["img", "title", "tags", "genre", "to"],
};
</script>
