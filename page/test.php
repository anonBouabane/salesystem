<?php $grandTotal = 10; ?>

<script type="text/javascript">
    function calculateTotal() {

        var nairaRate = document.pricecalculator.nairaRateToday.value; //get NGN rate today from admin and assign to nairaRate


        dollarValue = eval(document.pricecalculator.nairaInput.value * nairaRate); //multiply nairaInput by nairaRate to get dollarValue


        document.getElementById('dollar').innerHTML = dollarValue; //pass dollarValue to dollar to show auto-calculation onscreen
    }
</script>

<form name="pricecalculator" action="">
    <legend>Price Calculator (Buy BTC)</legend>
    <label>Amount (NGN)</label><input type="number" name="nairaInput" onchange="calculateTotal()" value="1" /> <br />
    <label>Amount (USD):</label><span id="dollar">1</span> <br />
    <input type="hidden" name="nairaRateToday" value="<?= $grandTotal ?>">
</form>