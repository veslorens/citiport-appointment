<div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="createAppointmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" method="post" action="{{ route('appointment.store') }}"
                    onsubmit="return validateForm()">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="service_name" class="form-label">Service Name:</label>
                        <br>
                        <select name="service_name" id="service_name" class="form-select">
                            <option value="Business Permit Application">Business Permit Application</option>
                            <option value="Business Permit Renewal">Business Permit Renewal</option>
                            <option value="Payment of Business Permit">Payment of Business Permit</option>
                        </select>
                        <div id="serviceNameError" class="error"></div>
                    </div>


                    <div class="mb-3">
                        <label for="service_type" class="form-label">Service Type:</label>
                        <br>
                        <select name="service_type" id="service_type" class="form-select">
                            <option value="New">New</option>
                            <option value="Renewal">Renewal</option>
                            <option value="Payment">Payment</option>
                        </select>
                        <div id="serviceTypeError" class="error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="office" class="form-label">Office:</label>
                        <br>
                        <select name="office" id="office" class="form-select">
                            <option value="BLPD">BLPD</option>
                            <option value="CSWDO">CSWDO</option>
                        </select>
                        <div id="officeError" class="error"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
