@extends('layouts.app')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <div class="inner-content">
        <div class="outter-wp">
            @if(!empty($alert))
                @include('elements/notify', ['response' => $alert])
            @endif
            <div class="sub-heard-part">
                <ol class="breadcrumb m-b-0">
                    <li><a href="/home">Головна</a></li>
                    <li class="active">Абоненти</li>
                </ol>
            </div>
            <div class="graph-visual tables-main">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="inner-tittle two">Абоненти ({{ $total_count }})</h3>
                    </div>

                    <div class="col-md-6 text-right">
                        <button data-toggle="modal" data-target="#add_abonent" type="button" class="btn btn-primary"><i class="fa fa-user"></i><span> Додати абонента</span></button>
                    </div>
                </div>

                <div class="graph">
                    <div class="tables">

                        <table width="100%" class="table table-hover data-table">
                            <thead>
                            <tr>
                                <th>О/р</th>
                                <th>ПІБ</th>
                                <th>Баланс, грн</th>
                                <th>Адреса</th>
                                <th>Телефон</th>
                            </tr>
                            </thead>
                            <tbody class="linkRow">

                            </tbody>
                        </table>
                    </div>

                </div>


            </div>
            <!--//graph-visual-->
        </div>
        <!--//outer-wp-->
    </div>

    <script type="text/javascript">
        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/abonents",
                    data: function (d) {
                        d.archived = $('#archived').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {data: 'personal_account', name: 'personal_account'},
                    {data: 'name', name: 'name'},
                    {data: 'balance', name: 'balance'},
                    {data: 'address', name: 'address'},
                    {data: 'phone', name: 'phone'},
                ],
                "language": {
                    "lengthMenu": "Показати _MENU_ абонентів на сторінку",
                    "zeroRecords": "Нічого не знайдено",
                    "info": "Сторінка _PAGE_ з _PAGES_",
                    "infoEmpty": "Не знайдено",
                    "search": "Пошук",
                    "previous": "Пошук",
                    "infoFiltered": "знайдено серед _MAX_ абонентів)",
                    "paginate": {
                        "previous": "Попередня",
                        "next":     "Наступна"
                    }
                },
                "pageLength": 50
            });

            $('#archived').change(function(){
                table.draw();
            });

        });
    </script>
    <div class="modal fade modalCustom" id="add_abonent" tabindex="-1" role="dialog" aria-labelledby="add_abonent" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form class="modal-content" action="javascript:void(null);" onsubmit="abonent.add()" method="post">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 class="modal-title">Додавання абонента</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">ПІБ</label>
                                        <div class="col-sm-8">
                                            <input required
                                                   name="name"
                                                   type="text"
                                                   class="form-control"
                                                   placeholder="ПІБ"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Адреса</label>
                                        <div class="col-sm-8">
                                            <input required
                                                   name="address"
                                                   type="text"
                                                   class="form-control"
                                                   placeholder="Адреса"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Телефон</label>
                                        <div class="col-sm-8">
                                            <input required
                                                   name="phone"
                                                   type="tel"
                                                   class="form-control"
                                                   placeholder="Телефон"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Кількість прописаних людей</label>
                                        <div class="col-sm-8">
                                            <input required
                                                   name="peoples"
                                                   type="number"
                                                   class="form-control"
                                                   placeholder="Кількість прописаних людей"
                                                   value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Особовий рахунок</label>
                                        <div class="col-sm-8">
                                            <input required
                                                   name="personal_account"
                                                   type="number"
                                                   class="form-control"
                                                   placeholder="Особовий рахунок"
                                                   value="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Додати</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Скасувати</button>
                </div>
            </form>
        </div>
    </div>

@endsection
