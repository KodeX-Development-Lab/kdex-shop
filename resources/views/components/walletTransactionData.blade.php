@foreach ($transaction as $t)
    <a href="{{ route('walletTransactionDetail', $t->trx_no) }}">
        <div class="card">
            <div class="card-body">
                @if ($t->type == 2)
                    <div class=" d-flex justify-content-between">
                        <div class="">
                            <h3 class=" text-primary">Sent money</h3>
                            <h4> Refer Id : {{ $t->ref_no }}</h4>
                            <h4>To : {{ $t->source->name }} ({{ $t->source->phone }})</h4>
                            <h4>{{ $t->created_at->format('j-F-Y') }} </h4>
                        </div>
                        <div class="">
                            <h4 class=" text-danger">-{{ $t->amount }} Ks</h4>
                        </div>
                    </div>
                @endif
                @if ($t->type == 1)
                    <div class=" d-flex justify-content-between">
                        <div class="">
                            <h3 class=" text-primary">Receive money</h3>
                            <h4> Refer Id : {{ $t->ref_no }}</h4>
                            <h4>From : {{ $t->source->name }} ({{ $t->source->phone }})</h4>
                            <h4>{{ $t->created_at->format('j-F-Y') }} </h4>
                        </div>
                        <div class="">
                            <h4 class=" text-success">+{{ $t->amount }} Ks</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </a>
@endforeach
<div class=" float-right">
    {{ $transaction->links() }}
</div>
