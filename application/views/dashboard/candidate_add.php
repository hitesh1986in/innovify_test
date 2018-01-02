<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php echo $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Add Candidate</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Candidate name">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Candidate email id">
				</div>
                <div class="form-group">
                    <label for="contact">Contact Number</label>
                    <input type="contact" class="form-control" id="contact" name="contact" placeholder="Candidate contact number">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="amount" class="form-control" id="amount" name="amount" placeholder="Payable Amount to Candidate">
                </div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->