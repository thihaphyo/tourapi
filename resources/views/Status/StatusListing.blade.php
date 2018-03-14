@extends('master.master')

@section('title', 'Status Listing')

@section('content')
    <script>
        $('document').ready(function () {



            var oTable = $('#DataTable').DataTable({


                processing: true,
                serverSide: true,
                ajax: {
                    url: 'GetStatus',
                    data: function (d) {
                        d.daterange = "null";
                    }
                },
                columns: [
                    {data: 'idx', name: 'idx'},
                    {data: 'status_name', name: 'status_name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#search-form').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });



            $('#btn-add').on('click',function (e) {

                window.location="/StatusEntry";
            });




        });

    </script>
    <div class="container content-body">
        <!--For Heading-->
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 heading-blue">Status Listing</h4>
            </div>
        </div>
        <form method="POST"  id="search-form">
            {{csrf_field()}}




            <div class="row datatable-content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-4 pull-right">
                            <button type="button" class="btn btn-primary pull-right" id="btn-add">Add New Status</button>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="control-label">
                        Status List
                    </label>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="DataTable">
                        <thead>
                        <th>Status ID</th>
                        <th>Status Name</th>
                        <th>Edit</th>
                        </thead>
                    </table>
                </div>
            </div>

        </form>
    </div>
@endsection