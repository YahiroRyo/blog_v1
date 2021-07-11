export const state = () => ({
    titleMaxHeight: 0 as number,
    tagsMaxHeight: 0 as number,
});
export const mutations = {
  setTitleMaxHeight(state: { titleMaxHeight: number; }, titleMaxHeight: number): void {
    state.titleMaxHeight = titleMaxHeight;
  },
  setTagsMaxHeight(state: { tagsMaxHeight: number; }, tagsMaxHeight: number): void {
    state.tagsMaxHeight = tagsMaxHeight;
  },
};