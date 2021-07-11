export const state = () => ({
    scrollX: 0 as number,
    scrollY: 0 as number,
    title: '' as string,
    baseUrl: '' as string,
});

export const mutations = {
  setScrollX(state: { scrollX: number; }, scrollX: number): void {
    state.scrollX = scrollX;
  },
  setScrollY(state: { scrollY: number; }, scrollY: number): void {
    state.scrollY = scrollY;
  },
  setTitle(state: { title: string; }, title: string): void {
    state.title = title;
  },
  setBaseUrl(state: { baseUrl: string }, baseUrl: string): void {
    state.baseUrl = baseUrl;
  }
};