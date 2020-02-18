<template>
  <section class="outer">
    <div class="title">Edit Customer</div>
    <div class="row">
      <input type="text" v-model="fname" />
    </div>
    <div class="row">
      <input type="text" v-model="lname" />
    </div>
    <div class="row">
      <input type="text" />
    </div>
    <div class="row">
      <input type="text" />
    </div>
    <button :click="getCustomerData()"></button>
  </section>
</template>

<script>
import { mapState, mapGetters, mapMutations } from "vuex";

export default {
  components: {
    name: "Edit Customer"
  },
  data() {
    return {
      fname: null,
      lname: null
    };
  },
  methods: {
    getCustomerData() {
      let data = mapGetters("mEditCustomer", "getCustomer");
      console.log(data);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.outer {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  border: 1px solid #000;
  background: rgba(255, 255, 255, 0.75);
  position: absolute;
  z-index: 100001;
}
</style>
