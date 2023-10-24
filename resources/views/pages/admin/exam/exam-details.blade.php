@extends("layouts.admin")
@section("title", "Admin | Invoice")
@section("before_css")

@endsection
@section("main")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include("components.admin.tables.invoice.content_header")
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> Phú Tâm, Inc.
                                        <small class="float-right">Date: {{ $exam->created_at }}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            {{--                            <div class="row invoice-info">--}}
                            {{--                                <div class="col-sm-4 invoice-col">--}}
                            {{--                                    From--}}
                            {{--                                    <address>--}}
                            {{--                                        <strong>Phu Tam, Inc.</strong><br>--}}
                            {{--                                        Từ Sơn, Bắc Ninh<br>--}}
                            {{--                                        Phone: 0999999999<br>--}}
                            {{--                                        Email: phutamytb@gmail.com--}}
                            {{--                                    </address>--}}
                            {{--                                </div>--}}
                            {{--                                <!-- /.col -->--}}
                            {{--                                <div class="col-sm-4 invoice-col">--}}
                            {{--                                    To--}}
                            {{--                                    <address>--}}
                            {{--                                        <strong>{{ $exam->exam_name }}</strong><br>--}}
                            {{--                                        {{ $exam->address }}<br>--}}
                            {{--                                        Phone: {{ $exam->tel }}<br>--}}
                            {{--                                        Email: {{ $exam->User->email }}--}}
                            {{--                                    </address>--}}
                            {{--                                </div>--}}
                            {{--                                <!-- /.col -->--}}
                            {{--                                <div class="col-sm-4 invoice-col">--}}
                            {{--                                    <b>Invoice #PT{{ $exam->id }}</b><br>--}}
                            {{--                                    <br>--}}
                            {{--                                    <b>Order ID:</b> {{ $exam->id }}<br>--}}
                            {{--                                    <b>Payment Due:</b> {{ $exam->updated_at }}<br>--}}
                            {{--                                    <b>Account:</b> {{ $exam->User->name }}--}}
                            {{--                                </div>--}}
                            {{--                                <!-- /.col -->--}}
                            {{--                            </div>--}}
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th style="font-size: 16px">No.</th>
                                            <th class="shoping__product" style="font-size: 16px">Products</th>
                                            <th style="font-size: 16px">Price</th>
                                            <th style="font-size: 16px">Quantity</th>
                                            <th style="font-size: 16px">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--                                        @foreach($exam->Products as $item)--}}
                                        {{--                                            <tr>--}}
                                        {{--                                                <td>{{ $loop->index + 1 }}</td>--}}
                                        {{--                                                <td class="shoping__cart__item">--}}
                                        {{--                                                    <img src=" {{ $item->thumbnail }}" width="100" alt="">--}}
                                        {{--                                                    <h5 style="font-size: 16px">{{ $item->name }}</h5>--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="shoping__cart__price" style="font-size: 16px">--}}
                                        {{--                                                    ${{ $item->price }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="shoping__cart__quantity">--}}
                                        {{--                                                    <div class="quantity">--}}
                                        {{--                                                        <div class="" style="font-size: 16px">--}}
                                        {{--                                                            <span>{{ $item->pivot->qty }}</span>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td class="shoping__cart__total" style="font-size: 16px">--}}
                                        {{--                                                    ${{ $item->pivot->price * $item->pivot->qty }}--}}
                                        {{--                                                </td>--}}
                                        {{--                                            </tr>--}}
                                        {{--                                        @endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">
                                    <p class="lead">Payment Methods:</p>
                                    <img src="storage/img/dist/img/credit/visa.png" alt="Visa">
                                    <img src="storage/img/dist/img/credit/mastercard.png" alt="Mastercard">
                                    <img src="storage/img/dist/img/credit/american-express.png" alt="American Express">
                                    <img src="storage/img/dist/img/credit/paypal2.png" alt="Paypal">

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        Phu Tam <3 Tran Thuy <br>
                                        Phu Tam <3 Tran Thuy <br>
                                        Phu Tam <3 Tran Thuy <br>
                                        Phu Tam <3 Tran Thuy <br>
                                        Phu Tam <3 Tran Thuy <br>
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <p class="lead">Amount Due {{ $exam->updated_at }}</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                {{--                                                <td>{{ $exam->getGrandTotal() }}</td>--}}
                                            </tr>
                                            <tr>
                                                <th>Tax (10%)</th>
                                                {{--                                                <td>${{ ($exam->grand_total / 100 * 10) }}</td>--}}
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                @if($exam->shipping_method == "Free_Shipping")
                                                    <td class="text-success">Free</td>
                                                @else
                                                    {{--                                                <td>$5.00</td>--}}
                                                @endif
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                {{--                                                <td>${{ number_format($exam->grand_total + ($exam->grand_total / 100 * 10) + 5, 2) }}</td>--}}
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                                class="fas fa-print"></i> Print</a>
                                    @switch($exam->status)
                                        @case(0)
                                            <button type="button" class="btn btn-primary float-right"><i
                                                        class="fa fa-check" aria-hidden="true"></i>
                                                Confirm
                                            </button>
                                            <button type="button" class="btn btn-danger float-right"
                                                    style="margin-right: 5px;">
                                                <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                            </button>
                                            @break

                                        @case(1)
                                            <button type="button" class="btn btn-warning float-right"><i
                                                        class="fa fa-truck" aria-hidden="true"></i>
                                                Ship
                                            </button>
                                            <button type="button" class="btn btn-danger float-right"
                                                    style="margin-right: 5px;">
                                                <i class="fa fa-times" aria-hidden="true"></i> Cancel
                                            </button>
                                            @break
                                        @case(2)
                                            <button type="button" class="btn btn-info float-right"><i
                                                        class="fa fa-truck" aria-hidden="true"></i>
                                                Shipped
                                            </button>
                                            @break
                                        @case(3)
                                            <button type="button" class="btn btn-success float-right"><i
                                                        class="fa fa-check" aria-hidden="true"></i>
                                                Complete
                                            </button>
                                            @break
                                        @case(4)
                                        @case(5)
                                            <button type="button" class="btn btn-secondary float-right"><i
                                                        class="fa fa-cart-plus" aria-hidden="true"></i>
                                                Re buy
                                            </button>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("after_js")

@endsection
