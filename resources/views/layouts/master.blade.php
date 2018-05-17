<!DOCTYPE html>
<html>
<head>
	<title>Subscription</title>
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/main.css">

</head>
<body>

	@yield('content')

	<script src="https://js.stripe.com/v3/"></script>

	<script>
		// Create a Stripe client.
		var stripe = Stripe('{{ config('services.stripe.key')}}');

		// Create an instance of Elements.
		var elements = stripe.elements();

		// Custom styling can be passed to options when creating an Element.
		// (Note that this demo uses a wider set of styles than the guide below.)
		var style = {
		  base: {
		  	iconColor: '#c4f0ff',
		    color: '#32325d',
		    lineHeight: '16px',
		    fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
		    fontSmoothing: 'antialiased',
		    fontSize: '16px',
		    '::placeholder': {
		      color: '#87bbfd',
		      opacity: '0.5'
		    }
		  },
		  invalid: {
		    color: '#fa755a',
		    iconColor: '#fa755a'
		  }
		};

		// Create an instance of the card Element.
		var card = elements.create('card', {
			iconStyle: 'solid',
		    style: style,
		    hidePostalCode: true
		});

		// Add an instance of the card Element into the `card-element` <div>.
		card.mount('#card-element');

		// Handle real-time validation errors from the card Element.
		card.addEventListener('change', function(event) {
		  var displayError = document.getElementById('card-errors');
		  if (event.error) {
		    displayError.textContent = event.error.message;
		  } else {
		    displayError.textContent = '';
		  }
		});

		// Handle form submission.
		var form = document.getElementById('payment-form');
		form.addEventListener('submit', function(event) {
		  event.preventDefault();

		  var options = {
		    name: document.getElementById('name').value,
		  }

		  stripe.createToken(card, options).then(function(result) {
		    if (result.error) {
		      // Inform the user if there was an error.
		      var errorElement = document.getElementById('card-errors');
		      errorElement.textContent = result.error.message;
		    } else {
		      // Send the token to your server.
		      stripeTokenHandler(result.token);
		    }
		  });
		});

		function stripeTokenHandler(token) {
		  // Insert the token ID into the form so it gets submitted to the server
		  var form = document.getElementById('payment-form');
		  var hiddenInput = document.createElement('input');
		  hiddenInput.setAttribute('type', 'hidden');
		  hiddenInput.setAttribute('name', 'stripeToken');
		  hiddenInput.setAttribute('value', token.id);
		  form.appendChild(hiddenInput);

		  // Submit the form
		  form.submit();
		}

		var x = document.getElementById('content').getElementsByClassName("message")[0];
		if (x) {
			document.getElementById('content').getElementsByClassName("left")[0].style.display = "none";
			document.getElementById('content').getElementsByClassName("right")[0].style.display = "none";
		}
	</script>

</body>
</html>