@extends('layouts.app')

@section('title', 'Schedule')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Service Details</h2>
                    <p>Select type of service</p>
                    <form>
                        <div class="mb-4">
                            <label for="service_name" class="form-label">Service Name:</label>
                            <select name="service_name" id="service_name" class="form-select">
                                <option value="">Select Service Name</option>
                                <option value="Business Permit Application">Business Permit Application</option>
                                <option value="Business Permit Renewal">Business Permit Renewal</option>
                                <option value="Payment of Business Permit">Payment of Business Permit</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="service_type" class="form-label">Service Type:</label>
                            <select name="service_type" id="service_type" class="form-select">
                                <option value="">Select Service Type</option>
                                <option value="New">New</option>
                                <option value="Renewal">Renewal</option>
                                <option value="Payment">Payment</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="office" class="form-label">Office:</label>
                            <select name="office" id="office" class="form-select">
                                <option value="">Select Office</option>
                                <option value="BLPD">BLPD</option>
                                <option value="CSWDO">CSWDO</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-9 text-left mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Logged in as: {{ Auth::user()->name }}</h5>
                    </div>
                </div>
            </div>
    
            <div class="col-md-12 text-left mt-4">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link"><i class="fa-solid fa-right-from-bracket">Logout</i></button>
                </form>
            </div>

        </div>
        

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Date</h2>
                    <p>To the extent possible, additional slots are made regularly.</p>
                    <div>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Time</h2>
                    <div id="EarliestAvailableAppointment"></div>
                    <div id="radioForm" class="text-center"></div>
                    @include('appointment.modal.emptyAllModal')
                    @include('appointment.modal.emptyBottonModal')
                    @include('appointment.modal.emptySerDiModal')
                    @include('appointment.modal.OptionModal')
                    @include('appointment.modal.successModal')
                </div>
            </div>
        </div>


    </div>
</div>

@endsection
