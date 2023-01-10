<template>
    <div class="flex flex-col">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "TList",
    props: {
        color: {
            type: String,
            default: 'solid-white'
        },
        radius: {
            required: false,
        },
        type: {
            required: false
        }
    }
}
</script>

<style scoped>
.bgDarkElementar {
    background-color: #7478b2;
}
.bgDarkElementar:hover {
    background-color: #aaaddc;
}
</style>
