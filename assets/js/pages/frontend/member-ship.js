$(document).ready(function(){


   $('.resend-email').click(function(){

      let url = $(this).attr('data-url');
      
      $.ajax({url: url, success: function(result){

            if(result == "true")
            {  

               $('#myModal').modal('toggle');

               swal.fire({
                  title: "Resend Email",
                  text: "Email send successfully!",
                  type: "success",
                  confirmButtonClass: "btn btn-success"
               });
            }else{

               swal.fire({
                  title: "Resend Email",
                  text: "Email not exist",
                  type: "error",
                  confirmButtonClass: "btn btn-danger"
               });
            }
      }});

   });

});