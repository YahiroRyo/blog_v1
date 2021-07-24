import colors from 'vuetify/es5/util/colors'
import redirectSSL from 'redirect-ssl';
const axios = require('axios')

export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  mode: 'universal',
  // Target: https://go.nuxtjs.dev/config-target
  target: 'server',
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s | YAPPI BLOG',
    htmlAttrs: {
      lang: 'ja'
    },
    script: [
    ],
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'og:site_name', property: "og:site_name", content: "YAPPI BLOG" },
      { hid: 'og:type', property: "og:type", content: "website|article" },
      { hid: 'twitter:card', name: "twitter:card", content: "summary_large_image" },
      { hid: 'twitter:site', name: "twitter:site", content: "@Yappisec" },
      { hid: 'twitter:creator', name: "twitter:creator", content: "@Yappisec" },
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  serverMiddleware: [
    // "~/middleware/response-header.ts",
    redirectSSL.create({enabled: process.env.NODE_ENV === 'production'}),
  ],
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
    { src: '~/node_modules/highlight.js/styles/atom-one-dark.css', lang: 'css' }
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
    '@nuxtjs/sitemap',
    '@nuxtjs/robots',
  ],
  robots: {
    UserAgent: '*',
    // sitemap.xmlのURLを記述
    Sitemap: 'https://yappi-blog.herokuapp.com/sitemap.xml',
  },
  sitemap: {
    path: '/sitemap.xml',
    hostname: 'https://yappi-blog.herokuapp.com',
    cacheTime: 1000 * 60 * (60 * 24),
    generate: true,
    gzip: true,
    exclude: [
      '/search-tag',
      '/blogs/watch',
      '/works/watch',
      '/errors/404',
      '/blogs/watch',
      '/works/watch',
    ],
    async routes(callback) {
      const param = {
        params: {
          num: 50,
          sum: 0,
        }
      };
      return Promise.all([
        axios.get('https://yappi-blog.herokuapp.com/api/blogs/get', param),
        axios.get('https://yappi-blog.herokuapp.com/api/works/get', param),
      ])
      .then(([blogs, works]) => {
        let exp01 = blogs.data.map(contact => '/blogs/watch?fi=' + contact.fileId);
        let exp02 = works.data.map(contact => '/works/watch?fi=' + contact.fileId);
        let array = [exp01, exp02];
        let flattened = array.reduce(
          (accumulator, currentValue) => accumulator.concat(currentValue),
          []
        );
        callback(null, flattened)
      }).catch(callback)
    }
  },
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
    highlight: (str, lang) => {
      const hljs = require('highlight.js');
      if (lang && hljs.getLanguage(lang)) {
        try {
          return '<pre class="hljs"><code>' +
                  hljs.highlight(lang, str, true).value +
                  '</code></pre>';
        } catch (__) {}
      }
      // 言語設定がない場合、プレーンテキストとして表示する
      return '<pre class="hljs"><code>' +  hljs.highlight('plaintext', str, true).value + '</code></pre>';
    },
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
    extend(config, { isDev, isClient }) {
      if (isClient) {
        config.node = {
          fs: 'empty',
          child_process: 'empty',
          tls: 'empty',
          net: 'empty'
        }
      }
    }
  },
  axios: {
    proxy: true,
    prefix: '/api/',
  },
  proxy: {
    '/api/': {target: process.env.API_URL, pathRewrite: {'^/api/': '/'}}
  },
}
