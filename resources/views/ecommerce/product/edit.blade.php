@extends('ecommerce.layout.master')
@section('content')
    <div class="container-fluid">
        <h5>Product Update</h5>
        <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-7">
                    <strong>Product Detail</strong>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Image</label>
                                <div class="prevImg">
                                    <img src="{{ asset('storage/'.$product->image) }}" class=" img-thumbnail">
                                </div>
                                <input type="file" class=" form-control" name="image" id="image">
                            </div>
                            <div class="form-group">
                                <label for="">Name (Eng)</label>
                                <input type="text" value="{{ $product->name_en }}" class="form-control" name="name_en">
                            </div>
                            <div class="form-group">
                                <label for="">Name (MM)</label>
                                <input type="text" value="{{ $product->name_mm }}"  class="form-control" name="name_mm">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <strong>Product Pricing</strong>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Buy Price</label>
                                <input type="text" class=" form-control" value="{{ $product->buy_price }}" name="buy_price">
                            </div>
                            <div class="form-group">
                                <label for="">Sale Price</label>
                                <input type="text" class=" form-control" value="{{ $product->sale_price }}" name="sale_price">
                            </div>
                            <div class="form-group">
                                <label for="">Discount Price</label>
                                <input type="text" class=" form-control" value="{{ $product->discount_price }}" name="discount_price">
                            </div>
                            <div class="form-group">
                                <label for="">Total Quantity</label>
                                <input type="text" class=" form-control" value="{{ $product->total_qty }}" name="total_qty">
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
                                        <option value="{{ $s->id }}" @if ($s->id == $product->category->id) selected @endif>{{ $s->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Supplier</label>
                                <select name="supplier_id" class="form-control select2">
                                    @foreach ($supplier as $s)
                                        <option value="{{ $s->id }}"  @if ($s->id == $product->supplier->id) selected @endif>{{ $s->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Brand</label>
                                <select name="brand_id" class="form-control select2">
                                    @foreach ($brand as $s)
                                        <option value="{{ $s->id }}"  @if ($s->id == $product->brand->id) selected @endif>{{ $s->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Color</label>
                                <select name="color_id[]" class="form-control select2" multiple>
                                    @foreach ($color as $s)
                                        <option value="{{ $s->id }}"
                                            @foreach ($product->color as $c)
                                            @if ($s->id == $c->id)
                                              selected
                                            @endif
                                        @endforeach>{{ $s->name_en }}</option>
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateProductRequest') !!}
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
