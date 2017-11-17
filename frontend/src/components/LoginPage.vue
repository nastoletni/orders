<style lang="less" scoped>

</style>
<template>
    <BaseContainer narrow>
        <BasePanel>
            <h1>Zaloguj się</h1>
            <BasePanel slim error v-if="error">
                <p>{{error}}</p>
            </BasePanel>
            <BaseFormControl label="Username" v-model="username" forceColumn />
            <BaseFormControl label="Password" type="password" v-model="password" forceColumn />
            <!-- kill this with fire -->
            <br />
            <BaseButton @click="login">Zaloguj</BaseButton>
        </BasePanel>
    </BaseContainer>
</template>
<script>
import BaseContainer from './BaseContainer'
import BasePanel from './BasePanel'
import BaseButton from './BaseButton'
import BaseFormControl from './BaseFormControl'
import apiFetch from '../apiFetch'

export default {
  data() {
    return {
      error: null,
      username: '',
      password: ''
    }
  },
  props: {},
  components: {
    BaseContainer,
    BasePanel,
    BaseButton,
    BaseFormControl
  },
  computed: {},
  methods: {
    async login() {
      try {
        let resp = await apiFetch('/auth', {
          jsonBody: {
            username: this.username,
            password: this.password
          },
          noAuth: true,
          method: 'POST'
        })
        localStorage.setItem('token', resp.token)
        this.$router.push('/admin')
      } catch (e) {
        this.error = e.message
      }
    }
  },
  watch: {}
}
</script>
