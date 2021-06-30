<template>
  <v-row cols="15" justify="center" align-content="center">
    <v-col cols="12">
      <Title class="mb-5" title="スキル一覧" />
      <Skill
        v-for="(skill, index) in skills"
        :key="index"
        :lang="skill.lang"
        :explain="skill.explain"
        :icon="skill.icon"
        class="mt-2"
      />
    </v-col>
  </v-row>
</template>
<script lang="ts">
import { Store } from "vuex";

const Skill = () => import("~/components/Skill.vue");
const Title = () => import("~/components/Title.vue");

export default {
  components: {
    Title,
    Skill,
  },
  data(): any {
    return {
      skills: [
        {
          lang: "HTML",
          explain: "Webの言語に興味があったため",
          icon: "language-html5",
        },
        {
          lang: "CSS",
          explain: "Webの言語に興味があったため",
          icon: "language-css3",
        },
        {
          lang: "JavaScript",
          explain: "Webの言語に興味があったため",
          icon: "language-javascript",
        },
        {
          lang: "Vue.js",
          explain: "Webの言語に興味があったため",
          icon: "vuejs",
        },
        {
          lang: "PHP",
          explain: "Webの言語に興味があったため",
          icon: "language-php",
        },
        {
          lang: "Laravel",
          explain: "Webの言語に興味があったため",
          icon: "laravel",
        },
        {
          lang: "Docker",
          explain: "Webの言語に興味があったため",
          icon: "docker",
        },
        {
          lang: "Git",
          explain: "Webの言語に興味があったため",
          icon: "git",
        },
        {
          lang: "GitHub",
          explain: "Webの言語に興味があったため",
          icon: "github",
        },
        {
          lang: "Python",
          explain: "Webの言語に興味があったため",
          icon: "language-python",
        },
        {
          lang: "C#",
          explain: "Webの言語に興味があったため",
          icon: "language-csharp",
        },
      ],
    } as any;
  },
  created(this: { $store: Store<any> }): void {
    this.$store.commit(
      "windowState/setDescription",
      "YAPPIブログ | スキル一覧 エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます"
    );
  },
};
</script>
