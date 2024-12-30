	

	<form method="POST" class="couponform w-100" data-source="formajaxurl">
		<div class="card" id="couponaddpart">
			<div class="card-header header-elements-inline">
					<h3 class="card-title"><span class="icon-co-big orange coupon"></span> Membership Plans</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-md-8 offset-md-2">
						<div class="form-group">
							<h5 class="col-sm-12">Select a Plan</h5>

						<div class="row">
						<?php
							if(isset($plans) && $plans !== '')
							{								
						?>
							<div class="col-sm-4">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">Special title treatment</h5>
										<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
										<a href="#" class="btn btn-primary">Go somewhere</a>
									</div>
								</div>
							</div>


							<div class="col-sm-4">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">Special title treatment</h5>
										<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
										<a href="#" class="btn btn-primary">Go somewhere</a>
									</div>
								</div>
							</div>


							<div class="col-sm-4">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">Special title treatment</h5>
										<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
										<a href="#" class="btn btn-primary">Go somewhere</a>
									</div>
								</div>
							</div>


						<?php 
							}
						?>
						</div>
							
						</div>	
					</div>					
				</div>
			</div>
		</div>
	</form>
