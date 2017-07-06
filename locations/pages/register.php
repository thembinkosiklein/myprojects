<div class="container">
	<div class="row" style="margin-top:50px;">	
		<div class="col-md-12 text-center" style="margin-bottom: 15px;">
			<h1>Create Account</h1>
		</div>
		<div class="col-md-4 col-md-offset-4">
			<form method="post" role="form" id="registerFrm">
				<fieldset>
					<legend>Information</legend>
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" id="name" class="form-control" required="required">
					</div>
					<div class="form-group">
						<label for="">Surname</label>
						<input type="text" id="surname" class="form-control" required="required">
					</div>

					<legend>Credentials</legend>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="email" id="username" class="form-control" placeholder="E-mail address" required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" id="password" class="form-control" placeholder="Password" required="required">
						</div>
					</div>
					<div>
						<button class="btn btn-primary btn-block" id="createAccountBtn">
							Create Account
						</button>
						<div class="text-center" style="padding: 10px">
							Already have an account? <a href="login">Log In</a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>