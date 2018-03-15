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
               var book_price = $("#item_name option:selected").val().split('book_id')[0];
               var book_id = $("#item_name option:selected").val().split('book_id')[1];

               total = total + parseInt(book_price);

               var rem_id = book_name.replace(/ \//g,"\n");


               $("#no_info").remove();
               var html = '';
               html+='<tr>';
               html+='<td>'+book_name;
               html+='<input type="hidden" name="hddBookName[]" value="'+book_name+'">';
               html+='<input type="hidden" name="hddBookID[]" value="'+book_id+'">';
               html+='</td>';
               html+='<td>'+book_price;
               html+='<input type="hidden" name="hddBookPrice[]" value="'+book_price+'">';
               html+='</td>';
               html+='<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>';
               html+='</tr>';

               $('#item_table > tbody').append(html);

               $('#lblTotal').text(total);

               $('#hddTotal').val(total);


               count++;

               // var lastClass = $('div').attr('class').split(' ').pop();
           });

           $(document).on('click', '.remove', function(){
               var no_html ='';

               var rem_val =parseInt($(this).parent().siblings(":nth-child(2)").text().split('book_id')[0]);
               total-=rem_val;

               $(this).closest('tr').remove();
               $('#lblTotal').text(total);
               $('#hddTotal').val(total);

               count--;

               if(count === 0)
               {
                    no_html+='<tr>';
                    no_html+='<td id="no_info" class="text-center" colspan="3">No Info Yet</td>';

                    $('#item_table > tbody').append(no_html);
                    $('#lblTotal').text(total);
                    $('#hddTotal').val(total);

               }
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
            <input type="hidden" id="hddTotal" name="hddTotal" value="0">


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
                                        <option value="{{$value->price.'book_id'.$value->book_id}}">{{$value->book_name}}</option>
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
                    <div class="col-md-8 table-responsive">
                        <table class="table table-bordered table-striped" id="item_table">
                            <thead class="bg-info">
                               <th class="text-info">Book Name</th>
                               <th class="text-info">Book Price</th>
                               <th class="text-info">Action</th>
                            </thead>
                            <tbody>
                                <tr id="no_info">
                                    <td colspan="3" class="text-center">No Info Yet</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="footer">
                                    <td class="text-right">Total</td>
                                    <td colspan="2" class="text-right" id="lblTotal">
                                        0
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
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