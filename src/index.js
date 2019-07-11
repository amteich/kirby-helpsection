import View from "./components/view.vue";

panel.plugin("mgfagency/helpsection", {
  views: {
    helpsection: {
      icon: "wand",
      menu: true,
      component: View
    }
  }
});
