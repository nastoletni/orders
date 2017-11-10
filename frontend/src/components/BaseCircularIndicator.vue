<template>
    <div class="circular-indicator" :class="state.toLowerCase()">
        <div class="checkmark" />
    </div>
</template>

<script>
export default {
  props: {
    state: String
  }
}
</script>

<style scoped lang="less">
@import '../style/theme';

.circular-indicator {
  opacity: 0;
  box-shadow: 1px 2px 20px 4px rgba(0, 0, 0, 0.3);
  margin: 0 auto;
  margin-top: 100px;
  margin-bottom: 100px;
  border-radius: 10000px;
  width: 200px;
  height: 200px;
  transition: 1s ease-in-out;
  overflow: hidden;
  box-sizing: border-box;

  .checkmark {
    margin-top: -200px;
    padding-top: 15px;
    transition: 1s ease-in-out;
    &:after {
      content: '';
      margin-left: 60px;
      display: block;
      width: 50px;
      height: 110px;
      border: solid white;
      border-width: 0 30px 30px 0;
      transform: rotate(45deg);
    }
  }
  &.loading {
    opacity: 1;
    background: @primary-color;
    border: 10px solid lighten(@primary-color, 10%);
    border-width: 50px;
    animation: loader 4s infinite ease-in-out;
  }
  &.success {
    border-width: 0;
    opacity: 1;
    background: @success-color;
    .checkmark {
      margin-top: 0px;
    }
  }
}

@keyframes loader {
  0% {
    border-width: 0px;
  }
  50% {
    border-width: 20px;
  }
  100% {
    border-width: 0px;
  }
}
</style>
