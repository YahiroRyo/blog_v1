export default function (context: any) {
    const router = context.$ROUTERS.find((r: any) => r.to === context.route.path);
    if (router) {
        context.store.commit('windowState/setTitle', router.title);
    }
}