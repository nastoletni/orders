<template>
  <div class="smroot">
    <div class="label">
      <label>{{label}}</label>
    </div>
    <div class="number-control" v-if="amount">
      <BaseButton type="button" @click="add(-1)" :disabled="value === 0">-</BaseButton>
      <BaseInputField type="number" @input="$emit('input', $event)" :value="value" />
      <BaseButton type="button" @click="add(1)">+</BaseButton>
    </div>
    <div class="number-control" v-else />
    <BaseInputField type="text" class="price" :value="price" readonly/>
  </div>
</template>

<script>
import BaseFormControl from './BaseFormControl'
import BaseButton from './BaseButton'
import BaseInputField from './BaseInputField'

export default {
  data() {
    return {
      inputFocused: false
    }
  },
  props: {
    label: {
      type: String,
      required: true
    },
    value: {
      type: [String, Number]
    },
    price: {
      type: String
    },
    amount: {
      type: Boolean,
      default: true
    }
  },
  methods: {
    add(n) {
      let v = parseInt(this.value)
      if (isNaN(v)) {
        return this.$emit('input', '1')
      }
      return this.$emit('input', v + n)
    }
  },
  components: {
    BaseFormControl,
    BaseButton,
    BaseInputField
  }
}
</script>

<style scoped lang="less">
@import '../style/theme';

.smroot {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  margin-bottom: 10px;
  .label {
    width: 40%;
    align-self: center;
    text-align: left;
    padding-right: 20px;
    font-weight: bold;
  }
  .number-control {
    width: 30%;
  }
  .price {
    width: 20%;
    margin-right: 6px;
    margin-left: 10px;
  }
}

.number-control {
  display: flex;
  flex-direction: row;
  align-items: stretch;
  input {
    text-align: right;
  }
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  button {
    margin-bottom: 2px;
    width: 50px;
    border-bottom-width: 0;
  }
}
</style>
