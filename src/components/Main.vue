<template>
  <section id="page_main">
    <div id="panel" class="full_screen" :class="{ show_full_screen: show_panel != false }">
      <div class="panel_title">
        <span class="panel_title_text">new {{ group }}</span>
        <span class="right">
          <font-awesome-icon
            @click="
              {
                show_panel = false;
              }
            "
            icon="window-close"
          />
        </span>
      </div>

      <div :key="index" v-for="(value, index) in panelfields" class="panel_fields">
        <input
          :key="x"
          type="text"
          v-for="x in Object.keys(value)"
          v-model="value[x]"
          :placeholder="x"
        />
      </div>

      <div class="panel_buttons">
        <div v-if="!newrecord" @click="update_record()">Update</div>&nbsp;
        <div v-if="!newrecord" @click="delete_record()">Delete</div>
        <div v-if="newrecord" @click="add_record()">Save</div>
        <div v-if="!newrecord & tab == 'restaurants'">Add Menu</div>
      </div>
    </div>

    <!--------- MENU BUTTONS START --------->
    <section id="btn_group">
      <div
        id="btn_customers"
        class="btn btn_customers"
        @click="tab = 'customers', group = 'customer', newrecord = false"
      >
        <font-awesome-icon icon="users" />
      </div>
      <div
        id="btn_restaurants"
        class="btn btn_restaurants"
        @click="tab = 'restaurants', group = 'restaurant', newrecord = false"
      >
        <font-awesome-icon icon="utensils" />
      </div>
      <div
        id="btn_orders"
        class="btn btn_orders"
        @click="tab = 'orders', group = 'order', newrecord = false"
      >
        <font-awesome-icon icon="file-invoice-dollar" />
      </div>
      <div
        id="btn_about"
        class="btn btn_about"
        @click="tab = 'about', group = 'about', newrecord = false"
      >
        <font-awesome-icon icon="at" />
      </div>
    </section>
    <!--------- MENU BUTTONS STOP --------->

    <section class="tab data_customers" :class="{ showtab: tab == 'customers' }">
      <div class="title">
        <h2>Customers</h2>
        <span class="new_record" @click="newrecord = true,new_record()">
          <font-awesome-icon icon="plus-square" />
        </span>
      </div>
      <div class="tabulator_container">
        <CustomerData v-model="cdata" :options="customer_options" />
      </div>
    </section>
    <section class="tab data_restaurants" :class="{ showtab: tab == 'restaurants' }">
      <div class="title">
        <h2>Restaurants</h2>
        <span class="new_record" @click="newrecord = true,new_record()">
          <font-awesome-icon icon="plus-square" />
        </span>
      </div>
      <div class="tabulator_container">
        <RestaurantData v-model="rdata" :options="restaurant_options" />
      </div>
    </section>

    <section class="tab data_orders" :class="{ showtab: tab == 'orders' }">Orders</section>

    <section class="tab data_about" :class="{ showtab: tab == 'about' }">
      <figure id="logo">
        <img src="img/wwlogo.png" />
        <figcaption>
          <span class="text">&lt; Developed By /&gt;</span>
          <p class="text">
            W
            <span class="neg_margin">
              <span class="stack still" :class="{ bouncing: tab == 'about' }">.</span>
              <span class="stack">ı</span>
            </span>
            nters Webs
          </p>
        </figcaption>
      </figure>
    </section>
  </section>
</template>

<script>
import axios from "axios";
import qs from "qs";
import { TabulatorComponent } from "vue-tabulator";

