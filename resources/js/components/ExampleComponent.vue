<template>
    <div>
        amer hi

<!--        <button type="button" id="placeOrderButton" @click.prevent="pay">Place order</button>-->


        <!--        <button @click="pay">pay</button>-->
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('amer int')
        // let myform = document.getElementById('payform');
        // paylib.inlineForm({
        //     'key': 'CHK2TD-PNQD6H-DMPB7G-9KT9HB',
        //     'form': myform,
        //     'autoSubmit': false,
        //     'currency': 'EGP',
        //     'callback': function (response) {
        //         console.log('amer ', response)
        //     }
        // });
        //  // new TabbyCard({
        //     selector: '#tabbyCard', // empty div for TabbyCard
        //     currency: 'SAR', //  SAR, BHD, KWD, EGP
        //     lang: 'ar', //  ar|en
        //     price: 100,
        //     size: 'narrow', // or wide, depending on the width
        //     theme: 'default', // or can be black
        //     header: false // if there is a Payment method name already
        // });
    },
    methods: {
        pay() {
            let myform = document.getElementById('payform');
            myform.submit();

            // Now, you can decide when to submit the form, perhaps based on the paylib response


        }
    }
}
</script>
<style scoped>
div {
    margin: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f5f5f5;
    max-width: 300px;
    margin: 0 auto;
}

/* Style the form label */
label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

/* Style the form input fields */
input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Style the submit button */
input[type="submit"] {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

</style>
