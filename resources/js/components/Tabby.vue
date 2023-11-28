<template>
    <div class="mt-4 row" style="justify-content: center;">
        <div id="tabbyCard" class="col-12">
        </div>
        <div>

        <button name="complete" @click="method">اكمال الطلب</button>
        </div>
    </div>
</template>
<script>
export default {
    name: "Tabby",
    props: ['method'],
    data() {
        return {
            scriptsAppended: false
        }
    },
    mounted() {

        if (!this.scriptsAppended) {
            this.appendScripts();
            this.scriptsAppended = true;
        }

    },
    methods: {
        appendScripts() {
            const script = document.createElement('script');
            const script2 = document.createElement('script');
            script.src = 'https://checkout.tabby.ai/tabby-card.js';
            script2.src = 'https://checkout.tabby.ai/tabby-promo.js';

            script.onload = () => {
                new TabbyCard({
                    selector: '#tabbyCard', // empty div for TabbyCard
                    currency: 'SAR', //  SAR, BHD, KWD, EGP
                    lang: $('input[name="lang"]').val(), //  ar|en
                    price: $('input[name="total_amount"]').val(),
                    size: 'narrow', // or wide, depending on the width
                    theme: 'default', // or can be black
                    header: false // if there is a Payment method name already
                });
            }
            script2.onload = () => {


            }
            document.body.appendChild(script);
            document.body.appendChild(script2);
        }
    }
}


</script>
<style scoped>
/* Style the submit button */
button[name="complete"] {
    background-color: #3498db;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    width: 350px;
}

button[name="complete"]:hover {
    background-color: #2980b9;
}
</style>
