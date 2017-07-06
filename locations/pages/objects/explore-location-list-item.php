<div id="loc-container" class="col-sm-12" data-id="{id}" data-lat="{lat}" data-lng="{lng}">
	<div class="location-box">
		<div class="row content-holder">
			<div class="col-md-12 info-col">
				<div class="venue-block">
					<div class="venue-details">
						<div class="venue-name" data-location="{name}">
							<h2><a href="explore/photo/{id}/{enc_name}/{lat},{lng}">{name}</a></h2>
						</div>
						<div class="venue-meta">
							<div class="venue-address-data">
								<div class="venue-data">
									<span class="venue-data-item">
										<span class="category-name"><i class="fa fa-folder"></i> {categories}</span>
									</span>
								</div>
								<div class="venue-address"><i class="fa fa-map-marker"></i> {addr}</div>
							</div>
						</div>
					</div>
				</div>
				<div class="list-footer">
					<div class="buttons">
						<div class="btn-save {favourite}">
							<i class="fa fa-heart"></i>
							<span class="label">{btn-txt}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>