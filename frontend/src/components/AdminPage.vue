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
select {
  border: 5px solid #ccc;
  padding: 10px;

  &.stage-0 {
    // Unaccepted
    border-color: #e74c3c;
  }
  &.stage-1 {
    // Accepted
    border-color: #f1c40f;
  }
  &.stage-2 {
    // Paid
    border-color: #3498db;
  }
  &.stage-3 {
    // Sent
    border-color: #2ecc71;
  }
  &.stage-4 {
    // Delivered
    border-color: #1abc9c;
  }
}
</style>
<template>
  <BaseContainer wide>
    <BaseModal slim v-if="orderToDelete">
      Na pewno chcesz usunąć to zamówienie?
      <div class="modal-buttons">
        <BaseButton @click="orderToDelete = null">Anuluj</BaseButton>
        <BaseButton danger @click="deleteOrder(orderToDelete)">Usuń</BaseButton>
      </div>
    </BaseModal>
    <BasePanel>
      <h1>Zamówienia</h1>
      <BasePanel slim error v-if="error">
        <p>{{error}}</p>
      </BasePanel>
      <table>
        <thead>
          <tr>
            <th v-for="field in orderFields" :key="field.name">{{field.label}}</th>
            <th>Status</th>
            <th>Akcje</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id">
            <td v-for="field in orderFields" :key="field.name">{{order[field.name]}}</td>
            <td>
              <span v-if="order.stageLoading">Ładowanie</span>
              <select v-else :value="order.stage.toString()" @input="changeStage(order, $event.target.value)" :class="`stage-${order.stage.toString()}`">
                <option value="0">Niezaakceptowane</option>
                <option value="1">Zaakceptowane</option>
                <option value="2">Zapłacone</option>
                <option value="3">Wysłane</option>
                <option value="4">Dostarczone</option>
              </select>
            </td>
            <td>

              <BaseButton danger @click="orderToDelete = order">Usuń</BaseButton>
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
import { encodeParams } from '../utils'
import BaseModal from './BaseModal'

export default {
  data() {
    return {
      error: null,
      orderToDelete: null,
      orderFields,
      orders: []
    }
  },
  props: {},
  components: {
    BaseContainer,
    BasePanel,
    BaseButton,
    BaseModal
  },
  computed: {},
  methods: {
    async loadOrders() {
      try {
        let data = await apiFetch('/order')
        this.orders = data.orders.map(o => ({
          ...o,
          stageLoading: false
        }))
      } catch (e) {
        if (e.code === 401) {
          this.$router.push('/login')
          return
        }
        this.error = e.message
      }
    },
    async changeStage(order, stage) {
      order.stageLoading = true
      try {
        await apiFetch(encodeParams`/order/${order.id}/stage`, {
          method: 'PATCH',
          jsonBody: {
            stage: parseInt(stage)
          }
        })
        order.stage = parseInt(stage)
      } catch (e) {
        this.error = e.message
      } finally {
        order.stageLoading = false
      }
    },
    async deleteOrder(order) {
      try {
        await apiFetch(encodeParams`/order/${order.id}`, {
          method: 'DELETE'
        })
        this.orders.splice(this.orders.indexOf(order), 1)
        this.orderToDelete = null
      } catch (e) {
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
