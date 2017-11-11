<template>
  <button class="button" type="button" v-bind="$attrs" v-on="$listeners">
    <slot></slot>
  </button>
</template>

<script>
export default {}
</script>

<style scoped lang="less">
@import '../style/theme';

.button {
  .shadow();
  outline: none;
  border: none;
  text-decoration: none;
  background: @primary-color;
  color: white;
  padding: 15px 15px;
  font-size: 15px;
  cursor: pointer;
  transition: all 1s;
  border-bottom-width: 3px;
  border-bottom-style: solid;
  border-image: @panel-border-gradient 1;
  &:hover {
    background: darken(@primary-color, 15%);
  }
  &:disabled {
    border-image: @disabled-gradient 1;
    background: @muted-color;
    cursor: not-allowed;
  }
}
</style>
