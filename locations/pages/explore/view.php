<div id="photo-view">
	<div class="container">
		<h3 class="venue-title text-uppercase">
			Margate Sands
		</h3>
	</div>
	<div class="container-fluid" style="background: #fff">
		<div class="photo-details container">
			<div class="row">
				<div class="col-md-12">
					<article class="photo-wrapper">
						<div class="photo-thumb">
							<img class="img-responsive" src="{img_path}">
						</div>
						<div class="details row">
							<div class="col-lg-8 col-md-8 col-sm-8">
								<h2 class="details-title text-uppercase">{title}</h2>
								<div class="details-body">
									<p>
										{description}
									</p>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<h3 class="info-title">Information</h3>
								<ul class="list-unstyled photo-info">
									<li class="post-author vcard">
										<i class="fa fa-user"></i>
										<span class="owner">
											<a title="{realname}">
												<span>{owner_name}</span>
											</a>
										</span>
									</li>
									<li class="post-labels">
										<i class="fa fa-tags"></i>
										<a rel="tag">
											<span>{tags}</span>
										</a>
									</li>
									<li class="post-timestamp">
										<i class="fa fa-calendar"></i>
										<a class="timestamp-link" title="{dateuploaded}">
											<abbr class="uploaded" title="{dateuploaded}">
												{dateuploaded}
											</abbr>
										</a>
									</li>
									<li class="post-comment-link">
										<i class="fa fa-comment"></i>
										<a class="comment-link">
											<span>{comments} comments</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
</div>