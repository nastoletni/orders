<template>
  <BaseContainer>
    <BasePanel>
      <form>
        <BaseAnimatedFold :show="showForm">
          <h1>Złóż zamówienie</h1>
          <BasePanel slim error v-if="error">
            <p>{{error}}</p>
          </BasePanel>
          <BaseFormControl v-for="field in fields" :key="field.name" :label="field.label" :type="field.type || 'text'" v-model="field.value" @focus="field.hasBeenFocused = true" :error="getFieldError(field)" />

          <BaseDivider />
          <BaseNumberControl v-for="item in items" :key="item.name" :label="item.name" v-model="item.amount" :price="(item.amount * item.price).toFixed(2) + ' zł'" />
          <BaseDivider />
          <div class="bottom-columns">
            <div class="spacer"></div>
            <BaseButton @click="placeOrder" :disabled="submitButtonDisabled">Złóż zamówienie</BaseButton>
            <input type="text" readonly class="total" :value="total" />
          </div>
        </BaseAnimatedFold>
        <BaseAnimatedFold :show="!showForm">
          <BaseCircularIndicator :state="state" />
        </BaseAnimatedFold>
        <BaseAnimatedFold :show="state === 'SUCCESS'">
          <p>Zamówienie zostało złożone</p>
          <p>
            Wykonaj przelew z tytułem
            <code>Zamówienie nr {{orderId}}</code> na kwotę {{orderTotal}} zł na rachunek:
            <code>Albert Wolszon 15 1140 2004 0000 3502 7681 6896</code>
          </p>
        </BaseAnimatedFold>
      </form>
    </BasePanel>
  </BaseContainer>
</template>

<script>
import BaseContainer from './BaseContainer'
import BasePanel from './BasePanel'
import BaseFormControl from './BaseFormControl'
import BaseDivider from './BaseDivider'
import BaseNumberControl from './BaseNumberControl'
import BaseButton from './BaseButton'
import BaseAnimatedFold from './BaseAnimatedFold'
import BaseCircularIndicator from './BaseCircularIndicator'
import { validateEmail } from '../utils'
import { orderFields } from '../schemas'
import apiFetch from '../apiFetch'

export default {
  name: 'CheckoutPage',
  data() {
    return {
      state: 'SUCCESS', // DEFAULT, LOADING, SUCCESS
      error: null,
      orderId: null,
      orderTotal: null,
      fields: orderFields.map(f => ({
        ...f,
        hasBeenFocused: false,
        value: ''
      })),
      items: []
    }
  },
  components: {
    BaseContainer,
    BasePanel,
    BaseFormControl,
    BaseDivider,
    BaseNumberControl,
    BaseButton,
    BaseAnimatedFold,
    BaseCircularIndicator
  },
  methods: {
    getFieldError(field, overrideHasBennFocused = false) {
      if (!overrideHasBennFocused && !field.hasBeenFocused) {
        return false
      }
      if (field.validate === 'NOT_EMPTY') {
        return field.value === ''
      }
      if (field.validate === 'EMAIL') {
        return !validateEmail(field.value)
      }
      return false
    },
    async placeOrder() {
      this.state = 'LOADING'
      let requestData = {
        items: this.items.map(i => ({
          id: i.id,
          amount: parseInt(i.amount)
        })),
        comments: ''
      }
      for (let f of this.fields) {
        requestData[f.name] = f.value
      }
      try {
        let data = await apiFetch(`/order`, {
          jsonBody: requestData,
          method: 'POST',
          noAuth: false
        })
        this.orderId = data.orderId
        this.orderTotal = data.total
      } catch (e) {
        this.error = e.message
        this.state = 'DEFAULT'
        return
      }
      this.state = 'SUCCESS'
    },
    async loadItems() {
      this.state = 'LOADING'
      try {
        this.items = (await apiFetch(`/item`, {
          noAuth: true
        })).items.map(it => ({
          ...it,
          amount: 0
        }))
      } catch (e) {
        this.error = e.message
      }
      this.state = 'DEFAULT'
    }
  },
  computed: {
    showForm() {
      return this.state === 'DEFAULT'
    },
    submitButtonDisabled() {
      if (this.fields.some(f => this.getFieldError(f, true))) {
        return true
      }
      if (
        this.items.some(p => p.amount < 0 || isNaN(parseInt(p.amount))) ||
        this.items.every(p => p.amount === 0)
      ) {
        return true
      }
      return false
    },
    total() {
      return (
        this.items.reduce((t, p) => t + p.amount * p.price, 0).toFixed(2) +
        ' zł'
      )
    }
  },
  mounted() {
    this.loadItems()
  }
}
</script>

<style scoped lang="less">
.bottom-columns {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  .spacer {
    width: 20%;
  }
  button {
    margin-left: 20px;
    width: 50%;
  }
  .total {
    margin-left: 10px;
    margin-right: 5px;
    padding: 15px 20px;
    width: 20%;
  }
}
</style>
