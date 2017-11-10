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
                    <BaseNumberControl label="Kubek" v-model="kubek" :price="(kubek * 8).toFixed(2) + ' zł'" />
                    <BaseNumberControl label="Naklejki" v-model="naklejki" :price="(naklejki * 2).toFixed(2) + ' zł'" />
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
      kubek: '1',
      naklejki: '1'
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
