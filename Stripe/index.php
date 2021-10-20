<?php
require('config.php');
$price = (523 * 10000);
?>
<form action="submit.php" method="post">
	<script
		src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		data-key="<?php echo $publishableKey?>"
		data-amount="<?= $price  / 100?>"
		data-name="Programming with Shadab"
		data-description="Programming with Shadab Desc"
		data-image="https://pbs.twimg.com/profile_images/932986247642939392/CDq_0Vcw_400x400.jpg"
		data-currency="inr"
		data-email="ks615044@gmail.com"
	>
	</script>

</form>