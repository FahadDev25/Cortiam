	<form method="POST" class="ajaxform w-100" data-source="formajaxurl">
	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange profile"></span> Approval Process Details</h3>
			<div class="header-elements">
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
			<ul class="media-list media-chat mb-3">
				<?php
				if ($history) {
					foreach ($history as $history_item) {
						if ($history_item['type'] == 'Admin') {
						echo '<li class="media media-chat-item-reverse">
										<div class="media-body">
											<div class="media-chat-item">'.nl2br($history_item['message_text']).'</div>
											<div class="font-size-sm text-muted mt-1 mb-2"><i class="icon-alarm ml-2 text-muted"></i> '.date("j F, Y h:i:s A",$history_item['message_date']).' by Cortiam</div>
										</div>

										<div class="ml-3">
												<img src="'.(($history_item['admin_image'])? base_url(str_replace(".jpg","_mini.jpg",$history_item['admin_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="'.$history_item['admin'].'">
										</div>
									</li>';
						}else{
							echo '<li class="media">
											<div class="mr-3">
												<img src="'.(($history_item['seller_image'])? base_url(str_replace(".jpg","_mini.jpg",$history_item['seller_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="'.$history_item['seller'].'">
											</div>
											<div class="media-body">
												<div class="media-chat-item">'.nl2br($history_item['message_text']).'</div>
												<div class="font-size-sm text-muted mt-1 mb-2"><i class="icon-alarm ml-2 text-muted"></i> '.date("j F, Y h:i:s A",$history_item['message_date']).' by '.$history_item['seller'].'</div>
											</div>
										</li>';
						}
					}
				}else{
					echo '<li class="media content-divider justify-content-center text-muted mx-0">No approval history</li>';
				}
				?>
			</ul>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<textarea name="message_text" id="message_text" class="form-control maxlength-textarea" rows="3" cols="1" placeholder="Enter your reason..."></textarea>
					</div>
				</div>
			</div>

	  </div>
	  <div class="card-footer text-right">
	  	<button type="submit" class="button-orange">Request Approval Again</button>
	  </div>
	</div>
	</form>