export default {
  components: {
    name: "Main",
    CustomerData: TabulatorComponent,
    RestaurantData: TabulatorComponent
  },
  data() {
    return {
      tab: "", // which tab is displayed (e.g. "Customers");
      //currentPanel: null, // which panel is displayed (e.g. "Edit Customer");
      show_panel: false, // whether to display the panel or not;
      panelfields: [{}], // json object with the panel fields;
      group: "", // determines which php file will be called by axios;
      newrecord: true,
      cdata: [
        // tabulator table data;
        { placeholder: "" }
      ],
      rdata: [
        // tabulator table data;
        { placeholder: "" }
      ],
      customer_options: {
        // tabulator table structure;
        rowClick: this.customer_rowClick,
        layout: "fitColumns",
        columns: [
          {
            title: "ID",
            field: "id",
            sorter: "string",
            visible: false
          },
          {
            title: "First",
            field: "f_name",
            sorter: "string",
            editor: false
          },
          {
            title: "Last",
            field: "l_name",
            sorter: "string",
            editor: false
          }
        ]
      },
      restaurant_options: {
        // tabulator table structure;
        rowClick: this.restaurant_rowClick,
        dataTree: true,
        dataTreeStartExpanded: false,
        layout: "fitColumns",
        columns: [
          {
            title: "ID",
            field: "id",
            sorter: "string",
            visible: false
          },
          {
            title: "IID",
            field: "iid",
            sorter: "string",
            visible: false
          },
          {
            title: "Name",
            field: "rname",
            sorter: "string",
            editor: false
          }
        ]
      }
    };
  },
  methods: {
    customer_rowClick: function(e, row) {
      // For axios POST, be sure to use the qs npm module; php $_POST will not get the request otherwise.
      axios
        .post(
          "php/getcustomer.php",
          qs.stringify({
            id: row.getCell("id").getValue()
          })
        )
        .then(response => {
          this.newrecord = false;
          this.show_panel = true;
          this.panelfields = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    restaurant_rowClick: function(e, row) {
      if (row.getCell("id").getValue() !== undefined) {
        // For axios POST, be sure to use the qs npm module; php $_POST will not get the request otherwise.
        axios
          .post(
            "php/getrestaurant.php",
            qs.stringify({
              id: row.getCell("id").getValue()
            })
          )
          .then(response => {
            this.group = "restaurant";
            this.newrecord = false;
            this.show_panel = true;
            this.panelfields = response.data;
          })
          .catch(error => {
            console.log(error);
          });
      } else {
        axios
          .post(
            "php/getmenuitem.php",
            qs.stringify({
              iid: row.getCell("iid").getValue()
            })
          )
          .then(response => {
            this.group = "menu item";
            this.newrecord = false;
            this.show_panel = true;
            this.panelfields = response.data;
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    update_record: function() {
      axios
        .post(
          "php/update" + this.group + ".php",
          qs.stringify(this.panelfields)
        )
        .then(response => {
          axios.get("php/get" + this.group + "s.php").then(response => {
            this.choose_datafields(response.data);
          });
          console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });
    },
    add_record: function() {
      axios
        .post("php/add" + this.group + ".php", qs.stringify(this.panelfields))
        .then(response => {
          axios.get("php/get" + this.group + "s.php").then(response => {
            this.choose_datafields(response.data);
          });
          this.show_panel = false;
        })
        .catch(error => {
          console.log(error);
        });
    },
    delete_record: function() {
      var r = confirm("Are you sure you with to delete this record?");
      if (r == true) {
        axios
          .post(
            "php/delete" + this.group + ".php",
            qs.stringify({ id: this.panelfields[0].id })
          )
          .then(response => {
            axios.get("php/get" + this.group + "s.php").then(response => {
              this.choose_datafields(response.data);
            });
            this.show_panel = false;
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    new_record: function() {
      switch (this.group) {
        case "customer":
          this.panelfields = [
            { id: "", f_name: "", l_name: "", nickname: "", email: "" }
          ];
          break;
        case "restaurant":
          this.panelfields = [
            { id: "", rname: "", city: "", phone: "", website: "" }
          ];
          break;
        default:
          break;
      }
      this.show_panel = true;
    },
    panel_height: function() {
      document.querySelector("#panel").style.height =
        document.body.scrollHeight + "px";
    },
    choose_datafields: function(data) {
      switch (this.group) {
        case "customer":
          this.cdata = data;
          break;

        case "restaurant":
          this.rdata = data;
          break;

        case "order":
          //this.odata = data;
          break;

        default:
          break;
      }
    }
  },
  created() {
    axios.get("php/getcustomers.php").then(response => {
      this.cdata = response.data;
    });
    axios.get("php/getrestaurants.php").then(response => {
      this.rdata = response.data;
    });
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
@import "~tabulator-tables/dist/css/tabulator_midnight.css";
/* --- MAIN PAGE CSS --- */
#page_main {
  height: 80%;
  position: relative;
  overflow-x: hidden;
  overflow-y: auto;
}

#btn_group {
  height: 100%;
  width: 25%;
  position: absolute;
  left: 0;
  bottom: 0;
  z-index: 10000;
}

.btn_customers {
  background-image: linear-gradient(to top, #f2f2f2, #70a25f);
}

.btn_restaurants {
  background-image: linear-gradient(to top, #f2f2f2, #9e3939);
}

.btn_orders {
  background-image: linear-gradient(to top, #f2f2f2, #b3b3b3);
}

.btn_about {
  background-image: linear-gradient(to top, #f2f2f2, #39589e);
}

.btn {
  width: 100%;
  font-size: 60px;
  padding-top: 35%;
  height: 25%;
  color: #fff;
  font-weight: 600;
  line-height: 1em;
  text-align: center;
  text-shadow: rgba(0, 0, 0, 0.5) 0px 1px 2px;
  cursor: pointer;
  -webkit-touch-callout: none; /* iOS Safari */
  user-select: none; /* Non-prefixed version, currently supported by Chrome and Opera */
  -webkit-tap-highlight-color: transparent;
  border: 1px solid #fff;
}
.btn:hover {
  background: #b3b3b3;
  border-right: 0px;
  text-shadow: rgba(0, 0, 0, 0.3) 0px 0px 2px;
  box-shadow: inset rgba(0, 0, 0, 0.5) 2px 2px 2px;
}
.btn:focus {
  text-shadow: rgba(0, 0, 0, 0.3) 0px 0px 2px;
  box-shadow: inset rgba(0, 0, 0, 0.5) 0px 1px 4px;
  background: #b3b3b3;
  border-right: 0px;
}
.showtab {
  display: block !important;
  left: 25% !important;
  opacity: 100 !important;
}

.tabulator_container {
  height: 50%;
}

/* --- ABOUT DATA CSS --- */

.data_customers {
  z-index: 1;
}

.data_restaurants {
  z-index: 2;
}

.data_orders {
  z-index: 3;
}

.data_about {
  z-index: 4;
}

.tab {
  position: absolute;
  width: 75%;
  height: 100%;
  left: -75%;
  top: 0;
  opacity: 0;
  background: #b3b3b3;
  border-top: 1px solid #fff;
  transition: all 1s;
  overflow-y: auto;
  overflow-x: hidden;
  word-wrap: break-word;
}

.title {
  color: #fff;
  background: rgba(0, 0, 0, 0.75);
  text-align: center;
  position: sticky;
  top: 0;
  height: 50px;
  padding: 120x;
}

.title h2 {
  margin: 0;
  padding: 8px 0 0 0;
}

.new_record {
  position: absolute;
  right: 0;
  top: 0;
  font-size: 40px;
  margin: 3px 7px;
  cursor: pointer;
}

@keyframes bounce {
  0% {
    transform: translate3d(0, 0, 0);
  }
  50% {
    transform: translate3d(0, -15px, 0);
  }
  100% {
    transform: translate3d(0, 0, 0);
  }
}

.bouncing {
  animation: bounce 0.6s;
  animation-iteration-count: 4;
}

.still {
  margin-bottom: -8px;
}

.text {
  margin: 0;
  padding: 0 0 10px 0;
  font-size: 16px;
  font-family: "Lucida Sans", "Lucida Sans Regular", "Lucida Grande",
    "Lucida Sans Unicode", Geneva, Verdana, sans-serif;
  font-weight: 600;
  line-height: 1em;
  text-shadow: rgba(0, 0, 0, 0.5) 0px 1px 2px;
}

p.text {
  font-size: 26px;
}

span {
  display: inline-block;
}

.stack {
  display: block;
}

.neg_margin {
  margin: 0 -6px 0 -6px;
}

#logo {
  border-top: 1px solid #fff;
  border-bottom: 1px solid #fff;
  width: 100%;
  text-align: center;
  margin: 50% 0 0 0;
  background: #ccc;
  box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.75);
}

/* --- FULL SCREEN DIV --- */
.full_screen {
  position: fixed;
  background: rgba(255, 255, 255, 0);
  transition: opacity 0.5s;
  width: 100%;
  height: 100%;
  max-width: 500px;
  z-index: -10000;
  border: 1px solid #000;
  opacity: 0;
  box-shadow: 0px 0px 40px 0px rgba(0, 0, 0, 0.75);
  bottom: 0;
}

.show_full_screen {
  background: rgba(0, 0, 0, 0.85);
  z-index: 10001;
  opacity: 1;
}

.right {
  right: 0;
  position: relative;
  font-size: 35px;
  color: #fff;
  padding: 4px 7px;
  float: right;
  cursor: pointer;
}

.panel_fields {
  text-align: center;
}

.panel_fields input[type="text"] {
  width: 75%;
  margin: 2% 0 2% 0;
  border-radius: 5px;
  padding: 3px 7px 3px 3px;
  font-size: 25px;
  font-weight: bold;
}

.panel_fields input[type="text"]:nth-child(1) {
  display: none;
}

.panel_title {
  height: 47px;
  position: relative;
  margin-bottom: 15px;
  background: #1e5799;
}

.panel_title_text {
  text-transform: capitalize;
  font-size: 25px;
  padding: 8px 0 0 30px;
}

.panel_buttons {
  margin-top: 2%;
  text-align: center;
}

.panel_buttons div {
  display: inline-flex;
  cursor: pointer;
  padding: 5px 35px 5px 35px;
  border-radius: 5px;
  font-size: 25px;
  font-weight: bold;
  align-items: center;
  background: linear-gradient(to top, #1e5799 0%, #2989d8 50%, #7db9e8 100%);
}

.panel_buttons div:nth-child(2) {
  background: linear-gradient(to top, #9e3939 0%, #d82929 50%, #e87d7d 100%);
}

.panel_buttons div:nth-child(3) {
  margin: 5px 0 0 5px;
  background: linear-gradient(to top, #419e39 0%, #4cd829 50%, #92e87d 100%);
}

@media only screen and (max-width: 320px) {
  .btn {
    font-size: 35px;
  }
}
</style>
