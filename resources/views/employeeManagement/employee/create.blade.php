@extends('ecommerce.layout.master')
@section('content')
    <div class="container-fluid">
        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Image</label>
                                <div class="prevImg"></div>
                                <input type="file" name="image" id="image" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input type="number" name="phone" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" name="address" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Employee Id</label>
                                <input type="text" name="employee_id" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Nrc Number</label>
                                <input type="text" name="nrc_number" class=" form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Pin Code</label>
                                <input type="text" name="pin_code" class=" form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Role</label>
                                <select name="role[]" id="" class=" form-control select2">
                                    @foreach ($role as $d)
                                        <option value="{{ $d->name }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Department</label>
                                <select name="department_id" id="" class=" form-control select2">
                                    @foreach ($department as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Gender</label>
                                <select name="gender" id="" class=" form-control select2">
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Birthday</label>
                                <input type="date" class=" form-control" name="birthday">
                            </div>
                            <div class="form-group">
                                <label for="">Join Date</label>
                                <input type="date" class=" form-control" name="join_date">
                            </div>
                            <div class="form-group">
                                <label for="">Is present</label>
                                <select name="is_present" id="" class=" form-control select2">
                                    <option value="1">Is present</option>
                                    <option value="0">Leave</option>
                                </select>
                            </div>
                            <button class=" btn btn-primary w-100">Comfirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\createEmployee') !!}
    <script>
        $(document).ready(function() {
            $('#image').on('change', function() {
                let imgLength = document.getElementById('image').files.length
                $('.prevImg').html('')
                for (var i = 0; i < imgLength; i++) {
                    $('.prevImg').append(
                        `<img class=" img-thumbnail" src="${URL.createObjectURL(event.target.files[i])}">`
                    )
                }
            })
        })
    </script>
@endsection
