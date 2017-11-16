<style lang="less" scoped>
@import '../style/theme';
table {
  width: 100%;
  border-collapse: collapse;
  border: 1;
}
td,
th {
  border-bottom: 1px solid @muted-color;
  padding: 20px;
  text-align: left;
}
</style>
<template>
    <BaseContainer wide>
        <BasePanel>
            <h1>Zamówienia</h1>
            <BasePanel slim error v-if="error">
                <p>{{error}}</p>
            </BasePanel>
            <table>
                <thead>
                    <tr>
                        <th v-for="field in orderFields" :key="field.name">{{field.label}}</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders" :key="order.id">
                        <td v-for="field in orderFields" :key="field.name">{{order[field.name]}}</td>
                        <td>
                            <BaseButton>Zapłacono</BaseButton>
                            <BaseButton danger>Usuń</BaseButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </BasePanel>
    </BaseContainer>
</template>
<script>
import BaseContainer from './BaseContainer'
import BasePanel from './BasePanel'
import { orderFields } from '../schemas'
import BaseButton from './BaseButton'
import apiFetch from '../apiFetch'

export default {
  data() {
    return {
      error: null,
      orderFields,
      orders: []
    }
  },
  props: {},
  components: {
    BaseContainer,
    BasePanel,
    BaseButton
  },
  computed: {},
  methods: {
    async loadOrders() {
      try {
        let data = await apiFetch('/order')
        this.orders = data.orders
      } catch (e) {
        if (e.code === 401) {
          this.$router.push('/login')
          return
        }
        this.error = e.message
      }
    }
  },
  watch: {},
  mounted() {
    this.loadOrders()
  }
}
</script>
