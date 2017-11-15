<template>
  <BaseContainer>
    <BasePanel>
      <form>
        <BaseAnimatedFold :show="showForm">
          <h1>Złóż zamówienie</h1>
          <!--<BasePanel slim error>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea odit dolores, est iste debitis autem beatae eligendi minima officia esse quaerat similique dolorem, dicta, quidem illo? Doloremque hic dicta voluptas.</p>
                </BasePanel>-->
          <BaseFormControl v-for="field in fields" :key="field.name" :label="field.label" :type="field.type || 'text'" v-model="field.value" @focus="field.hasBeenFocused = true" :error="getFieldError(field)" />

          <BaseDivider />
          <BaseNumberControl v-for="item in items" :key="item.name" :label="item.name" v-model="item.amount" :price="(item.amount * item.price).toFixed(2) + ' zł'" />
          <BaseDivider />
          <div class="bottom-columns">
            <div class="spacer"></div>
            <BaseButton @click="placeOrder" :disabled="submitButtonDisabled">Złóż zamówienie</BaseButton>
            <input type="text" readonly class="total" value="0.00 zł" />
          </div>
        </BaseAnimatedFold>
        <BaseAnimatedFold :show="!showForm">
          <BaseCircularIndicator :state="state" />
        </BaseAnimatedFold>
        <BaseAnimatedFold :show="state === 'SUCCESS'">
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae eligendi delectus quod dolore magni cumque pariatur alias eos corporis! Itaque doloremque in nam iure. Dignissimos in eum velit cumque consectetur!</p>
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
      state: 'LOADING', // DEFAULT, LOADING, SUCCESS
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
      if (field.validate === 'PHONE') {
        return !/\+?[0-9 ]{9,}/.test(field.value)
      }
      return false
    },
    async placeOrder() {
      this.state = 'LOADING'
      let requestData = {
        items: this.items
      }
      for (let f of this.fields) {
        requestData[f.name] = f.value
      }
      let data = await apiFetch(`/order`, {
        jsonBody: requestData,
        method: 'POST'
      })
      this.state = 'SUCCESS'
    },
    async loadItems() {
      this.state = 'LOADING'
      this.items = (await apiFetch(`/item`)).items.map(it => ({
        ...it,
        amount: 0
      }))
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
        this.items.some(p => p.amount < 0) ||
        this.items.every(p => p.amount === 0)
      ) {
        return true
      }
      return false
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
