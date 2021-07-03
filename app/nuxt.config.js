import colors from 'vuetify/es5/util/colors'

export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: true,
  // Target: https://go.nuxtjs.dev/config-target
  target: 'static',
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s | YAPPI BLOG',
    title: 'app',
    htmlAttrs: {
      lang: 'en'
    },
    script: [
    ],
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { property: "og:site_name", content: "YAPPI BLOG" },
      { property: "og:type", content: "website|article" },
      { name: "twitter:card", content: "summary_large_image" },
      { name: "twitter:site", content: "@Yappisec" },
      { name: "twitter:creator", content: "@Yappisec" },
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  serverMiddleware: ["~/middleware/response-header.ts"],
  router: {
    middleware: "titleMiddleware",
    extendRoutes (routes, resolve) {
      routes.push({
        name: 'custom',
        path: '*',
        component: resolve(__dirname, 'pages/errors/404.vue')
      });
      for (const key in routes) {
        routes[key].caseSensitive = true;
      }
    }
  },
  generate: {
    fallback: true,
  },
  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    { src: '~/plugins/constants.ts' },
    { src: '~/plugins/axios-accessor.ts' }
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/typescript
    '@nuxt/typescript-build',
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    '@nuxtjs/markdownit',
    '@nuxtjs/axios',
    // ['@nuxtjs/google-adsense', {
    //   id: 'ca-pub-3291128098360922',
    //   pageLevelAds: true,
    //   analyticsUacct: 'UA-XXX-X',
    //   analyticsDomainName: 'https://stupefied-ramanujan-ce7604.netlify.app'
    // }]
  ],
  markdownit: {
    preset: 'default',
    html: true,
    linkify: true,
    typography: true,
    breaks: true,
    use: ['markdown-it-div', 'markdown-it-attrs', 'markdown-it-anchor', ['markdown-it-table-of-contents', {
      includeLevel: [1, 2, 3],
      listType: 'ol',
      containerClass: 'table-of-contents',
    }]],
  },

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    theme: {
      dark: false,
      themes: {
        dark: {
          primary: colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3
        }
      }
    }
  },
  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },
  axios: {
    proxy: true,
    prefix: '/api/',
  },
  proxy: {
    '/api/': {target: process.env.API_URL, pathRewrite: {'^/api/': '/'}}
  },
}
