export const state = () => ({
    scrollX: 0 as Number,
    scrollY: 0 as Number,
    isMobile: false as boolean,
    title: '' as string,
});

export const mutations = {
  setScrollX(state: { scrollX: Number; }, scrollX: Number): void {
    state.scrollX = scrollX;
  },
  setScrollY(state: { scrollY: Number; }, scrollY: Number): void {
    state.scrollY = scrollY;
  },
  setIsMobile(state: { isMobile: boolean; }, isMobile: boolean): void {
    state.isMobile = isMobile;
  },
  setTitle(state: { title: string; }, title: string): void {
    state.title = title;
  }
};