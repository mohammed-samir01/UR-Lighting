<template>
    <div class="mt-5 row" style="justify-content: center;">

        <button name="mada" @click="method" :disabled="loading">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="loading"></span>
            {{ $t('completeOrder') }}
        </button>
    </div>
</template>
<script>
export default {
    name: "MadaAndStc",
    props:['method','loading']
}
</script>

<style scoped>
button[name="mada"] {
    background-color: #3498db;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    width: 350px;
}

button[name="mada"]:hover {
    background-color: #2980b9;
}

</style>
