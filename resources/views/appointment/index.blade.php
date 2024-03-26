@extends('layouts.app')

@section('title', 'Appointments List')

@section('content')

    <div class="container mx-auto mt-4">
        <div id="success-alert" class="alert alert-success alert-dismissible fade" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <h1 class="text-3xl font-semibold mb-4">Appointments List</h1>

        <div class="button-container">
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAppointmentModal" style="margin: 10px;">
                        <i class="fa-solid fa-circle-plus"></i> Create Appointment
                    </button>                    
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">

                <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Service Name</th>
                        <th scope="col">Service Type</th>
                        <th scope="col">Office</th>
                        <th scope="col">Status</th>
                        <th scope="col">Booked At</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->service_name }}</td>
                            <td>{{ $appointment->service_type }}</td>
                            <td>{{ $appointment->office }}</td>
                            <td>{{ $appointment->status }}</td>
                            <td>{{ $appointment->booked_at }}</td>
                            <td>{{ $appointment->created_at }}</td>
                            <td>{{ $appointment->updated_at }}</td>
                            <td>
                                <!-- Button trigger modal -->
                                <div class="btn-group" role="actions">    
                                    <button type="button" class="btn btn-primary editAppointmentButton" style="width: 60px; font-size: 15px;"
                                        data-bs-toggle="modal" data-bs-target="#editAppointmentModal"
                                        data-id="{{ $appointment->id }}" data-service-name="{{ $appointment->service_name }}"
                                        data-service-type="{{ $appointment->service_type }}"
                                        data-office="{{ $appointment->office }}" data-status="{{ $appointment->status }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                
                                    <button type="button" class="btn btn-danger" style="width: 60px; font-size: 15px;"
                                        data-bs-target="#deleteAppointmentModal" data-bs-toggle="modal"
                                        onclick="showDeleteConfirmation({{ $appointment->id }})"><i class="fa-solid fa-trash"></i></button>
                                </div>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {{ $appointments->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>


    {{-- Javascript code --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = "{{ session('success') }}";

            if (successMessage) {
                var successAlert = document.getElementById('success-alert');
                successAlert.innerHTML = successMessage;
                successAlert.classList.add('show');
                setTimeout(function() {
                    successAlert.classList.remove('show');
                    setTimeout(function() {
                        successAlert.classList.add('fade');
                    }, 300);
                }, 2000);
            }
        });

        function showDeleteConfirmation(appointmentId) {
            var modal = new bootstrap.Modal(document.getElementById('deleteAppointmentModal'), {
                keyboard: false
            });

            var deleteForm = document.getElementById('delete-form');
            deleteForm.action = "{{ route('appointment.destroy', ['appointment' => ':id']) }}".replace(':id',
                appointmentId);

            modal.show();
        }
    </script>

    {{-- Edit Modal Script --}}
    <script>
        document.querySelectorAll('.editAppointmentButton').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const serviceName = this.getAttribute('data-service-name');
                const serviceType = this.getAttribute('data-service-type');
                const office = this.getAttribute('data-office');
                const status = this.getAttribute('data-status');

                document.getElementById('editForm').action = `/appointment/update/${id}`;
                document.querySelector('#editForm select[name="service_name"]').value = serviceName;
                document.querySelector('#editForm select[name="service_type"]').querySelector(
                    `option[value="${serviceType}"]`).selected = true;
                document.querySelector('#editForm select[name="office"]').querySelector(
                    `option[value="${office}"]`).selected = true;
                document.querySelector('#editForm select[name="status"]').querySelector(
                    `option[value="${status}"]`).selected = true;
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

@include('appointment.modals.edit')
@include('appointment.modals.create')
@include('appointment.modals.delete')
@endsection
