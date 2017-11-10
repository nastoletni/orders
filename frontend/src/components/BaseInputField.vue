<template>
    <input :type="type || 'text'" v-bind="$attrs" v-on="$listeners" v-if="type !== 'textarea'" />
    <textarea v-bind="$attrs" v-on="$listeners" v-else-if="type === 'textarea'" />
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    type: {
      type: String,
      default: 'text'
    }
  }
}
</script>

<style scoped lang="less">
@import '../style/theme';

input,
textarea {
  font-size: 14px;
  font-family: inherit;
  width: calc(100% - 10px);
  border: 1px solid @muted-color;
  padding: 15px 20px;
  outline: none;
  margin-bottom: 2px; // add margin to compensate for border-bottom expanding
  transition: 0.1s;
  &:focus {
    margin-bottom: 0;
    border-bottom-width: 3px;
    border-bottom-style: solid;
    border-image: @panel-border-gradient 1;
  }
}
</style>
