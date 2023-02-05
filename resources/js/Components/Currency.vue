<script setup>
const formatter = new Intl.NumberFormat('id-Id', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
});
defineProps({ price: Number })
</script>

<template>
    <span> {{ formatter.format(price) }} </span>
</template>
