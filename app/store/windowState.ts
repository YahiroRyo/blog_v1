export const state = () => ({
    scrollX: 0 as Number,
    scrollY: 0 as Number,
});

export const mutations = {
  setScrollX(state: { scrollX: Number; }, scrollX: Number): void {
    state.scrollX = scrollX;
  },
  setScrollY(state: { scrollY: Number; }, scrollY: Number): void {
    state.scrollY = scrollY;
  },
};