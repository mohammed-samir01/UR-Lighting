<template>
    <div class="mt-5 row" style="justify-content: center;">
                <div>
                    <button name="mada" @click="method">اكمال الدفع</button>
                </div>
    </div>
</template>
<script>
export default {
    name: "MadaAndStc",
    props:['method']
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
