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
        <Credit v-show="selectedButton == 'creditcard'"/>
        <Tabby v-show="selectedButton == 'tabby'" :method="completeOrder"/>
        <MadaAndStc v-show="selectedButton == 'mada' || selectedButton == 'stcpay'" :method="completeOrder"/>
        <Tamara/>
    </div>
</template>
<script>
import VueRadioButton from './VueRadioButton.vue'
import PayTabs from "./PayTabs.vue";
import Tabby from "./Tabby.vue";
import Credit from "./Credit.vue";
import MadaAndStc from "./MadaAndStc.vue";
import Tamara from "./Tamara.vue";

export default {
    name: "PaymentMethods",
    props: ['data', 'customer_id'],
    components: {Tamara, MadaAndStc, Credit, Tabby, PayTabs, VueRadioButton},
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
    },
    methods: {
        completeOrder() {
            axios.post(`customer/web-payment-request`, {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'payment_method': 'paytabs',
                'payment_platform': 'web',
                'payment_request_from': 'app',
                'customer_id': this.customer_id,
                'is_guest': false,
                'type_payment': this.selectedButton
            }).then((res) => {
                axios.post(res.data.redirect_link, {
                    'payment_request_from': 'app',
                }).then((res) => {
                    if (res.data && res.data.redirect_link)
                        window.location.href = res.data.redirect_link;
                })
            })
        }
    }
}
</script>
<style scoped>

</style>
