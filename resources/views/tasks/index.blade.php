@extends('layouts.app')
@push('user_scripts')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.3/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.3/css/dx.light.css">

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <!-- DevExtreme library -->
    <script src="https://cdn3.devexpress.com/jslib/20.1.3/js/dx.web.debug.js"></script>
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-12">
                <div class="card">
                    <div class="card-header">Tarefas</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div id="gridTasks"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            var usersPluckStore = new DevExpress.data.CustomStore({
                key: 'id',
                loadMode: 'raw',
                load: function () {
                    return $.getJSON("/api/users/pluck")
                        .fail(function () {
                            throw "Data loading error"
                        });
                },
                byKey: function (key) {
                    var d = new $.Deferred();
                    $.get("/api/users/pluck?id=" + key)
                        .done(function (dataItem) {
                            d.resolve(dataItem);
                        });
                    return d.promise();
                }
            })

            var tasksStore = new DevExpress.data.CustomStore({
                key: 'id',
                load: function () {
                    return sendRequest(`/api/tasks`)
                },
                insert: function (values) {
                    return sendRequest("/api/tasks", "POST", values);
                },
                update: function (key, values) {
                    var d = new $.Deferred();
                    $.ajax({
                        method: "PUT",
                        url: `/api/tasks/${key}`,
                        data: values,
                        cache: false,
                        xhrFields: {withCredentials: true}
                    })
                        .done(function (dataItem) {
                            d.resolve(dataItem);
                        });
                    return d.promise();
                },
                remove: function (key) {
                    var d = new $.Deferred();
                    $.ajax({
                        method: "DELETE",
                        url: `/api/tasks/${key}`,
                        cache: false,
                        xhrFields: {withCredentials: true}
                    })
                        .done(function (dataItem) {
                            d.resolve(dataItem);
                        });
                    return d.promise();
                }
            })

            $.ajaxSetup({
                headers: {
                    'Accept': 'application/json'
                }
            });
            $("#gridTasks").dxDataGrid({
                dataSource: tasksStore,
                keyExpr: "id",
                showBorders: true,
                paging: {
                    enabled: false
                },
                editing: {
                    mode: "form",
                    form: {
                        colCount: 2,
                        items: [{
                            dataField: "user_id",
                            caption: "Usuário",
                            validationRules: [{type: 'required'}],
                            width: 125,
                            lookup: {
                                dataSource: usersPluckStore,
                                displayExpr: "name",
                                valueExpr: "id"
                            },
                            formItem: {
                                colSpan: 2,
                            }
                        }, 'title','status', 'description', 'started_at', 'finished_at' ]
                    },
                    allowUpdating: true,
                    allowDeleting: true,
                    allowAdding: true
                },
                columns: [
                    {
                        dataField: "user_id",
                        caption: "Usuário",
                        validationRules: [{type: 'required'}],
                        width: 125,
                        lookup: {
                            dataSource: usersPluckStore,
                            displayExpr: "name",
                            valueExpr: "id"
                        },
                        formItem: {
                            colSpan: 2,
                        }
                    },
                    {
                        dataField: "title",
                        caption: "Tarefa",
                        validationRules: [{type: 'required'}]
                    },
                    {
                        dataField: "status",
                        validationRules: [{type: 'required'}],
                        lookup: {
                            dataSource: {
                                load: function () {
                                    return sendRequest('/api/tasks/statuses')
                                },
                                byKey: function (key) {
                                    var d = new $.Deferred();
                                    $.get("/api/tasks/statuses?id=" + key)
                                        .done(function (dataItem) {
                                            d.resolve(dataItem);
                                        });
                                    return d.promise();
                                }
                            },
                            displayExpr: "name",
                            valueExpr: "id"
                        },
                        width: 125
                    },
                    {
                        dataField: "description",
                        validationRules: [{type: 'required'}],
                        formItem: {
                            colSpan: 2,
                            editorType: "dxHtmlEditor",
                            editorOptions: {
                                height: 190,
                                toolbar: {
                                    items: ["bold", "italic", "underline"]
                                }
                            }
                        },

                        caption: "Descrição",
                        visible: false,
                        width: 130,
                        height: 'auto'
                    },
                    {
                        dataField: 'started_at',
                        dataType: "datetime",
                        caption: "Inicio"
                    },
                    {
                        dataField: 'finished_at',
                        dataType: "datetime",
                        caption: "Fim"
                    },
                    {
                        dataField: 'total_elapsed_time',
                        // dataType: "datetime",
                        caption: "Total tarefa"
                    }
                ],
            });


            $("#clear").dxButton({
                text: "Clear",
                onClick: function () {
                    $("#events ul").empty();
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
