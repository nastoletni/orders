<template>
  <BaseContainer>
    <BasePanel>
      <form>
        <BaseAnimatedFold :show="showForm">
          <h1>Złóż zamówienie</h1>
          <BaseFormControl label="Imię i nazwisko" />
          <BaseFormControl label="Telefon" />
          <BaseFormControl label="Adres email" />
          <BaseFormControl label="Adres wysyłki" type="textarea" />
          <BaseDivider />
          <BaseNumberControl v-for="product in products" :key="product.name" :label="product.name" v-model="product.qty" :price="(product.qty * product.price).toFixed(2) + ' zł'" />
          <BaseDivider />
          <div class="bottom-columns">
            <div class="spacer"></div>
            <BaseButton @click="placeOrder">Złóż zamówienie</BaseButton>
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

export default {
  name: 'CheckoutPage',
  data() {
    return {
      state: 'DEFAULT', // DEFAULT, LOADING, SUCCESS
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
    async placeOrder() {
      this.state = 'LOADING'
      await new Promise(res => setTimeout(res, 4000))
      this.state = 'SUCCESS'
    }
  },
  computed: {
    showForm() {
      return this.state === 'DEFAULT'
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
