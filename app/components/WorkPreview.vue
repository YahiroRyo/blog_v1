<template>
  <div>
    <v-row align-content="center" justify="center">
      <v-card
        :width="$vuetify.breakpoint.mobile ? '300' : '500'"
        min-height="550"
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
        <v-card-title ref="cardTitle"
          ><span :style="` margin-bottom: ${$store.state.card.maxHeight / 2}px`">{{
            title
          }}</span></v-card-title
        >
        <v-row justify="center" align-content="center">
          <v-col cols="11">
            <v-divider></v-divider>
            <div class="font-weight-medium mt-5 text-h6 grey--text text--darken-1">
              Tags
            </div>
            <div ref="cardTags" class="mt-2 mb-4">
              <v-chip
                color="orange"
                class="mr-2 mt-2"
                draggable
                outlined
                pill
                v-for="(tag, index) in tags"
                :key="index"
                @click.stop="$router.push(`/search-tag?tag=${tag}`)"
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
import { Store } from "vuex";

export default {
  props: ["img", "title", "tags", "genre", "to"],
  mounted(this: { $refs: { cardTitle: any; cardTags: any }; $store: Store<any> }): void {
    const titleHeight = this.$refs.cardTitle.clientHeight;
    const tagsHeight = this.$refs.cardTags.clientHeight;
    if (this.$store.state.card.titleMaxHeight < titleHeight) {
      this.$store.commit("card/setTitleMaxHeight", titleHeight);
    }
    if (this.$store.state.card.tagsMaxHeight < tagsHeight) {
      this.$store.commit("card/setTagsMaxHeight", tagsHeight);
    }
    setTimeout(() => {
      this.$refs.cardTitle.style.minHeight = `${this.$store.state.card.titleMaxHeight}px`;
      this.$refs.cardTags.style.minHeight = `${this.$store.state.card.tagsMaxHeight}px`;
    }, 50);
  },
  destroyed(this: { $store: Store<any> }) {
    if (this.$store.state.card.titleMaxHeight != 0) {
      this.$store.commit("card/setTitleMaxHeight", 0);
    }
    if (this.$store.state.card.tagsMaxHeight != 0) {
      this.$store.commit("card/setTagsMaxHeight", 0);
    }
  },
};
</script>
