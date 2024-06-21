(function($) {
    $.fn.eDataTable = function (options) {
        var settings = $.extend({
            searchable: true,
            sortable: true,
            buttons: [],
            post: function() {},
            get: function() {},
            noDataMessage: 'Tidak ada data...',
            columns: [], // Array of column definitions
            data: [] // Array of data objects
        }, options);

        return this.each(function() {
            var $table = $(this);
            var search = componentGroupSearch();

            var $noDataMessage = $('<div>')
                .addClass('p-4 bg-slate-200 text-sm text-slate-100 text-center')
                .attr('id', 'noDataMessage')
                .text(settings.noDataMessage)
                .hide();
            $table.after($noDataMessage);

            $table.before(search);

            // Function to render table rows
            function renderRows(data) {
                var $tbody = $table.find('tbody').empty();
                if (data.length === 0) {
                    checkNoDataMessage();
                    return;
                }
                $.each(data, function(index, rowData) {
                    var $tr = $('<tr>');
                    
                    // Add checkbox column
                    var $checkbox = $('<td class="p-4">').append($('<input type="checkbox" class="w-4 h-4 rowCheckbox text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">'));
                    $tr.append($checkbox);

                    // Add data columns
                    $.each(settings.columns, function(colIndex, colDef) {
                        var cellData = rowData[colDef.data];
                        var $td = $('<td class="px-6 py-4">').text(cellData);
                        $tr.append($td);
                    });
                    $tbody.append($tr);
                });
                checkNoDataMessage();
            }
            
            if (settings.sortable) {
                $table.find('th').each(function(columnIndex) {
                    $(this).on('click', function() {
                        var rows = $table.find('tbody tr').toArray().sort(comparator(columnIndex));
                        this.asc = !this.asc;
                        if (!this.asc) rows = rows.reverse();
                        $table.find('tbody').empty().append(rows);
                    });
                });
            }

            if (settings.searchable) {
                var $input = $('#search_data').on('keyup', function() {
                    var query = $(this).val().toLowerCase();
                    $table.find('tbody tr').each(function() {
                        var rowText = $(this).text().toLowerCase();
                        $(this).toggle(rowText.indexOf(query) > -1);
                        checkNoDataMessage()
                    });
                });
            }

            $('#checkAll').on('change', function() {
                var isChecked = $(this).is(':checked');
                $table.find('.rowCheckbox').prop('checked', isChecked);
            });

            function comparator(index) {
                return function(rowA, rowB) {
                    var cellA = $(rowA).children('td').eq(index).text();
                    var cellB = $(rowB).children('td').eq(index).text();
                    return $.isNumeric(cellA) && $.isNumeric(cellB)
                        ? cellA - cellB
                        : cellA.localeCompare(cellB);
                };
            }

            function componentGroupSearch() {
                var groupSearch = createComponent({
                    element: 'div', 
                    id: 'group_search',
                    className: 'flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900'
                });

                if(settings.buttons.length > 0) {
                    var buttons = componentButton(settings.buttons);
                    $(groupSearch).append(buttons);
                }    

                var warpperSearch = createComponent({
                    element: 'div', 
                    attributes: {
                        id: 'wrapper_search',
                    },
                    className: 'relative',
                    children: `<div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>`
                });

                var input = createComponent({
                    element: 'input',
                    className: 'block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                    attributes: {
                        type: 'text',
                        placeholder: 'Search disini...',
                        id: 'search_data'
                    }
                });

                warpperSearch.append(input);
                groupSearch.append(warpperSearch);

                return groupSearch;
            }

            function componentButton(buttons = []) {
                var groupButtons = createComponent({
                    element: 'div',
                    className: 'flex items-center gap-4',
                    attributes: {
                        id: 'group_buttons'
                    }
                });

                if(buttons.length > 0) {
                    $(groupButtons).html('');
                    $.each(buttons, function(index, value) {
                        var button = createComponent({
                            element: 'button',
                            className: 'px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
                            attributes: {
                                id: 'button_'+index+value.title,
                                type: 'button',
                                title: value.title,
                                ...value.attributes
                            }
                        });
                        
                        if(value?.methods != undefined) {
                            $.each(Object.entries(value.methods), function(index, val) {
                                $(button).on(val[0], val[1]);
                            })
                        }
                        
                        $(button).text(value.title);

                        $(groupButtons).append(button);
                    })
                }

                return groupButtons;
            }

            function createComponent(options) {
                var defaultOptions = {
                    element: 'div',
                    className: '',
                    children: null,
                    attributes: {
                        id: 'group_search'
                    }
                };

                var mergeObject = {...defaultOptions, ...options};
                defaultOptions = mergeObject;

                var element = document.createElement(defaultOptions.element);
                $(element).addClass(defaultOptions.className).attr(defaultOptions.attributes);
                if(defaultOptions.children) {
                    $(element).append(defaultOptions.children);
                }

                return element;
            }

            function checkNoDataMessage() {
                var visibleRows = $table.find('tbody tr:visible').length;
                if (visibleRows === 0) {
                    $noDataMessage.show();
                } else {
                    $noDataMessage.hide();
                }
            }

            // Initial check for no data message
            checkNoDataMessage();
            renderRows(settings.data);
        })
    }
})(jQuery);