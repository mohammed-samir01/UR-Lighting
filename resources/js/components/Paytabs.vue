<template>
    <div>
<!--        <form action="https://candle-store.com/payment" id="payform" method="post">-->
<!--            <span id="paymentErrors"></span>-->
<!--            <div class="row">-->
<!--                <label>Card Number</label>-->
<!--                <input type="text" data-paylib="number" size="20">-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <label>Expiry Date (MM/YYYY)</label>-->
<!--                <input type="text" data-paylib="expmonth" size="2">-->
<!--                <input type="text" data-paylib="expyear" size="4">-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <label>Security Code</label>-->
<!--                <input type="text" data-paylib="cvv" size="4">-->
<!--            </div>-->
<!--            <input type="submit" value="Place order">-->
<!--        </form>-->
    </div>
</template>
<script>
export default {
    name: "PayTabs",
    data() {
        return {}
    },
    mounted() {
        let myform = document.getElementById('payform');
        // paylib.inlineForm({
        //     'key': 'C6KMVG-THNK6H-DNB7VT-DN76BP',
        //     'form': myform,
        //     'autoSubmit': false,
        //     'currency': 'SAR',
        //     'callback': function (response) {
        //         axios.post(`paytabs-payment?token_paytabs=${response.token}`).then((res) => {
        //             window.location.href = res.data.data.redirect_url;
        //         })
        //     }
        // });

    },
}
</script>
<style scoped>
.row {
    margin-bottom: 10px;
}

label {
    display: inline-block;
    width: 150px; /* Adjust the width as needed */
}

input[type="text"] {
    width: 100px; /* Adjust the width as needed */
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

/* Style specific inputs */
input[data-paylib="number"],
input[data-paylib="expmonth"],
input[data-paylib="expyear"],
input[data-paylib="cvv"] {
    width: auto; /* Reset the width for inline inputs */
    margin-right: 10px; /* Add some spacing between inline inputs */
}

</style>
