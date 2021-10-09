        <footer>

        </footer>

        <script type="text/javascript" src="<?= JS; ?>script.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script>
            // Detail
            $(".detailBtn").click(function() {
                var id = $(this).data("id");
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: {
                        id: id
                    },
                    url: "<?= URL; ?>category/detail/" + id,
                    success: function(category) {
                        $("#detailModal #category-name").val(category[0].name);
                        if (category[0].parent == null) {
                            $("#detailModal #category-parent").val("Null");
                        } else {
                            $("#detailModal #category-parent").val(category[0].parent_name);
                        }

                    }
                });
            });
            //Edit
            $(".editBtn").click(function() {
                var id = $(this).data("id");
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: {
                        id: id
                    },
                    url: "<?= URL; ?>category/edit_detail/" + id,
                    success: function(category) {
                        $("#editModal #category-name").val(category.name);
                        $("#editModal form").attr("action", "<?= URL; ?>category/edit/" + id);
                        var select = $("#editModal select");
                        var categories = <?= json_encode($all_categories); ?>;
                        var opt = document.createElement('option');

                        select.empty();
                        opt.value = "Null";
                        opt.innerHTML = "NULL";
                        select.append(opt);

                        for (const cate of categories) {
                            if (parseInt(cate.id) != parseInt(id)) {
                                // if (check_children(id, cate.id) == true) {
                                    // var opt = document.createElement('option');
                                    // opt.value = cate.id;
                                    // opt.innerHTML = cate.name;
                                    // select.append(opt);
                                // }
                                $.ajax({
                                    type: 'GET',
                                    dataType: 'text',
                                    data: {
                                        id: id,
                                        cateid : cate.id
                                    },
                                    url: "<?= URL; ?>category/checkchildren/" + id + "/" + cate.id,
                                    success: function(data) {
                                        //  console.log(data);
                                        if (data == "true") {
                                            var opt = document.createElement('option');
                                            opt.value = cate.id;
                                            opt.innerHTML = cate.name;
                                            select.append(opt);
                                        }
                                    }
                                });
                            }
                        }

                        if (category.parent == null) {
                            $("#editModal select").val("Null").change();
                        } else {
                            $("#editModal select").val(category.parent).change();
                        }

                    }
                });
            });

            //Delete
            $(".deleteBtn").click(function() {
                var id = $(this).data("id");
                $("#confirmModal #accept").attr("href", "<?= URL; ?>category/delete/" + id);

            });

            //Copy
            $(".copyBtn").click(function() {
                var id = $(this).data("id");
                $("#confirmModal #accept").attr("href", "<?= URL; ?>category/copy/" + id);
            });

            //Search
            $('#search-box').on('keyup', function() {
                var value = $(this).val();
                var patt = new RegExp(value, "i");

                $('#category-table').find('tr').each(function() {
                    var $table = $(this);

                    if (!($table.find('td').val("Category Name").text().search(patt) >= 0)) {
                        $table.not('.t_head').hide();
                    }
                    if (($table.find('td').text().search(patt) >= 0)) {
                        $(this).show();
                    }

                });

            });

            //pagination
            var rowsShown = 10;
            var rowsTotal = $('#category-table tbody tr').length;
            $(document).ready(function() {
                $('#category-table').after('<nav aria-label="Page navigation example" ><ul id="pagination" class="pagination justify-content-center"></ul></nav>');

                var numPages = rowsTotal / rowsShown;

                // $('#pagination').append('<li class="page-item"><button onclick="prevButtons()" class="page-link prev-btn">Previous</button></li>');

                for (i = 0; i < numPages; i++) {
                    var pageNum = i + 1;
                    $('#pagination').append('<li class="page-item"><a class="page-link" href="#" rel="' + i + '">' + pageNum + '</a> </li>');
                }

                // $('#pagination').append('<li class="page-item"><button onclick="nextButtons()" class="page-link next-btn">Next</button></li>');

                $('#category-table tbody tr').hide();
                $('#category-table tbody tr').slice(0, rowsShown).show();
                $('#pagination a:first').addClass('active');
                $('#pagination a').bind('click', function() {

                    $('#pagination a').removeClass('active');
                    $(this).addClass('active');
                    var currPage = $(this).attr('rel');
                    var startItem = currPage * rowsShown;
                    var endItem = startItem + rowsShown;
                    $('#category-table tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
                    css('display', 'table-row').animate({
                        opacity: 1
                    }, 300);
                });


            });

            function prevButtons() {
                $('#pagination a').removeClass('active');
                var currPage = $('#pagination .active').attr('rel');
                var startItem = (currPage - 1) * rowsShown;
                var endItem = startItem + rowsShown;

                if (endItem < 10) {
                    $('#pagination .next-btn').attr("disabled", "disabled");
                }

                $('#category-table tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
                css('display', 'table-row').animate({
                    opacity: 1
                }, 300);
            }

            function nextButtons() {
                $('#pagination a').removeClass('active');
                var currPage = $('#pagination a.active').attr('rel');
                var startItem = (currPage + 1) * rowsShown;
                var endItem = startItem + rowsShown;

                if (endItem > rowsTotal) {
                    $('#pagination .next-btn').attr("disabled", "disabled");
                }

                $('#category-table tbody tr').css('opacity', '0.0').hide().slice(startItem, endItem).
                css('display', 'table-row').animate({
                    opacity: 1
                }, 300);
            }
        </script>
        </body>

        </html>