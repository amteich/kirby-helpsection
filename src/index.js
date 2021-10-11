import View from "./components/view.vue";

panel.plugin("amteich/helpsection", {

  components: {
    'k-helpsection-view': View
  },

  icons: {
    'amteichhelpsection': '<path d="M8,0C3.6,0,0,3.6,0,8s3.6,8,8,8s8-3.6,8-8S12.4,0,8,0z M8,14c-3.3,0-6-2.7-6-6s2.7-6,6-6s6,2.7,6,6 S11.3,14,8,14z"></path><circle cx="8" cy="12" r="1"></circle><path d="M7.1,5.5C7.3,5.2,7.6,5,8,5c0.6,0,1,0.4,1,1c0,0.3-0.1,0.4-0.6,0.7C7.8,7.1,7,7.7,7,9v1h2V9 c0-0.2,0-0.3,0.5-0.6C10.1,8,11,7.4,11,6c0-1.7-1.3-3-3-3C6.9,3,5.9,3.6,5.4,4.5L4.9,5.4l1.7,1L7.1,5.5z"></path>'
  }

});
