const getCtx = (selector, ctx = getCurrentPages()[getCurrentPages().length - 1]) => {
    const componentCtx = ctx.selectComponent(selector)

    if (!componentCtx) {
        throw new Error('无法找到对应的组件，请按文档说明使用组件')
    }

    return componentCtx
}
const $startWuxRefresher = (selector) => {
    getCtx(selector ? selector : '#scroll').startRefreshByManual();
}
const $stopWuxRefresher = (flag, selector, ctx) => {
    getCtx(selector ? selector : '#scroll', ctx).finishRefreshByManual(flag);
}
const $stopWuxLoader = (flag, selector, ctx) => {
    getCtx(selector ? selector : '#scroll', ctx).finishLoadMore(flag);
}
const $scrollToTop = (toView, selector, ctx) => {
    getCtx(selector ? selector : '#scroll', ctx).scrollToView(toView);
}
export {
    $startWuxRefresher,
    $stopWuxRefresher,
    $stopWuxLoader,
    $scrollToTop
}