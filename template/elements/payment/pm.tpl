{% if minimal == '0' %}

<form action="https://perfectmoney.is/api/step1.asp" method="POST">
<input type="hidden" name="PAYEE_ACCOUNT" value="{{merchant}}">
<input type="hidden" name="PAYEE_NAME" value="{{storename}}">
<input type="hidden" name="PAYMENT_ID" value="{{id}}">
<input type="hidden" name="PAYMENT_AMOUNT" value="{{order}}"><BR>
<input type="hidden" name="PAYMENT_UNITS" value="{{currency}}">
<input type="hidden" name="STATUS_URL" value="{{adminEmail}}">
<input type="hidden" name="PAYMENT_URL" value="{{homeUrl}}process.php">
<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
<input type="hidden" name="NOPAYMENT_URL" value="{{homeUrl}}index.php">
<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
<input type="hidden" name="SUGGESTED_MEMO" value="">
<input type="hidden" name="BAGGAGE_FIELDS" value="">
<input type="submit" name="PAYMENT_METHOD" value="Pay Now!">
</form>
<script>document.forms[0].submit();</script>

{% else %}

Minimal deposit = {{mindeposit}}$

{% endif %}