<template>
    <div class="form">
        <slot></slot>
    </div>
</template>

<script>
export default {}
</script>

<style scoped lang="less">
@import '../style/theme';

.form {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
}
</style>
