import View from "./components/view.vue";

panel.plugin("mgfagency/helpsection", {
  views: {
    helpsection: {
      label: "Hilfe",
      icon: "wand",
      menu: true,
      component: View
    }
  }
});
