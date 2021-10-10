<?php
    class CategoryModel extends Model
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_detail($category_id)
        {
            $sql = "SELECT * FROM categories WHERE id = '" . $category_id . "'";
            $result = mysqli_query($this->connection, $sql);
            
            $row = mysqli_fetch_object($result);
            $categories = array();
            if(is_null($row->parent)){
                $categories[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'parent' => $row->parent,
                );
            } else {
                $categories[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'parent' => $row->parent,
                    'parent_name' => $this->get_parent_name($row->parent),
                );
            }
            return $categories;
        }

        public function get_parent_name($category_id)
        {
            $sql = "SELECT * FROM categories WHERE id = '" . $category_id . "'";
            $result = mysqli_query($this->connection, $sql);
            $row = mysqli_fetch_object($result);
            return $row->name;
        }

        public function edit_detail($category_id)
        {
            $sql = "SELECT * FROM categories WHERE id = '" . $category_id . "'";
            $result = mysqli_query($this->connection, $sql);
            $row = mysqli_fetch_object($result);
            return $row;
        }

        public function add()
        {
            $name = $_POST["name"];
            $parent = $_POST["parent"];
            if($parent == "Null") {
                $sql = "INSERT INTO categories(name) VALUES ('".$name."')";
            } else {
                $sql = "INSERT INTO categories(name,parent) VALUES ('".$name."', '".$parent."')";
            }

            mysqli_query($this->connection, $sql);
        }

        public function get_all()
        {
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($this->connection, $sql);

            $data = array();
            while ($row = mysqli_fetch_object($result)) {
                array_push($data, $row);
            }
            return $data;
        }

        public function count()
        {
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($this->connection, $sql);

            $count = mysqli_num_rows($result);
                
            return $count;
        }

        public function get_per_page()
        { 
            $sql = "SELECT * FROM categories WHERE parent is NULL";
            $result = mysqli_query($this->connection, $sql);

            $categories = array();

            while ($row = mysqli_fetch_object($result)) {
                $categories[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'parent' => $row->parent,
                    'subs' => $this->sub_categories($row->id),
                );
            }

            return $categories;
        }

        public function sub_categories($id)
        {	
            
            $sql = "SELECT * FROM categories WHERE parent=$id";
            $result = mysqli_query($this->connection, $sql);
            
            $categories = array();
            
            while ($row = mysqli_fetch_object($result)) {
                $categories[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'parent' => $row->parent,
                    'subs' => $this->sub_categories($row->id),
                );
            }
            return $categories;
        }

        public function delete($category_id)
        {
            $sql = "DELETE FROM categories WHERE parent = $category_id";
            mysqli_query($this->connection, $sql);
            $sql = "DELETE FROM categories WHERE id = $category_id";
            mysqli_query($this->connection, $sql);
        }

        public function edit($category_id)
        {
            $name = $_POST["name"];
            $parent = $_POST["parent"];
            if($parent == "Null" || $parent == "NULL") {
                $sql = "UPDATE categories SET name = '".$name."', parent = NULL WHERE id = '" . $category_id . "'";
                mysqli_query($this->connection, $sql);
            } else {
                if ($category_id != $parent) {
                    if ($this->check_children($category_id, $parent) == true) {
                        $sql = "UPDATE categories SET name = '".$name."', parent = '".$parent."' WHERE id = '" . $category_id . "'";
                        mysqli_query($this->connection, $sql);
                    }
                }
            }
        }

        public function check_children($p, $child)
        {
            $sql = "SELECT * FROM categories WHERE id =  '" . $child . "'";
            $result = mysqli_query($this->connection, $sql);
            $c = mysqli_fetch_object($result);

            if($c->parent == "Null" || $c->parent == "NULL" || is_null($c->parent) || $c->parent == NULL) {
                echo "true";
                return true;
            } else if($c->parent == $p) {
                echo "false";
                return false;
            } else if($c->parent != $p) {
                return $this->check_children($p, $c->parent);
            } else {
                echo "true";
                return true;
            }
            
        }

        public function copy($category_id)
        {
            $sql = "SELECT * FROM categories WHERE id = '" . $category_id . "'";
            $result = mysqli_query($this->connection, $sql);

            $category = mysqli_fetch_object($result);

            if(is_null($category->parent)) {
                $sql = "INSERT INTO categories(name) VALUES ('".$category->name."')";
            } else {
                $sql = "INSERT INTO categories(name,parent) VALUES ('".$category->name."', '".$category->parent."')";
            }
            mysqli_query($this->connection, $sql);
        }

        public function search()
        {
            $keyword = $_POST["keyword"];
            $sql = "SELECT * FROM categories WHERE name LIKE '%.$keyword.%'";
            $result = mysqli_query($this->connection, $sql);

            $categories = array();
            while ($row = mysqli_fetch_object($result)) {
                $categories[] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'parent' => $row->parent,
                );
            }

            return $categories;
        }
    }
