<template>
    <div>
        <VueRadioButton v-model="selectedButton" :options="optionPaytabs">
            <template #label="{ props }">
                <img :src="props.icon" style="width: 85%"/>
            </template>
            <template v-slot:pay>
                <slot></slot>
            </template>
        </VueRadioButton>
<!--        <PayTabs v-if="[1,2,3].includes(selectedButton)"/>-->
<!--        <Tabby v-if="selectedButton === 4"/>-->
    </div>
</template>
<script>
import VueRadioButton from './VueRadioButton.vue'
import PayTabs from "./PayTabs.vue";
import Tabby from "./Tabby.vue";

export default {
    name: "PaymentMethods",
    props: ['data'],
    components: {Tabby, PayTabs, VueRadioButton},
    data() {
        return {
            selectedButton: '',
            options: [
                {
                    id: 1,
                    icon: "/public/payments/credit.svg",
                },
                {
                    id: 2,
                    icon: "/public/payments/mada.svg",
                },
                {
                    id: 3,
                    icon: "/public/payments/stcpay.svg",
                },
                {
                    id: 4,
                    icon: "/public/payments/tabby.png",
                },
                // {
                //     id: 5,
                //     icon: "/public/payments/tamara.svg",
                // },

            ]
        }
    },
    computed: {
        paytabs() {
            return this.data && this.data.some(pay => pay.key_name == 'paytabs')
        },
        optionPaytabs() {
            let paytabs = []
            if (this.paytabs)
                paytabs = JSON.parse(this.data.find((payment) => payment.key_name == 'paytabs').additional_data).options
            return paytabs

        }
    }
}
</script>
<style scoped>

</style>
