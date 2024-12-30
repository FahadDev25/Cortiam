	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange talk"></span> Support History</h3>
			<div class="header-elements">
				<a href="#" class="dofullscreen"><span class="icon-co-big expand"></span></a>
			</div>
	  </div>
	  <div class="card-body">
			<ul class="media-list media-chat mb-3 pl-0">
				<?php
				if ($messages) {
					foreach ($messages as $message) {
						if ($message['msg_from'] == 'Agent') {
						echo '<li class="media media-chat-item-reverse">
										<div class="media-body">
											<div class="media-chat-item">'.nl2br($message['message_text']).'</div>
											<div class="font-size-sm text-muted mt-1 mb-2"><i class="icon-alarm text-muted"></i> '.time_elapsed_string($message['message_date']).' by You</div>
										</div>

										<div class="ml-3">
												<img src="'.(($message['agent_image'])? base_url(str_replace(".jpg","_mini.jpg",$message['agent_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="You">
										</div>
									</li>';
						}else{
							echo '<li class="media">
											<div class="mr-3">
												<img src="'.(($message['admin_image'])? base_url(str_replace(".jpg","_mini.jpg",$message['admin_image'])):base_url('images/userphoto_mini.jpg')).'" class="rounded-circle" width="40" height="40" alt="'.$message['admin'].'">
											</div>
											<div class="media-body">
												<div class="media-chat-item">'.nl2br($message['message_text']).'</div>
												<div class="font-size-sm text-muted mt-1 mb-2"><i class="icon-alarm text-muted"></i> '.time_elapsed_string($message['message_date']).' by '.$message['admin'].'</div>
											</div>
										</li>';
						}
					}
				}else{
					echo '<li class="media content-divider justify-content-center text-muted mx-0">You do not have any messages</li>';
				}
				?>
			</ul>
	  </div>
	</div>
	<form method="POST" class="ajaxform w-100" data-source="formajaxurl">
	<div class="card">
	  <div class="card-header header-elements-inline">
			<h3 class="card-title"><span class="icon-co-big orange envelope"></span> Send New Message</h3>
	  </div>
	  <div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group mb-0">
						<textarea name="message_text" id="message_text" class="form-control maxlength-textarea" rows="3" cols="1" placeholder="Enter your message..."></textarea>
					</div>
				</div>
			</div>

	  </div>
	  <div class="card-footer text-right pt-0">
	  	<a href="<?php echo cortiam_base_url('message-center');?>" class="button-dark float-left text-center">Back</a>
	  	<button type="submit" class="button-orange text-center">Send Message</button>
	  </div>
	</div>
	</form>