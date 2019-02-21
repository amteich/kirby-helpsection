import View from "./components/View.vue";

panel.plugin("mgfagency/documentation", {
  views: {
    documentation: {
      label: "Hilfe",
      icon: "check",
      menu: true,
      component: View
    }
  }
});
