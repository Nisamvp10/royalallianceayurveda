<?php
use App\Models\CategoryModel;
if (!function_exists('updateImage')) {
    function updateImage($url)
    {
       $url =  str_replace(base_url(), '', $url);
       
        if (file_exists($url)) {
            unlink($url);
        }
    }
}
if (!function_exists('validImg')) {
    function validImg($img)
    {
        if (empty($img)) {
            return base_url('uploads/default.png');
        }

        // If full URL, extract only path
        if (filter_var($img, FILTER_VALIDATE_URL)) {
            $parsed = parse_url($img);
            $relativePath = ltrim($parsed['path'], '/');
        } else {
            $relativePath = ltrim($img, '/');
        }

        $filePath = FCPATH . $relativePath;

        if (file_exists($filePath)) {
            return base_url($relativePath);
        }

        return base_url('uploads/default.png');
    }
}
if(!function_exists('slugify')) {
        function slugify($string) {
            
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }
}

if(!function_exists('deleteImg')) {
    function deleteImg($img) {
        
        if(!empty($img))
        {
            $oldPath = FCPATH . $img;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
    }
}

if(!function_exists('rgbToHex')) {
    function rgbToHex($rgb) {
    if (preg_match('/rgb\s*\(\s*(\d+),\s*(\d+),\s*(\d+)\s*\)/', $rgb, $matches)) {
            return sprintf("#%02x%02x%02x", $matches[1], $matches[2], $matches[3]);
        }
        return '#000000';
    }
}

if(!function_exists('navigationMenu')) {
    function navigationMenu() {
        $db = \Config\Database::connect();
        $builder = $db->table('categories as c')
            ->select('c.category,s.slug,s.title')
            ->join('services as s','c.id = s.category_id','left')
            ->where('c.is_active',1)->get();
            $result = $builder->getResultArray();
            $menu = [];
            foreach($result as $row) {
                $categoryName = $row['category'];
                if(!isset($menu[$categoryName])) {
                    $menu[$categoryName] = [
                        'category' => $categoryName,
                        'submenu' => []
                    ];
                }
                if(!empty($row['slug']) && !empty($row['title'])) {
                    $menu[$categoryName]['submenu'] [] = [
                        'title' => $row['title'],
                        'slug' => $row['slug']
                    ];
                }

            }
           
            return $menu;

    }
}

if(!function_exists('services')) {
    function services() {
        $categoryModel = new CategoryModel();
        $services = $categoryModel->where(['is_active'=>1,'parent_id' =>0])->findAll();
        return $services;
    }
}

//user account login or not
if(!function_exists('isUserLoggedIn')) {
    function isUserLoggedIn() {
        return session()->get('user') ? true : false;
    }
}