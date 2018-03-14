@extends('master.master')

@section('title', 'Order Entry')


@section('success')

    {{\Session::get('success')}}

@endsection

@section('error')

    {{\Session::get('error')}}

@endsection

@section('content')
    <script>

       $('document').ready(function () {

           $( "#dateRange" ).datepicker();
           $( "#dateRange" ).datepicker( "option", "dateFormat","yy-mm-dd" );
           $( "#dateRange" ).datepicker( "option", "showAnim", "drop" );

           $( "#item_name" ).select2({
               theme: "bootstrap"
           });

           var total =0 ;
           var count =0;

           $("#btn-Add").on('click',function(){


               var book_name = $("#item_name option:selected").text();
               var book_price = $("#item_name option:selected").val();

               total = total + parseInt(book_price);

               var rem_id = book_name.replace(/ \//g,"\n");


               $(".no-info").remove();
               $("#list-Container-name").append('<a class="list-group-item '+book_name+'"> ' + book_name + '</a>');
               $("#list-Container").append('<a class="list-group-item '+book_name+'"> ' + book_price  +'</a>');

               $('#lblTotal').text(total);

               count++;

               // var lastClass = $('div').attr('class').split(' ').pop();
           });
       }) ;



    </script>
    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Order Entry</h4>
            </div>
        </div>
        <form method="POST"  id="search-form" action="{{'OrderSave'}}">
            {{csrf_field()}}

            <input type="hidden" id="hddOrderUniqID" name="hddOrderUniqID" value="{{$auto_id}}">

            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <div class="row datatable-content">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="order_id">Order ID:</label>
                            <input type="text" class="form-control" id="order_id" name="order_id" value="{{$auto_id}}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="order_date">Order Date:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input name="dateRange" class="form-control pull-right" id="dateRange" value="" type="text">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cust_name">Customer Name:</label>
                            <input type="text" class="form-control" id="cust_name" name="cust_name" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cust_ph">Customer Phone(s):</label>
                            <input type="text" class="form-control" id="cust_phone" name="cust_phone" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cust_address">Customer Address:</label>
                            <input type="text" class="form-control" id="cust_address" name="cust_address" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cust_remark">Remark:</label>
                            <input type="text" class="form-control" id="cust_remark" name="cust_remark" >
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="item_name">Item Name(s):</label>
                            <div class="input-group">

                                <select class="form-control select-box" id="item_name" name="item_name">
                                    @foreach($book_data as $key => $value)
                                        <option value="{{$value->price}}">{{$value->book_name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="btn-Add">Add</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="list-group" id="list-Container-name">
                            <a href="#" class="list-group-item list-group-item-info">Book Name</a>
                            <a href="#" class="list-group-item no-info">No Info</a>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-left: -30px;">
                        <div class="list-group" id="list-Container">
                            <a href="#" class="list-group-item list-group-item-info">Book Price</a>
                            <a href="#" class="list-group-item no-info">No Info</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" style="margin-top: -20px;">
                        <div class="list-group" id="">
                            <a href="#" class="list-group-item">Total</a>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-left: -30px;margin-top: -20px;">
                        <div class="list-group" id="list-Container-total">
                            <a href="#" class="list-group-item" id="lblTotal">0</a>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">Save</button>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>
@endsection