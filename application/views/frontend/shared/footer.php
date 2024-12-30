

<footer>
  <div class="container">
		<div class="row mb-4 d-none d-sm-block">
		  <div class="col-sm-12">
				<a href="<?php echo base_url('');?>" class="d-inline-block">
					<img src="<?php echo base_url('images/cortiam_logo.png');?>" class="cortiam-logo" alt="Cortiam">
				</a>
		  </div>
		</div>
		<div class="row top">
		  <div class="col-md-3">
			  <h4>Address</h4>
			  <p>Cortiam Inc.<br>331 East Main Street<br>Suite 200 - #1175<br>Rock Hill, SC 29730</p>
		  </div>
		  <div class="col-md-3">
			  <h4>Phone</h4>
			  <a href="tel:1-888-788-7252">1-888-788-7252</a>
			  <h4 class="mt-2">Hours of Operation</h4>
			  <p>Monday - Friday 9am - 5pm EST</p>
		  </div>
		  <div class="col-md-2"></div>
		  <div class="col-md-4 pt-3 pt-md-0">
		    <h5>Features</h5>
		    <ul class="list-unstyled text-small">
		      <li><a href="<?php echo base_url('');?>">Home</a></li>
		      <li><a href="<?php echo base_url('set-your-terms');?>">Set Your Terms</a></li>
		      <li><a href="<?php echo base_url('agents-on-cortiam');?>">Agent Locator</a></li>
		      <li><a href="<?php echo base_url('agents');?>">Agents</a></li>
		      <li><a href="<?php echo base_url('join-our-team');?>">Join Our Team</a></li>
		    </ul>
		  </div>
		</div>
		<hr class="py-md-2">
		<div class="row bottom">
		  <div class="col-md-3">&copy; <?php echo date('Y');?> Copyright CORTIAM</div>
		  <div class="col-md-9 text-right">
		  	<ul class="list-unstyled text-small">
		  		<li><a href="<?php echo base_url('about-us');?>">About</a></li>
		  		<li><a href="<?php echo base_url('contact-us');?>">Contact Us</a></li>
		  		<li><a href="<?php echo base_url('terms-of-use');?>">Terms</a></li>
		  		<li><a href="<?php echo base_url('privacy-policy');?>">Privacy</a></li>
		  		<li class="noborder"><a href="https://m.facebook.com/cortiaminc" class="sociallink facebook" target="_blank"></a></li>
		  		<li class="noborder"><a href="https://twitter.com/Cortiam_Inc" class="sociallink twitter" target="_blank"></a></li>
		  		<li class="noborder"><a href="https://instagram.com/cortiam_inc" class="sociallink instagram" target="_blank"></a></li>
<!--		  		<li class="noborder"><a href="#" class="sociallink linkedin"></a></li>-->
		  	</ul>
		  </div>
		</div>
	</div>
</footer>
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="embed-responsive embed-responsive-16by9">
				  <iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
				</div>
      </div>
    </div>
  </div>
</div>
		<?php if (isset($footer_data['js_files'])) { echo "\n\t<script src=\"".implode("\"></script>\n\t<script src=\"",$footer_data['js_files'])."\"></script>\n";}?>


	</body>



	<!-- end Body -->
</html>