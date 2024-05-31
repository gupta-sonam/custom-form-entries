<form id="cfe_form" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" id="first_name" name="first_name" class="form-control" required>
        <div class="invalid-feedback">
            Please enter your first name.
        </div>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" id="last_name" name="last_name" class="form-control" required>
        <div class="invalid-feedback">
            Please enter your last name.
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
        <div class="invalid-feedback">
            Please enter a valid email address.
        </div>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control" required>
        <div class="invalid-feedback">
            Please enter your phone number.
        </div>
    </div>
    <button type="submit" class="btn btn-primary" id="cfe_submit_btn">
        Submit
        <span id="cfe_loader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
    </button>
</form>
<div id="cfe_response" class="mt-3"></div>