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
        icon: 'mdi-notebook-outline',
        isHide: false,
        title: 'ブログ一覧',
    },
    {
        to: "/works",
        icon: 'mdi-code-not-equal-variant',
        isHide: false,
        title: '作品',
    },
    {
        to: "/skills",
        icon: 'mdi-arm-flex',
        isHide: false,
        title: 'スキル',
    },
    {
        to: "/self-intro",
        icon: 'mdi-account',
        isHide: false,
        title: '自己紹介',
    },
    {
        to: "/search-tag",
        icon: '',
        isHide: true,
        title: 'タグで検索',
    },
] as Array<any>

export default (context: Context, inject: Function) => {
    inject('ROUTERS', ROUTERS)
}