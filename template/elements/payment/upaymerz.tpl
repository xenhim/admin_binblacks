{% if minimal == '0' %}

<form method="post" action="https://papogo.com/transaction/">
<input type="hidden" name="type_from" value="pmr">
<input type="hidden" name="type_to" value="np">
<input type="hidden" name="currency_from" value="wmz">
<input type="hidden" name="currency_to" value="USD">
<input type="hidden" name="code" value="{{umerch}}">
<input type="hidden" name="merchant" value="{{umerch}}">
<input type="hidden" name="comment" value="Order #{{id}}">
<input type="hidden" name="sum_to" value="{{order}}">
<input type="hidden" name="back_url" value="{{homeUrl}}ucallback.php">
<input type="hidden" name="transaction_id" value="{{randorder}}">
<input type="hidden" name="comment_tpl" value="[%COMMENT%] [%INVOICE%] [%TRANSACTION%]">
<input type="Submit">
</form>
<script>document.forms[0].submit();</script>
                            
{% else %}

Minimal deposit = {{mindeposit}}$

{% endif %}