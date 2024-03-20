<!-- Stripe JavaScript library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>

	//set your publishable key
	Stripe.setPublishableKey('pk_live_51OtxwKHKnadmFYpOGzncEgc7m6VjjxoigX0g0CROID5tbnE6p2oWMbz6AKn5IVO7YAVAejJVUqnwEBkfGwSI9K8p00Ijdh5Mcw');
	
	//callback to handle the response from stripe
	function stripeResponseHandler(status, response) {
		if (response.error) {
			//enable the submit button
			$('#btn_pago').removeAttr("disabled");
			//display the errors on the form
			// $('#payment-errors').attr('hidden', 'false');
			$('#payment-errors').addClass('alert alert-danger');
			$("#payment-errors").html(response.error.message);
		} else {
			var form$ = $("#paymentFrm");
			//get token id
			var token = response['id'];
			//insert the token into the form
			form$.append("<input type='hidden' name='token' id='token' value='"+token+"' />");
			//submit form to the server
			form$.get(0).submit();
		}
	}

	$(document).ready(function() {
		//on form submit
		$("#paymentFrm").submit(function(event) {
			//disable the submit button to prevent repeated clicks
			$('#btn_pago').attr("disabled", "disabled");
			
			//create single-use token to charge the user
			Stripe.createToken({
				name: $('#name').val(),
				number: $('#card_num').val(),
				cvc: $('#card_cvv').val(),
				exp_month: $('#exp_month').val(),
				exp_year: $('#exp_year').val()
			}, stripeResponseHandler);
			
			//submit from callback
			return false;
		});
	});

</script>

<div class="container">
	<div class="row">	

		<div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <?php echo $plan_row->nombre.' ['.$plan_row->sku.']'; ?>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
								<th>Descripción</th>
                                <th>Clases</th>
                                <th>Costo</th>
                                <th>Términos y condiciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
								<td><?php echo $plan_row->descripcion; ?></td>
                                <td class="card-number"> <?php echo $plan_row->clases_incluidas; ?></td>
								<td><?php echo '$'.number_format($plan_row->costo, 2, '.', ''); ?></td>
								<td><?php echo $plan_row->terminos_condiciones; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>    
        </div>

        <div class="col-md-6">
            
            <div class="card">
                <div class="card-header bg-success text-white">Método de pago</div>

                <div class="card-body bg-light">

                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oops!</strong>
                            <?php echo validation_errors() ;?> 
                        </div>  
                    <?php endif ?>
                    <div id="payment-errors"></div>

                     <form method="post" id="paymentFrm" enctype="multipart/form-data" action="<?php echo base_url(); ?>usuario/pagos/index">

                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nombre en la tarjeta" value="<?php echo set_value('name'); ?>" required>
                        </div>

                         <div class="form-group">
                            <input type="number" name="card_num" id="card_num" class="form-control" placeholder="Número en la tarjeta" autocomplete="off" value="<?php echo set_value('card_num'); ?>" required>
                        </div>
                       
                        
                        <div class="row">

                            <div class="col-sm-8">
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="exp_month" id="exp_month" maxlength="2" class="form-control" placeholder="MM" value="<?php echo set_value('exp_month'); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="exp_year" id="exp_year" class="form-control" maxlength="4" placeholder="YYYY" required="" value="<?php echo set_value('exp_year'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="card_cvv" id="card_cvv" maxlength="3" class="form-control" autocomplete="off" placeholder="CVV / CVC" value="<?php echo set_value('card_cvv'); ?>" required>
                                </div>
                            </div>

                        </div>

                        <div class="form-group text-right">
							<button class="btn btn-secondary" type="reset">Atrás</button>
							<button type="submit" id="btn_pago" class="btn btn-success">Pagar</button>
                        </div>

                    </form>     
                </div>
            </div>
                 
        </div>

    </div>
</div> 
