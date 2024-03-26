 <div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel"
     aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Edit Appointment</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form id="editForm" method="post"
                     action="{{ route('appointment.update', ['appointment' => $appointment->id]) }}"
                     onsubmit="return validateForm()">
                     @csrf
                     @method('put')
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
                             <option value="New" {{ $appointment->service_type == 'New' ? 'selected' : '' }}>New
                             </option>
                             <option value="Renewal" {{ $appointment->service_type == 'Renewal' ? 'selected' : '' }}>
                                 Renewal</option>
                             <option value="Payment" {{ $appointment->service_type == 'Payment' ? 'selected' : '' }}>
                                 Payment</option>
                         </select>
                         <div id="serviceTypeError" class="error"></div>
                     </div>

                     <div class="mb-3">
                         <label for="office" class="form-label">Office:</label>
                         <br>
                         <select name="office" id="office" class="form-select">
                             <option value="BLPD" {{ $appointment->office == 'BLPD' ? 'selected' : '' }}>BLPD</option>
                             <option value="CSWDO" {{ $appointment->office == 'CSWDO' ? 'selected' : '' }}>CSWDO
                             </option>
                         </select>
                         <div id="officeError" class="error"></div>
                     </div>

                     <div class="mb-3">
                         <label for="status" class="form-label">Status:</label>
                         <br>
                         <select name="status" id="status" class="form-select">
                             <option value="Completed" {{ $appointment->status == 'Completed' ? 'selected' : '' }}>
                                 Completed</option>
                             <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending
                             </option>
                             <option value="InProgress" {{ $appointment->status == 'InProgress' ? 'selected' : '' }}>In
                                 Progress</option>
                             <option value="Rejected" {{ $appointment->status == 'Rejected' ? 'selected' : '' }}>
                                 Rejected</option>
                         </select>
                         <div id="statusError" class="error"></div>
                     </div>

                     <button type="submit" class="btn btn-primary">Update</button>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>
