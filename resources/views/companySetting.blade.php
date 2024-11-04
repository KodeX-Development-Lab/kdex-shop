@extends('ecommerce.layout.master')
@section('title', 'Company Setting')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class=" text-center text-secondary">Company Setting</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-center ">
                        <img src="{{ asset('images/company.jpg') }}" id="images" style=" width : 430px ; height : 430px">
                    </div>
                    <div class="col-md-6  py-4">
                        <h4 class=" mt-4 text-secondary">Company Name : {{ $company->name }}</h4>
                        <h4 class=" mt-4 text-secondary">Company Email : {{ $company->email }}</h4>
                        <h4 class=" mt-4 text-secondary">Company Phone : {{ $company->phone }}</h4>
                        <h4 class=" mt-4 text-secondary">Company Address : {{ $company->address }}</h4>
                        <h4 class=" mt-4 text-secondary">Office Start Time : {{ $company->office_start_time }}</h4>
                        <h4 class=" mt-4 text-secondary">Office End Time : {{ $company->office_end_time }}</h4>
                        <h4 class=" mt-4 text-secondary">Break Start Time : {{ $company->break_start_time }}</h4>
                        <h4 class=" mt-4 text-secondary">Break End Time : {{ $company->break_end_time }}</h4>
                    </div>
                </div>
                <div class=" d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target=".bd-example-modal-lg">Edit Company Setting</button>
                </div>
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Company Setting</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="update" action="{{ route('company-setting.update', $company->id) }}"
                                    method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="">Company Name</label>
                                        <input type="text" name="name" value="{{ $company->name }}"
                                            class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Company Email</label>
                                        <input type="email" name="email" value="{{ $company->email }}"
                                            class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Company Phone</label>
                                        <input type="text" name="phone" value="{{ $company->phone }}"
                                            class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Company Address</label>
                                        <input type="text" name="address" value="{{ $company->address }}"
                                            class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Office Start Time</label>
                                        <input type="time" name="office_start_time"
                                            value="{{ $company->office_start_time }}" class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Office End Time</label>
                                        <input type="time" name="office_end_time"
                                            value="{{ $company->office_end_time }}" class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Break Start Time</label>
                                        <input type="time" name="break_start_time"
                                            value="{{ $company->break_start_time }}" class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Break End Time</label>
                                        <input type="time" name="break_end_time" value="{{ $company->break_end_time }}"
                                            class=" form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Comfirm</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\CompanySettingRequest', '#update') !!}
@endsection
