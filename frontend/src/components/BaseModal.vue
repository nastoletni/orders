<template>
    <div class="modal">
        <div class="modal-bg"></div>
        <div class="modal-window" :class="{slim}">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import BaseContainer from './BaseContainer'
import BasePanel from './BasePanel'

export default {
  components: {
    BaseContainer,
    BasePanel
  },
  props: {
    slim: Boolean
  }
}
</script>

<style scoped lang="less">
@import '../style/theme';
.modal {
  z-index: 3000;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  .modal-bg {
    width: 100%;
    height: 100%;
    background: black;
    opacity: 0.5;
  }
  .modal-window {
    .shadow();
    position: fixed;
    top: 10vh;
    height: 60vh;
    width: 90vw;
    left: 5vw;
    box-sizing: border-box;
    padding: 30px;
    border-top-width: 3px;
    border-top-style: solid;
    border-image: @panel-border-gradient 1;
    background: #fff;
    z-index: 4000;
    .modal-buttons {
        display: flex;
        position: absolute;
        bottom: 0;
        right: 0;

        * {
            margin: 30px;
        }
    }
    &.slim {
      width: 40vw;
      left: 30vw;
      height: 30vh;
    }
  }
}
</style>
