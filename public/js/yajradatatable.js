function sentenceCase(text) {
    if (!text) return '';
    text = text.toString().toLowerCase();
    return text.charAt(0).toUpperCase() + text.slice(1);
}
function itd_makeDataTable(e = "", n = "", t = []) {
    const o = new DataTable(e, {
        serverSide: true,
        processing: true,
        fixedHeader: {
            header: true, 
        },
        preDrawCallback: function (settings) {
            $("#custom-loader").show();
        },
        drawCallback: function (settings) {
            $("#custom-loader").hide();
        },
        columnDefs: [
            { orderable: !1, className: "select-checkbox", targets: 0 },
        ],
        lengthMenu: [
            [10, 25, 50, 100, 200, 300, -1],
            [10, 25, 50, 100, 200, 300, "All"],
        ],
        columns: [
            {
                data: "id",
                orderable: !1,
                searchable: !1,
                render: function (e, n, t) {
                    return (
                        '<label class="itd-checkbox mb-4"><input id="select_row" type="checkbox" class="mt-1" name="selected[]" value="' +
                        e +
                        '"><span class="checkmark"></span></label>'
                    );
                },
            },
            ...t.map(col => {
                if (col.data === 'action') return col;
                if (!col.render) {
                    col.render = function (data, type) {
                        if (type === 'display' && typeof data === 'string') {
                            return data;
                        }
                        return data;
                    };
                }
                return col;
            }),
        ],
        dom: '<lBf<t>i<"m-0"p>>',
        buttons: [
            {
                text: "<i class='fa fa-trash'></i>",
                className: "delete_items_from_dt",
            },
            {
                extend: "print",
                className: "datatable_print_button",
                text: "<i class='fa fa-print'></i>",
                exportOptions: { columns: ":visible" },
            },
            {
                extend: "copy",
                className: "datatable_copy_button",
                text: "<i class='fa fa-copy'></i>",
                exportOptions: { columns: ":visible" },
            },
            {
                extend: "pdf",
                className: "datatable_pdf_button",
                text: "<i class='fa fa-file-pdf'></i>",
                exportOptions: { columns: ":visible" },
            },
            {
                extend: "excel",
                className: "datatable_excel_button",
                text: "<i class='fa fa-file-excel'></i>",
                exportOptions: { columns: ":visible" },
            },
            {
                extend: "colvis",
                className: "datatable_colvis_button",
                text: "<i class='fa fa-eye-slash'></i>",
                columnText: function (e, n, t) {
                    return 0 == n ? "Select" : t;
                },
            },
        ],
        footerCallback: function( tfoot, data, start, end, display ) {
            var api = this.api();
            
            
            const sumCols = [];
            api.columns().every(function () {
                const column = this;
                const columnData = column.data();
                let isNumeric = true;
        
                for (let i = 0; i < columnData.length; i++) {
                    if (typeof columnData[i] !== 'number') {
                        isNumeric = false;
                        break;
                    }
                }
                
                if (isNumeric) {
                    sumCols.push(column.index());
                }
            });
            
            sumCols.shift(); 
            sumCols.forEach(sumCol => {
                $( api.column(sumCol).footer() ).html(
                    api.column(sumCol).data().reduce( function ( a, b ) {
                        return a + b;
                    }, 0 ) 
                ); 
            });
        }


    });

    return (
        $(document).on("change", "#dtb_all_selector", function () {
            var isChecked = $(this).is(":checked");
            $("input[name='selected[]']").prop("checked", isChecked);

            if (isChecked) {
                o.rows().select();
            } else {
                o.rows().deselect();
            }
        }),
        $(document).on("change", "#warehouse_id", function () {
            const e = $(this).val();
            o.ajax.reload(function (n) {
                n.warehouse_id = e;
            });
        }),
        $(e).on("click", "input[name='selected[]']", function () {
            if ($(this).prop("checked")) {
                o.row($(this).closest("tr")).data();
            }
        }),
        $(".delete_items_from_dt").on("click", function () {
            const e = o
                .rows({ selected: true })
                .data()
                .toArray()
                .map((e) => e.id);
            $.ajax({
                method: "DELETE",
                url: n + "/delete-records",
                data: { ids: e },
                success: function (n) {
                    o.ajax.reload();
                    toastr.success(`${e.length} items deleted.`);
                },
                error: function (e, n, t) {
                    console.error(t);
                },
            });
        }),
        o
    );
}