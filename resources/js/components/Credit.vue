<template>
    <div>
        <form action="https://candle-store.com/payment" id="payform" method="post">
            <span id="paymentErrors"></span>
            <div class="row">
                <label>Card Number</label>
                <input type="text" data-paylib="number" size="20">
            </div>
            <div class="row" style="align-items: center">
                <label>Expiry Date (MM/YYYY)</label>
                <div>
                    <input type="text" data-paylib="expmonth" size="2">
                    <input type="text" data-paylib="expyear" size="4">
                </div>
            </div>
            <div class="row">
                <label>Security Code</label>
                <input type="text" data-paylib="cvv" size="4">
            </div>
            <input type="submit" value="اكمال الطلب">
        </form>


    </div>
</template>
<script>
export default {
    name: "Credit",
    data() {
        return {}
    },
    mounted() {
        const script = document.createElement('script');
        script.src = 'https://secure.paytabs.sa/payment/js/paylib.js';
        script.async = true;
        script.onload = () => {
            let myform = document.getElementById('payform');
            paylib.inlineForm({
                'key': 'C6KMVG-THNK6H-DNB7VT-DN76BP',
                'form': myform,
                'autoSubmit': false,
                'currency': 'SAR',
                'callback': (response) => {
                    if (response.status == 200) {
                        axios.post(`customer/web-payment-request`, {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'payment_method': 'paytabs',
                            'payment_platform': 'web',
                            'payment_request_from': 'app',
                            'customer_id': this.$parent.customer_id,
                            'is_guest': false,
                            'type_payment': 'creditcard'
                        }).then((res) => {
                            axios.post(res.data.redirect_link, {
                                'payment_request_from': 'app',
                                'token_paytabs': response.token
                            }).then((res) => {
                                if (res.data && res.data.redirect_link)
                                    window.location.href = res.data.redirect_link;
                            })
                        })
                    } else {
                        console.log(response, 'er')
                    }

                }
            });

        };
        document.body.appendChild(script);


    },
}
</script>
<style scoped>
#payform {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
    direction: ltr;
}

/* Style the form rows */
.row {
    margin-bottom: 15px;
}

/* Style the labels */
label {
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

/* Style the input fields */
input {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

/* Style the inline input fields (expmonth and expyear) */
.row > div {
    display: flex;
    align-items: center;
}

.row > div input {
    margin-right: 10px;
}

/* Style the submit button */
input[type="submit"] {
    background-color: #3498db;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #2980b9;
}

/* Style for error messages */
#paymentErrors {
    color: red;
    margin-bottom: 15px;
}

/* Additional styling for a fantastic look */
body {
    background-color: #ecf0f1;
    font-family: 'Arial', sans-serif;
}

/* Add some spacing between elements */
.row, input[type="submit"], #paymentErrors {
    margin-bottom: 20px;
}
</style>
