<template>
    <div class="panel" :class="{slim, error}">
        <slot></slot>
    </div>
</template>

<script>
export default {
  props: {
    slim: Boolean,
    error: Boolean
  }
}
</script>

<style scoped lang="less">
@import '../style/theme';

.panel {
  .shadow();
  border-top-width: 3px;
  border-top-style: solid;
  border-image: @panel-border-gradient 1;
  background: #fff;
  margin-top: 30px;
  margin-bottom: 30px;
  padding: 50px;
  &.slim {
      padding: 10px;
      margin-bottom: 30px;
  }
  &.error {
      border-image: @error-gradient 1;
  }
}
</style>
