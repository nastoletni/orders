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
          <BaseNumberControl v-for="product in products" :key="product.name" :label="product.name" v-model="product.qty" :price="(product.qty * product.price).toFixed(2) + ' zł'" />
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

export default {
  name: 'CheckoutPage',
  data() {
    return {
      state: 'DEFAULT', // DEFAULT, LOADING, SUCCESS
      fields: [
        {
          label: 'Imię i nazwisko',
          name: 'name',
          validate: 'NOT_EMPTY',
          value: '',
          hasBeenFocused: false
        },
        {
          label: 'Telefon',
          name: 'phone',
          validate: 'NOT_EMPTY',
          value: '',
          hasBeenFocused: false
        },
        {
          label: 'Adres email',
          name: 'email',
          validate: 'EMAIL',
          value: '',
          hasBeenFocused: false
        },
        {
          label: 'Adres wysyłki',
          name: 'address',
          type: 'textarea',
          validate: 'NOT_EMPTY',
          value: '',
          hasBeenFocused: false
        }
      ],
      products: [
        {
          name: 'Kubek',
          price: 10.0,
          qty: 0
        },
        {
          name: 'Naklejki',
          price: 2.0,
          qty: 0
        }
      ]
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
      await new Promise(res => setTimeout(res, 4000))
      this.state = 'SUCCESS'
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
      if(this.products.some(p => p.qty < 0) || this.products.every(p => p.qty === 0)) {
        return true;
      }
      return false;
    }
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
