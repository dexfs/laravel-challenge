@extends('layouts.app')
@push('user_scripts')
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.3/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.3/css/dx.light.css">
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.3/js/dx.all.js"></script>
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Usuários</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div id="gridUsers"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'Accept' : 'application/json'
                }
            })
            var usersStore = new DevExpress.data.CustomStore({
                key: 'id',
                load: function () {
                    return sendRequest(`/api/users`)
                },
                remove: function (key) {
                    return sendRequest(`/api/users/${key}`, "DELETE");
                }
            })
            var dataGrid = $("#gridUsers").dxDataGrid({
                dataSource: usersStore,
                repaintChangesOnly: true,
                showBorders: true,
                editing: {
                    refreshMode: "reshape",
                    mode: "form",
                    form: {
                        colCount: 2,
                        items: ['name', 'email' ]
                    },

                    allowAdding: false,
                    allowUpdating: true,
                    allowDeleting: true
                },
                scrolling: {
                    mode: "virtual"
                },
                pager: {
                    showPageSizeSelector: true,
                    allowedPageSizes: [5, 10, 20],
                    showInfo: true
                },
                columns: [{
                    dataField: "id",
                    caption: "ID",
                    visible: false
                }, {
                    dataField: "name",
                    caption: "Name",
                    validationRules: [{type: 'required'}],
                }, {
                    dataField: "email",
                    dataType: "email",
                    validationRules: [{type: 'required'}, {type:'email'}],
                }
                ],
            }).dxDataGrid("instance");

            $("#refresh-mode").dxSelectBox({
                items: ["full", "reshape", "repaint"],
                value: "reshape",
                onValueChanged: function(e) {
                    dataGrid.option("editing.refreshMode", e.value);
                }
            });

            function sendRequest(url, method, data) {
                var d = $.Deferred();
                method = method || 'GET';
                logRequest(method, url, data);

                $.ajax(url, {
                    method: method || "GET",
                    data: data,
                    cache: false,
                    xhrFields: {withCredentials: true}
                }).done(function (result) {
                    d.resolve(method === "GET" ? result.data : result);
                }).fail(function (xhr) {
                    d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
                });

                return d.promise();
            }

            function logRequest(method, url, data) {
                var args = Object.keys(data || {}).map(function (key) {
                    return key + "=" + data[key];
                }).join(" ");

                var logList = $("#requests ul"),
                    time = DevExpress.localization.formatDate(new Date(), "HH:mm:ss"),
                    newItem = $("<li>").text([time, method, url.slice(URL.length), args].join(" "));

                logList.prepend(newItem);
            }
        });
    </script>
@endsection
