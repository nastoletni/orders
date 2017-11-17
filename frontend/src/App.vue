<template>
  <div class="app">
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>

<style lang="less">
@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
@import './style/theme';

html {
  font-family: 'Source Sans Pro', Verdana, Helvetica, Arial, sans-serif;
  background: @background;
}
</style>
