<template>
    <transition name="fold">
        <div v-if="show" class="fold">
            <slot></slot>
        </div>
    </transition>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      default: true
    }
  }
}
</script>

<style scoped lang="less">
.fold-enter-active,
.fold-leave-active {
  transition: all 1s ease-in-out;
  max-height: 600px; // TODO: remove constant
  overflow: hidden;
}
.fold-enter,
.fold-leave-to {
  opacity: 0;
  max-height: 0px;
}
</style>
