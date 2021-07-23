@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div id="success" style="display: none" class="col-md-8 text-center h3 p-4 bg-success text-light rounded">تمت
                عملية الشراء بنجاح</div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">عربة التسوق</div>

                    <div class="card-body">

                        @if ($items->count())

                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">العنوان</th>
                                        <th scope="col">السعر</th>
                                        <th scope="col">الكمية</th>
                                        <th scope="col">السعر الكلي</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                @php($totalPrice = 0)
                                @foreach ($items as $item)
                                    @php($totalPrice += $item->price * $item->pivot->number_of_copies)

                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $item->title }}</th>
                                            <td>{{ $item->price }} $</td>
                                            <td>{{ $item->pivot->number_of_copies }}</td>
                                            <td>{{ $item->price * $item->pivot->number_of_copies }} $</td>
                                            <td>
                                                <form style="float:left; margin: auto 5px" method="post"
                                                    action="{{ route('cart.removeAll', $item->id) }}">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" type="submit">أزل الكل</button>
                                                </form>

                                                <form style="float:left; margin: auto 5px" method="post"
                                                    action="{{ route('cart.removeOne', $item->id) }}">
                                                    @csrf
                                                    <button class="btn btn-warning btn-sm" type="submit">أزل واحدًا</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>

                            <h4>المجموع النهائي: {{ $totalPrice }} $</h4>
                            <div id="paypal-button"></div>
                        @else

                            <h1>لا يوجد كتب في العربة</h1>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://www.paypal.com/sdk/js?client-id=AexXm3q3WdlRb-SDY7GfS2i-ntwQKE5DivMW_TfpOGfL--p8nu8U5OecMsf6yIIZL70fWgKUFF_1zDd6&currency=USD"></script>

<script>
    // Render the PayPal button into #paypal-button-container
    if (document.getElementById('paypal-button')){
        paypal.Buttons({
        // Call your server to set up the transaction
        createOrder: function(data, actions) {
            return fetch("/api/create-payment/{{auth()->id()}}", {
                method: 'post',
                headers: {
                   'content-type': 'application/json'
                },
  
            }).then(function(res) {
                return res.json();
            })
            .then(function(orderData) {
                return orderData.id;
            }).catch( function(e) {
                console.log('>>>>>>>>>>> e', e)
            });
        },

        // Call your server to finalize the transaction
        onApprove: function(data, actions) {
            return fetch('/api/execute-payment/' + data.orderID + '/capture/', {
                method: 'post',
                headers: {
                   'content-type': 'application/json'
                }
            }).then(function(res) {
                return res.json();
            }).then(function(orderData) {
                $('#success').slideDown(200);
                $('.card-body').slideUp(0);
            });
        }

    }).render('#paypal-button');
    }

</script>
@endsection
