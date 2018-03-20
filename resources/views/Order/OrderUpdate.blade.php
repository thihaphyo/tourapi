@extends('master.master')

@section('title', 'Order Edit')


@section('success')

    {{\Session::get('success')}}

@endsection

@section('error')

    {{\Session::get('error')}}

@endsection

@section('content')

    <style>

        .select2-container--bootstrap{
            width: 100%!important;
        }
        #btn-Add{
            cursor: pointer;
        }
        #btn-Add:hover{
            background:lightgray;
        }

        .status_table{
            max-height: 150px;
            overflow-y: auto;
        }
    </style>

    <script>
        $( function() {
            $( "#tabs" ).tabs({
                beforeLoad: function( event, ui ) {
                    ui.jqXHR.fail(function() {
                        ui.panel.html(
                            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                            "If this wouldn't be a demo." );
                    });
                }
            });
        } );

        $('document').ready(function () {

            $( "#dateRange" ).datepicker({ dateFormat: 'yy/mm/dd' });
            $('#statusDate').datepicker({ dateFormat: 'yy/mm/dd' });

            $( "#item_name" ).select2({
                theme: "bootstrap"
            });

            var total =parseInt($('#lblTotal').text()) ;
            var count =parseInt($('#hddCount').val());

            $("#btn-Add").on('click',function(){


                var book_name = $("#item_name option:selected").text();
                var book_price = $("#item_name option:selected").val().split('book_id')[0];
                var book_id = $("#item_name option:selected").val().split('book_id')[1];



                var arr=$('#bookName').val().split(",");

                arr.push(book_name);

                $('#bookName').val(arr.toString());


                var arr2 = $('#bookID').val().split(",");

                arr2.push(book_id);

                $('#bookID').val(arr2.toString());


                var arr3 = $('#bookPrice').val().split(",");

                arr3.push(book_price);

                $('#bookPrice').val(arr3.toString());



                total = parseInt($('#lblTotal').text());
                total = total + parseInt(book_price);

                var rem_id = book_name.replace(/ \//g,"\n");


                $("#no_info").remove();

                var html = '';
                html+='<tr>';
                html+='<td>'+book_name;
                html+='</td>';
                html+='<td>'+book_price;
                html+='</td>';
                html+='<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>';
                html+='</tr>';

                $('#item_table > tbody').append(html);

                $('#lblTotal').text(total);

                $('#hddTotal').val(total);


                count++;

                $('#hddCount').val(count);


            });

            $(document).on('click', '.remove', function(){
                var no_html ='';

                var rem_val =parseInt($(this).parent().siblings(":nth-child(2)").text().split('book_id')[0]);

                var index = $(this).closest('tr').index();



                var arr=$('#bookName').val().split(",");

                arr.splice(index, 1);

                $('#bookName').val(arr.toString());


                var arr2=$('#bookID').val().split(",");

                arr2.splice(index, 1);



                $('#bookID').val(arr2.toString());


                var arr3=$('#bookPrice').val().split(",");

                arr3.splice(index, 1);

                $('#bookPrice').val(arr3.toString());



                total-=rem_val;


                $(this).closest('tr').remove();
                $('#lblTotal').text(total);
                $('#hddTotal').val(total);

                count--;

                $('#hddCount').val(count);

                if(count === 0)
                {
                    no_html+='<tr>';
                    no_html+='<td id="no_info" class="text-center" colspan="3">No Info Yet</td>';

                    $('#item_table > tbody').append(no_html);
                    $('#lblTotal').text(total);
                    $('#hddTotal').val(total);


                }
            });


            $('#btn-Cust').on('click',function () {
                $("#LoadingImage").show();

                if($('#cust_name').val() == '')
                {
                    $("#LoadingImage").hide();
                    $.alert({
                        title: 'Error',
                        content: 'Incomplete Information!',
                    });
                }else{

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });

                    var formData = {
                        order_id: $('#hddOrderUniqID').val(),
                        cust_name: $('#cust_name').val(),
                        cust_phone: $('#cust_phone').val(),
                        cust_address:$('#cust_address').val(),
                        remark:$('#remark').val(),
                        postcode : $('#postcode').val()


                    };

                    var CustUpdateApi = "CustUpdate";
                    var type = "GET";

                    $.ajax({

                        type: type,
                        url: CustUpdateApi,
                        data: formData,
                        dataType: 'json',
                        success: function (data) {
                            if(data=="Success"){
                                $("#LoadingImage").hide();
                                $.alert({
                                    title: 'Information',
                                    content: 'Successfully Updated Customer Info!',
                                });
                            }

                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });

                }

            });


            $('#btn-Item').on('click',function () {

                $("#LoadingImage").show();

                if(count == 0)
                {
                    $("#LoadingImage").hide();
                    $.alert({
                        title: 'Error',
                        content: 'Incomplete Information!',
                    });
                }else{

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });

                    var formData = {
                        order_id: $('#hddOrderUniqID').val(),
                        order_date: $('#dateRange').val(),
                        book_names: $('#bookName').val(),
                        book_ids:$('#bookID').val(),
                        book_prices:$('#bookPrice').val()

                    };


                    var ItemUpdateUrl = "ItemUpdate";
                    var type = "GET";

                    $.ajax({

                        type: type,
                        url: ItemUpdateUrl,
                        data: formData,
                        dataType: 'json',
                        success: function (data) {
                            if(data=="Success"){
                                $("#LoadingImage").hide();

                                $.alert({
                                    title: 'Information',
                                    content: 'Successfully Updated Item Info!',
                                });

                            }

                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });


                }



            });


            $('#btn-Status').on('click',function () {

                $("#LoadingImage").show();

                if($('#statusDate').val() == '')
                {
                    $("#LoadingImage").hide();
                    $.alert({
                        title: 'Error',
                        content: 'Incomplete Information!',
                    });
                }else{
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });


                    var formData = {
                        order_id: $('#hddOrderUniqID').val(),
                        status_name: $("#status_name option:selected").val(),
                        status_date: $('#statusDate').val()

                    };

                    var StatusUpdateUrl = "OrderStatusUpdate";
                    var type = "GET";

                    var StatusLogUrl = "GetStatusLog";

                    $.ajax({

                        type: type,
                        url: StatusUpdateUrl,
                        data: formData,
                        dataType: 'json',
                        success: function (data) {

                            $('#status_body').html(data.toString());
                            $("#LoadingImage").hide();

                            $.alert({
                                title: 'Information',
                                content: 'Successfully Updated Status Info!',
                            });

                        },
                        error: function (data) {
                            $("#LoadingImage").hide();
                            console.log('Error:', data);
                        }
                    });
                }




            });

        }) ;
    </script>

    <div class="container content-body">

        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Order Edit</h4>
            </div>
        </div>

        <div id="LoadingImage" style="display:none;position: absolute; top: 280px;left:500px; z-index: 99999; height: 600px;">
            <img src="{{asset('images/loader.gif')}}" style="" />
        </div>

        <form method="POST"  id="search-form" action="{{'ItemUpdate'}}">
            {{csrf_field()}}

            <input type="hidden" id="hddOrderUniqID" name="hddOrderUniqID" value="{{$order_id}}">
            <input type="hidden" id="hddTotal" name="hddTotal" value="0">
            <input type="hidden" id="hddCount" name="hddCount" value="{{count($order_items)}}">

            <input type="hidden" id="bookName" name="hddBookName" value="{{$book_names}}">
            <input type="hidden" id="bookPrice" name="hddBookPrice" value="{{$book_prices}}">
            <input type="hidden" id="bookID" name="hddBookID" value="{{$book_ids}}">

            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <div class="row datatable-content">
                <div class="row" style="padding: 20px;">
                    <div id="tabs" class="col-md-12">
                        <ul>
                            <li><a href="#tabs-customer-info">Customer Information</a></li>
                            <li><a href="#tabs-item-info">Item Information</a></li>
                            <li><a href="#tabs-status-info">Status Information</a></li>
                        </ul>
                        <div id="tabs-customer-info">
                           <div class="row">
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="order_id">Order ID:</label>
                                    <input type="text" class="form-control" id="order_id" name="order_id" value="{{$order_id}}" disabled>
                                </div>
                             </div>
                           </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cust_name">Customer Name:</label>
                                        <input type="text" class="form-control" id="cust_name" name="cust_name" value="{{$data->cust_name}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cust_phone">Customer Phone:</label>
                                        <input type="text" class="form-control" id="cust_phone" name="cust_phone" value="{{$data->cust_ph}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cust_address">Customer Address:</label>
                                        <textarea rows="8" class="form-control" id="cust_address" name="cust_address" >{{$data->cust_address}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="remark">Remark:</label>
                                        <textarea rows="8" class="form-control" id="remark" name="remark" >{{$data->remark}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="postcode">E-Postcode:</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode" value="{{$data->postcode}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="button" name="btn-Update" id="btn-Cust" class="btn btn-primary form-control">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tabs-item-info">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order_id">Order ID:</label>
                                        <input type="text" class="form-control" id="order_id" name="order_id" value="{{$order_id}}" disabled>
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
                                            <input type="text" class="form-control" id="dateRange" name="dateRange" value="{{$data->order_date}}" >

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order_date">Item Name(s):</label>
                                        <div class="input-group">

                                            <select class="form-control select-box" id="item_name" name="item_name">
                                                @foreach($book_data as $key => $value)
                                                    <option value="{{$value->price.'book_id'.$value->book_id}}">{{$value->book_name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-addon" id="btn-Add">
                                                <i class="fa fa-plus" ></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-8 table-responsive">
                                    <table class="table table-bordered table-striped" id="item_table">
                                        <thead class="bg-info">
                                        <th class="text-info">Book Name</th>
                                        <th class="text-info">Book Price</th>
                                        <th class="text-info">Action</th>
                                        </thead>
                                        <tbody>
                                        <?php $price = 0;$book_name_arr='';$book_id_arr= '';$book_price_arr='';?>
                                        @foreach($order_items as $key => $value)
                                            <?php $book_id = $value->id;


                                                  $book_name= $value->name;
                                                  $book_price = $value->price;

                                                  $price+=$book_price;?>
                                               <tr>
                                                <td>
                                                    {{$book_name}}


                                                </td>
                                                <td>
                                                    {{$book_price}}
                                                </td>
                                                <td>
                                                    <button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button>
                                                </td>
                                               </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                        <tr class="footer">
                                            <td class="text-right">Total</td>
                                            <td colspan="2" class="text-right" id="lblTotal">
                                                {{$price}}
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="button" name="btn-Update" id="btn-Item" class="btn btn-primary form-control">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tabs-status-info">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order_id">Order ID:</label>
                                        <input type="text" class="form-control" id="order_id" name="order_id" value="{{$order_id}}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status_id">Status Name:</label>
                                        <select class="form-control select-box" id="status_name" name="status_name">
                                            @foreach($status_list as $key => $value)
                                                <option value="{{$value->idx}}" {{$value->idx == $data->status_id ? "selected" : ""}}>{{$value->status_name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order_date">Status Change Date:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" id="statusDate" name="statusDate" value="" >

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order_date">Status History:</label>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-8 table-responsive status_table">
                                    <table class="table table-bordered table-striped" id="status_table">
                                        <thead class="bg-info">
                                        <th class="text-info">Status ID</th>
                                        <th class="text-info">Changed Time</th>
                                        </thead>
                                        <tbody id="status_body">
                                        @foreach($status_log as $key=> $value)
                                            <tr>
                                                <td>{{$value->status_id}}</td>
                                                <td>{{$value->status_time}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="button" name="btn-Update" id="btn-Status" class="btn btn-primary form-control">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

