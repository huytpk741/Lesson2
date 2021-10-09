<?php

class CategoryController extends Controller
{
    // public function all($page = 1)
    // {
    //     $categories = $this->load_model("CategoryModel")->get_per_page($page);
    //     $total = $this->load_model("CategoryModel")->count();

    //     if(($page - 1) == 0) {
    //         $prev = ceil($total/10);
    //     } else {
    //         $prev = $page - 1;
    //     }

    //     if(($page+1) > ceil($total/10)){ 
    //         $next = 1;
    //     } else {
    //         $next = $page + 1;
    //     }

    //     require_once VIEW . "layout/header.php";
    //     require_once VIEW . 'categories/all.php';
    //     require_once VIEW . "layout/footer.php";
    // }

    public function all()
    {
        $categories = $this->load_model("CategoryModel")->get_per_page();
        $total = $this->load_model("CategoryModel")->count();
        $all_categories = $this->load_model("CategoryModel")->get_all();

        require_once VIEW . "layout/header.php";
        require_once VIEW . 'categories/all.php';
        require_once VIEW . "layout/footer.php";
    }

    public function viewsub($subs, $sub_padding)
    {
        $new_sub_padding = $sub_padding + 30;
        $html = '';
        foreach ($subs as $sub) {
            $html  .= '<tr class="sub-category">';
            $html .= '<td>' . $sub["id"] . '</td>';
            $html .=    '<td style="padding-left: '. $sub_padding .'px;">└ ' . $sub["name"] . ' </td>';
            $html .=    '<td>';
            $html .=        '<a data-id="' . $sub["id"] . ' " class="detailBtn" data-toggle="modal" data-target="#detailModal" href="javascript:void(0);">';
            $html .=            '<i class="fa fa-info-circle" aria-hidden="true"></i>';
            $html .=        '</a>';
            $html .=        '<a data-id="' . $sub["id"] . ' " data-toggle="modal" data-target="#editModal" class="editBtn" href="javascript:void(0);">';
            $html .=            '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
            $html .=        '</a>';
            $html .=        '<a data-id="' . $sub["id"] . '" data-toggle="modal" data-target="#confirmModal" class="copyBtn" href="javascript:void(0);">';
            $html .=            '<i class="fa fa-files-o" aria-hidden="true"></i>';
            $html .=        '</a>';
            $html .=        '<a data-id="' . $sub["id"] . '" data-toggle="modal" data-target="#confirmModal" class="deleteBtn" href="javascript:void(0);">';
            $html .=            '<i class="fa trash-o fa-trash-o" aria-hidden="true"></i>';
            $html .=        '</a>';
            $html .=    '</td>';
            $html .= '</tr>';
            if (!empty($sub['subs'])) {
                $html .= $this->viewsub($sub['subs'], $new_sub_padding);
            }
        }
        return $html;
    }

    public function detail($id)
    {
        $category = $this->load_model("CategoryModel")->get_detail($id);
        echo json_encode($category);
    }

    public function edit_detail($id)
    {
        $category = $this->load_model("CategoryModel")->edit_detail($id);
        echo json_encode($category);
    }

    public function add()
    {
        if ($_POST) {
            $response = $this->load_model("CategoryModel")->add();
            header('location: ' . URL . 'category/all');
        }
    }

    public function delete($id)
    {
        $response = $this->load_model("CategoryModel")->delete($id);
        header('location: ' . URL . 'category/all');
    }

    public function edit($id)
    {
        if ($_POST) {
            $response = $this->load_model("CategoryModel")->edit($id);
            header('location: ' . URL . 'category/all');
        }
    }

    public function copy($id)
    {
        $response = $this->load_model("CategoryModel")->copy($id);
        header('location: ' . URL . 'category/all');
    }

    public function search()
    {
        if ($_POST) {
            $categories = $this->load_model("CategoryModel")->search();
        } else {
            $categories = $this->load_model("CategoryModel")->get_all();
        }
        require_once VIEW . "layout/header.php";
        require_once VIEW . 'categories/search.php';
        require_once VIEW . "layout/footer.php";
    }

    public function checkchildren($parent, $child)
    {
        $response = $this->load_model("CategoryModel")->check_children($parent, $child);
        
        
    }
}
