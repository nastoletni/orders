<template>
  <div class="form-control" :class="{'force-column': forceColumn}">
    <div class="label" :class="{'force-column': forceColumn}">
      <label>{{label}}</label>
    </div>
    <div class="field">
      <slot>
        <BaseInputField v-bind="$attrs" v-on="$listeners" />
      </slot>
    </div>
  </div>
</template>

<script>
import BaseInputField from './BaseInputField'

export default {
  inheritAttrs: false,
  props: {
    label: {
      type: String,
      required: true
    },
    forceColumn: Boolean
  },
  components: {
    BaseInputField
  }
}
</script>

<style scoped lang="less">
@import '../style/theme';
.__force-column-label() {
  text-align: left;
  width: 100%;
  padding-right: 0;
  padding-bottom: 5px;
}
.form-control {
  display: flex;
  flex-direction: row;
  margin-top: 10px;
  @media (max-width: 801px) {
    flex-direction: column;
  }
  &.force-column {
    flex-direction: column;
  }
  .label {
    width: 20%;
    align-self: center;
    text-align: right;
    padding-right: 20px;
    font-weight: bold;
    @media (max-width: 801px) {
      .__force-column-label();
    }
    &.force-column {
      .__force-column-label();
    }
  }
  .field {
    width: 80%;
    @media (max-width: 801px) {
      width: calc(100% - 5px);
    }
  }
}
</style>
