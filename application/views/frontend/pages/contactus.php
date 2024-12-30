
<main role="main">
	<div class="contactus jumbotron jumbotron-fluid mb-0">
	  <div class="container">
		  <h1 class="headline">CONTACT US</h1>
		  <br>
	  </div>
	</div>
	<div class="contactus-content">
	  <div class="container">
			<div class="row">
			  <div class="col-md-5 formside">
			  	<h3>CONTACT US</h3>
			  	<div id="response"></div>
					<form method="POST" class="contactusform w-100">
				  <div class="form-group">
				    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
				  </div>
				  <div class="form-group">
				    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
				  </div>
				  <div class="form-group">
				    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
				  </div>
				  <div class="form-group">
				    <input type="tel" class="form-control format-phone-number" name="phone" id="phone" placeholder="Phone Number">
				  </div>
				  <div class="form-group">
				    <textarea type="tel" class="form-control" name="comments" id="comments" placeholder="Comments"></textarea>
				  </div>
				  <div class="form-group text-left">
				    <input type="submit" class="button-orange" value="SUBMIT">
				  </div>
				  </form>
			  </div>
			  <div class="col-md-6 offset-md-1 infoside">
			  	<div class="row">
			  		<div class="col-sm-12 mb-3">
			  			<img src="<?php echo base_url('images/contact_image.jpg');?>" alt="Contact Us" class="img-fluid">
			  		</div>
			  		<div class="col-md-12">
			  			<h4>Contact Information</h4>
			  		</div>
			  		<div class="col-md-6">
			  			<p>Cortiam Inc.<br>331 East Main Street<br>Suite 200 - #1175<br>Rock Hill, SC 29730</p>
			  		</div>
			  		<div class="col-md-6">
			  			<a href="tel:1-888-788-7252">1-888-788-7252</a>
			  			<a href="mailto:customerservice@cortiam.com">customerservice@cortiam.com</a>
			  		</div>
			  	</div>
			  </div>
		  </div>
  	</div>
	</div>
	<div class="orange-bar">
	  <div class="container">
			<div class="row">
			  <div class="col-sm-12 text-center">
			  	<h3>READY TO GET STARTED?</h3>
			  	<h4 class="px-5 mb-4">Selling your home on your terms is one click away. </h4>
			  	<a href="<?php echo base_url('sign-up');?>" class="button-white">GET STARTED</a>
			  </div>
		  </div>
	  </div>
  </div>
</main>