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

export default {
  data() {
    return {
      orderFields,
      orders: [
        {
          id: 2982382,
          name: 'Jan Kowalski',
          phone: '+1234567890',
          email: 'email@example.com',
          address: 'ul. Długa 123 Rybnik 44-200 Polska'
        }
      ]
    }
  },
  props: {},
  components: {
    BaseContainer,
    BasePanel,
    BaseButton
  },
  computed: {},
  methods: {},
  watch: {}
}
</script>
