<section>
    <div class="container">
        <!-- Search box -->
        <div class="search">
            <form name="search-form" method="POST">
                <input name="keyword" id="search-box" class="search-box" type="text" placeholder="&#xF002; Search" style="font-family:Arial, FontAwesome">
            </form>
        </div>

        <!-- Search results and add button -->
        <div class="row results-add-wrapper">
            <div class="search-results col-sm-10">
                <p>Search found <b><?= $total; ?></b> results</p>
            </div>
            <div class="col-sm-2"><a data-toggle="modal" data-target="#addModal" id="addBtn" class="add-button" href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></div>
        </div>

        <!-- Records table -->
        <table class="table" id="category-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($categories as $category) { ?>
                    <tr>
                        <td><?= $category["id"]; ?></td>
                        <td> <?= $category["name"]; ?> </td>
                        <td>
                            <a data-id="<?= $category["id"]; ?>" class="detailBtn" data-toggle="modal" data-target="#detailModal" href="javascript:void(0);">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </a>

                            <a data-id="<?= $category["id"]; ?>" data-toggle="modal" data-target="#editModal" class="editBtn" href="javascript:void(0);">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <a data-id="<?= $category["id"]; ?>" data-toggle="modal" data-target="#confirmModal" class="copyBtn" href="javascript:void(0);">
                                <i class="fa fa-files-o" aria-hidden="true"></i>
                            </a>

                            <a data-id="<?= $category["id"]; ?>" data-toggle="modal" data-target="#confirmModal" class="deleteBtn" href="javascript:void(0);">
                                <i class="fa trash-o fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php if (!empty($category['subs'])) { ?>
                        <?= $this->viewsub($category['subs'], 30); ?>
                    <?php } ?>
                <?php $count++;
                } ?>
            </tbody>
        </table>
    </div>
</section>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Add new category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-form" class="modal-form" action="<?= URL; ?>category/add" method="post">
                    <div class="form-group">
                        <label for="category-name">Category name</label>
                        <input type="text" class="form-control" id="category-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="parent-category">Parent category</label>
                        <select class="form-control" id="parent-category" name="parent">
                            <option>Null</option>
                            <?php foreach ($all_categories as $category) { ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input form="add-form" id="submitAdd" class="btn btn-primary" type="submit" name="submit" value="Submit" />
            </div>
        </div>
    </div>
</div>
<!-- ADD MODAL -->

<!-- DETAIL MODAL -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Category Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-form" action="" method="get">
                    <div class="form-group">
                        <label for="category-name">Category name</label>
                        <input value="" type="text" class="form-control" id="category-name" disabled>
                    </div>
                    <div class="form-group">
                        <label for="parent-category">Parent category</label>
                        <input value="" type="text" class="form-control" id="category-parent" disabled>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- DETAIL MODAL -->

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Edit category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" class="modal-form" action="" method="post">
                    <div class="form-group">
                        <label for="category-name">Category name</label>
                        <input name="name" value="Name" type="text" class="form-control" id="category-name">
                    </div>
                    <div class="form-group">
                        <label for="parent-category">Parent category</label>
                        <select name="parent" class="form-control" id="parent-category">
                            <option>Null</option>
                            
                        </select>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input form="edit-form" id="submitAdd" class="btn btn-primary" type="submit" name="submit" value="Submit" />
            </div>
        </div>
    </div>
</div>
<!-- EDIT MODAL -->

<!-- CONFIRM MODAL -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Comfirm</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <p>Are you sure to do that?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <a href="#" id="accept" type="submit" class="btn btn-danger">Yes</a>
            </div>
        </div>
    </div>
</div>
<!-- CONFIRM MODAL -->