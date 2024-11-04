@extends('ecommerce.layout.master')
@section('title', 'Wallet Transaction')
@section('content')
    <div class="container-fluid">
        <div class=" d-flex">
            <div class="card mr-3">
                <div class="crad-body">
                    <select name="" id="" class=" form-control  type" style=" width : 100px">
                        <option value="">All</option>
                        <option value="1">Income</option>
                        <option value="2">Expense</option>
                    </select>
                </div>
            </div>
            <div class="card">
                <div class="crad-body">
                    <input type="text" class="form-control" placeholder="2017-06-04" id="mdate">
                </div>
            </div>
        </div>
        <div class="data">

        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            fetch()

            function fetch() {
                $.ajax({
                    type: "GET",
                    url: "walletTransactionData",
                    success: function(res) {
                        $('.data').html(res)
                    }
                });
            }
            $('.type').change(function() {
                let type = $('.type').val();
                $.ajax({
                    type: "GET",
                    url: `walletTransactionData?type=${type}`,
                    success: function(res) {
                        $('.data').html(res)
                    }
                });
            })
            $('#mdate').change(function() {
                let date = $('#mdate').val();
                $.ajax({
                    type: "GET",
                    url: `walletTransactionData?date=${date}`,
                    success: function(res) {
                        $('.data').html(res)
                    }
                });
            })
        })
    </script>
@endsection
