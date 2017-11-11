<template>
  <input :type="type || 'text'" v-bind="$attrs" v-on="listeners" v-if="type !== 'textarea'" :class="{error}" />
  <textarea v-else-if="type === 'textarea'" v-bind="$attrs" v-on="listeners" :class="{error}" />
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'text'
    },
    error: Boolean
  },
  computed: {
    listeners() {
      return {
        ...this.$listeners,
        input: ev => this.$emit('input', ev.target.value)
      }
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
  transition: all 0.1s ease-in-out;
  transition-property: margin-bottom, border-bottom-width;
  &:focus {
    margin-bottom: 0;
    border-bottom-width: 3px;
    border-bottom-style: solid;
    border-image: @panel-border-gradient 1;
  }
  &.error:not(:focus) {
    margin-bottom: 0;
    border-bottom-width: 3px;
    border-bottom-style: solid;
    border-image: @error-gradient 1;
  }
}
</style>
