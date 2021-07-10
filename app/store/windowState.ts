export const state = () => ({
    scrollX: 0 as Number,
    scrollY: 0 as Number,
    title: '' as string,
    baseUrl: '' as string,
});

export const mutations = {
  setScrollX(state: { scrollX: Number; }, scrollX: Number): void {
    state.scrollX = scrollX;
  },
  setScrollY(state: { scrollY: Number; }, scrollY: Number): void {
    state.scrollY = scrollY;
  },
  setTitle(state: { title: string; }, title: string): void {
    state.title = title;
  },
  setBaseUrl(state: { baseUrl: string }, baseUrl: string): void {
    state.baseUrl = baseUrl;
  }
};