<template>
  <div id="app">
    <div id="header">
      <h3>The Bill Splitting App</h3>
      <div id="breadcrumbs"></div>
    </div>
    <Main />
  </div>
</template>

<script>
import Main from "./components/Main.vue";

export default {
  name: "app",
  components: {
    Main
  }
};
</script>

<style>
html,
body {
  margin: 0;
  padding: 0;
  height: 100%;
  width: 100%;
}
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin: 0 auto;
  max-width: 500px;
  height: 100%;
  overflow-x: hidden;
  overflow-y: auto;
  background: #000;
  color: #fff;
  background: linear-gradient(to bottom, #1e5799 0%, #2989d8 50%, #7db9e8 100%);
}
h3,
div,
section {
  box-sizing: border-box;
  margin: 0;
}
#header {
  font-size: 25px;
  height: 20%;
  padding-top: 4%;
  font-weight: 600;
  line-height: 1em;
  text-align: center;
  text-shadow: rgba(0, 0, 0, 0.5) 0px 1px 2px;
}

#breadcrumbs {
  margin-top: 10px;
  background: rgba(255, 255, 255, 0.5);
  height: 40%;
}

.tabulator-cell {
  font-size: 30px !important;
}
</style>
