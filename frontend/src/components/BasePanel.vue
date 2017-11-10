<template>
    <div class="panel">
        <slot></slot>
    </div>
</template>

<script>
export default {}
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
}
</style>
