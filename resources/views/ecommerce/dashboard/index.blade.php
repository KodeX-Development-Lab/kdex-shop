@extends('ecommerce.layout.master')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <h4 class=" text-center text-white">Today Income</h4>
                                <h3 class=" text-center text-white">{{ $income }} Ks</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <h4 class=" text-center text-white">Today Outcome</h4>
                                <h3 class=" text-center text-white">{{ $outcome }} Ks</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <div class=" d-flex  justify-content-center align-items-center">
                                    <div class=" mx-3">
                                        <i class=" fas fa-users text-white" style=" font-size : 60px"></i>
                                    </div>
                                    <div class="">
                                        <h4 class=" text-white text-center">Customer</h4>
                                        <h3 class=" text-white text-center">{{ $customer }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <h4 class=" text-center text-white">Company Wallet Amount</h4>
                                <h3 class=" text-white text-center">{{ $companyWallet->amount }}Ks</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="row">
                        <div class="col-6">
                            <div class="card" style="background-color: #eefcff">
                                <div class="card-body">
                                    <h3>Order Data</h3>
                                    <canvas id="saleChart" class=" w-100"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card" style="background-color: #eefcff">
                                <div class="card-body">
                                    <h3>Income Outcome</h3>
                                    <canvas id="incomeOutcome" class=" w-100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Less Than 3 Quantity</h4>
                        <table class=" table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Product Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $p)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $p->image) }}" class=" img-thumbnail">
                                        </td>
                                        <td>{{ $p->name_en }}</td>
                                        <td>{{ $p->total_qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('saleChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($month),
                    datasets: [{
                        label: 'Order Data',
                        data: @json($order),
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const labels = @json($monthDay);
            const inOutdata = {
                labels: labels,
                datasets: [{
                    label: 'Income',
                    data: @json($incomeCount),
                    fill: false,
                    borderColor: 'green',
                    tension: 0.1
                }, {
                    label: 'Outcome',
                    data: @json($outcomeCount),
                    fill: false,
                    borderColor: 'red',
                    tension: 0.1
                }]
            };
            const inOutconfig = {
                type: 'line',
                data: inOutdata,
                options: {}
            };
            new Chart(
                document.getElementById('incomeOutcome'),
                inOutconfig
            )
        })
    </script>
@endsection
