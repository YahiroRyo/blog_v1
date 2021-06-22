import { Context } from '@nuxt/types';

const ROUTERS = [
    {
        to: "/",
        icon: 'mdi-home',
        isHide: false,
        title: 'ホーム',
    },
    {
        to: "/blogs",
        icon: 'mdi-code-not-equal-variant',
        isHide: false,
        title: 'ブログ一覧',
    },
    {
        to: "/self-intro",
        icon: 'mdi-account',
        isHide: false,
        title: '自己紹介',
    },
] as Array<any>

export default (context: Context, inject: Function) => {
    inject('ROUTERS', ROUTERS)
}