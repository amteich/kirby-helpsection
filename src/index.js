import View from "./components/view.vue";

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
