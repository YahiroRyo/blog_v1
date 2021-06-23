FROM node:16-alpine3.11

RUN curl -o- -L https://yarnpkg.com/install.sh | sh && \
yarn add \
@vue/cli \
@vue/cli-service-global \
nuxt \
create-nuxt-app \
@nuxt/types \
@nuxt/typescript-build \
@nuxtjs/axios \
nuxt-typed-vuex \
@nuxtjs/markdownit \
markdown-it-attrs \
markdown-it-div 

RUN mkdir /home/app
WORKDIR /home/app
