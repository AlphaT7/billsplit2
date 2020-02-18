import Vue from "vue";
import App from "./App.vue";

import { library } from "@fortawesome/fontawesome-svg-core";
import { faUsers } from "@fortawesome/free-solid-svg-icons";
import { faUtensils } from "@fortawesome/free-solid-svg-icons";
import { faFileInvoiceDollar } from "@fortawesome/free-solid-svg-icons";
import { faAt } from "@fortawesome/free-solid-svg-icons";
import { faWindowClose } from "@fortawesome/free-solid-svg-icons";
import { faPlusSquare } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faUsers);
library.add(faUtensils);
library.add(faFileInvoiceDollar);
library.add(faAt);
library.add(faPlusSquare);
library.add(faWindowClose);

Vue.component("font-awesome-icon", FontAwesomeIcon);
Vue.config.productionTip = false;

var BillSplit = new Vue({
  render: function(h) {
    return h(App);
  }
}).$mount("#app");
