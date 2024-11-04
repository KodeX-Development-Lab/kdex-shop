@extends('ecommerce.layout.master')
@section('content')
    <div class="container-fluid">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <strong>Product Detail</strong>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Image</label>
                                <div class="prevImg"></div>
                                <input type="file" class=" form-control" name="image" id="image">
                            </div>
                            <div class="form-group">
                                <label for="">Name (Eng)</label>
                                <input type="text" class=" form-control" name="name_en">
                            </div>
                            <div class="form-group">
                                <label for="">Name (MM)</label>
                                <input type="text" class=" form-control" name="name_mm">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <strong>Product Pricing</strong>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Buy Price</label>
                                <input type="text" class=" form-control" name="buy_price">
                            </div>
                            <div class="form-group">
                                <label for="">Sale Price</label>
                                <input type="text" class=" form-control" name="sale_price">
                            </div>
                            <div class="form-group">
                                <label for="">Discount Price</label>
                                <input type="text" class=" form-control" name="discount_price">
                            </div>
                            <div class="form-group">
                                <label for="">Total Quantity</label>
                                <input type="text" class=" form-control" name="total_qty">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Category</label>
                                <select name="category_id" class="form-control select2">
                                    @foreach ($category as $s)
                                        <option value="{{ $s->id }}">{{ $s->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Supplier</label>
                                <select name="supplier_id" class="form-control select2">
                                    @foreach ($supplier as $s)
                                        <option value="{{ $s->id }}">{{ $s->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Brand</label>
                                <select name="brand_id" class="form-control select2">
                                    @foreach ($brand as $s)
                                        <option value="{{ $s->id }}">{{ $s->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Color</label>
                                <select name="color_id[]" class="form-control select2" multiple>
                                    @foreach ($color as $s)
                                        <option value="{{ $s->id }}">{{ $s->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class=" btn btn-primary w-25">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\ProductCreate') !!}
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
