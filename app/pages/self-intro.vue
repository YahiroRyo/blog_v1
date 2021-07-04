<template>
  <v-row justify="center" align-content="center">
    <link href="/mdFileName.css" rel="stylesheet" />
    <v-col cols="11">
      <div v-html="md"></div>
      <div v-html="$md.render('## 制作実績')"></div>
      <Genre num="-1" genre="works" />
      <div v-html="$md.render('## スキル')"></div>
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
import selfIntro from "~/assets/selfIntro.md";
const Skill = () => import("~/components/Skill.vue");
const Title = () => import("~/components/Title.vue");
const Genre = () => import("~/components/Genre.vue");

export default {
  components: {
    Title,
    Skill,
    Genre,
  },
  data(this: { $md: any }): any {
    return {
      md: selfIntro,
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
    };
  },
  created(this: { $store: Store<any> }): void {
    this.$store.commit(
      "windowState/setDescription",
      "YAPPIブログ | 自己紹介 エンジニアに役立つ情報をお届け(?) Laravel vue nuxt html css scss javascriptらへんやってます"
    );
  },
};
</script>
