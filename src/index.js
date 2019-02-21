import View from "./components/view.vue";

panel.plugin("mgfagency/helpsection", {
  views: {
    documentation: {
      label: "Hilfe",
      icon: "check",
      menu: true,
      component: View
    }
  }
});
