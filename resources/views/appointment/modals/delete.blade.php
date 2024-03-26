  <div class="modal" id="deleteAppointmentModal" tabindex="-1">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Delete Appointment</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <p>Are you sure you want to delete this appointment?</p>
              </div>
              <div class="modal-footer">
                  <form id="delete-form" method="post">
                      @csrf
                      @method('delete')
                      <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

              </div>
          </div>
      </div>
  </div>
