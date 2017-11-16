<template>
  <div class="container" :class="{wide, narrow}">
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    wide: Boolean,
    narrow: Boolean
  }
}
</script>

<style scoped lang="less">
.container {
  width: 70%;
  margin: 0 auto;
  @media (min-width: 320px) {
    /* smartphones, portrait iPhone, portrait 480x320 phones (Android) */
    width: 100%;
  }
  @media (min-width: 480px) {
    /* smartphones, Android phones, landscape iPhone */
    width: 100%;
  }
  @media (min-width: 600px) {
    /* portrait tablets, portrait iPad, e-readers (Nook/Kindle), landscape 800x480 phones (Android) */
    width: 90%;
  }
  @media (min-width: 801px) {
    /* tablet, landscape iPad, lo-res laptops ands desktops */
    width: 90%;
  }
  @media (min-width: 1025px) {
    /* big landscape tablets, laptops, and desktops */
    width: 800px;
    &.wide {
      width: 80%;
    }
    &.narrow {
      width: 40%;
    }
  }
  @media (min-width: 1281px) {
    /* hi-res laptops and desktops */
    &.wide {
      width: 70%;
    }
    &.narrow {
      width: 20%;
    }
  }
}
</style>
