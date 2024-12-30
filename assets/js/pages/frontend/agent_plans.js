jQuery(document).ready(function(){


    //let url = $(this).attr('data-url');

    $('.get-started').click(function(){

        var plan_id = $(this).attr('data-id');
        $('#set-price').attr('plan-id', plan_id);

        var plan_price = $(this).attr('data-pice');
        $('#set-price').text('$'+plan_price+ ' Pay Now' );



        // $.ajax({url: cortiamajax.planajaxurl, data:{plan_id : plan_id} , success: function(result){

        //         if(result == "true")
        //         {  

        //         $('#myModal').modal('toggle');

        //         swal.fire({
        //             title: "Resend Email",
        //             text: "Email send successfully!",
        //             type: "success",
        //             confirmButtonClass: "btn btn-success"
        //         });
        //         }else{

        //         swal.fire({
        //             title: "Resend Email",
        //             text: "Email not exist",
        //             type: "error",
        //             confirmButtonClass: "btn btn-danger"
        //         });
        //     }
        // }});
    
    });
  
});



jQuery(document).ready(function(){

    jQuery(document).on('click', '#set-price', function(){

       $('form.require-validation').submit();

    });



    $('.card-number').on('keypress change', function (e) {

        
        var charCode = (e.which) ? e.which : event.keyCode    

        if (String.fromCharCode(charCode).match(/[^0-9]/g))    
            return false;           
        
         $(this).val(function (index, value) {
    
            return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
          });
    });


    var $form         = $(".require-validation");
  $('form.require-validation').submit(function(e) {



    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
     
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
        console.log($form.data('stripe-publishable-key'));
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
    
  });
      
  function stripeResponseHandler(status, response) {

        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");


        jQuery.ajax({
            type: "post",
            url: cortiamajax.paymentajaxurl,
            data: { email : 'abaig4325@gmail.com', token : token},
            dataType: "json",
            success: function(response){

                console.log(response);

            if(response.success)
            {
                $('#payment-notification').css('display', 'block');
                $('#payment-notification').text(response.success);


                setTimeout(function () {
                        $('#payment-notification').css('display', 'none');
                        $form[0].reset();
                        $("#myModal").modal('hide');


                    swal.fire({
                        title: "Membership Plan",
                        text: "Plan selected successfully!",
                        type: "success",
                        confirmButtonClass: "btn btn-secondary"
                    });


                }, 3000);					

                let plan_id = $('#set-price').attr('plan-id');

                $.ajax({url: cortiamajax.planajaxurl, data:{plan_id : plan_id} , success: function(result){


                   location.reload();
                }});



            }					

            }
          });


    

            
        }
    }
     
});