<?php
    //echo 'Path:'. $_SERVER['PHP_SELF'];
    //echo 'Languages: ' . $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    //echo 'Languages: ' . $_SERVER['SERVER_NAME'];
    sitemap_file();
    
    function sitemap_file(){
        $filename = 'sitemap.xml';
        if(!file_exists($filename)){
           $content = '<?xml version="1.0" encoding="utf-8"?>';
           $content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
           
           $content .= '<!--This is the parent sitemap linking to additional sitemaps for products, collections and pages as shown below. The sitemap can not be edited manually, but is kept up to date in real time.-->';
           $content .= '<sitemap><loc>https://'. $_SERVER['SERVER_NAME'] . '/sitemap_products.xml</loc></sitemap>';
           $content .= '<sitemap><loc>https://'. $_SERVER['SERVER_NAME'] . '/sitemap_pages.xml</loc></sitemap>';
           $content .= '<sitemap><loc>https://'. $_SERVER['SERVER_NAME'] . '/sitemap_collections.xml</loc></sitemap>';
           
           $content .= '</sitemapindex>';
           file_put_contents($filename, urldecode($content));
        }
    }

    $products = array();
    $product = array();
    $product['location'] = 'https://' .$_SERVER['SERVER_NAME'] . '/collections/boulangeries';
    $product['lastmod'] = date(DateTime::ISO8601);
    $product['changefreq'] = 'daily';
    $product['image_location'] = 'https://' .$_SERVER['SERVER_NAME'] . '/collections/boulangeries/pain.jpg';
    $product['image_title'] = 'Pain Traditionnel';
    array_push($products, $product);

    $filename = 'sitemap_collections.xml';
    sitemap_products($filename, $products);
    
    function sitemap_products($filename, $products){
        
        if(!file_exists($filename)){
           
           $content = '<?xml version="1.0" encoding="utf-8"?>';
           $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
           
           $content .= '<url>';
           $content .= '<loc>https://' . $_SERVER['SERVER_NAME'] .'</loc>';
           $content .= '<changefreq>daily</changefreq>';
           $content .= '</url>';
           
           $content .= '<!--This is the parent sitemap linking to additional sitemaps for products, collections and pages as shown below. The sitemap can not be edited manually, but is kept up to date in real time.-->';
           foreach($products as $product){  
               $content .= '<url>';
               $content .= '<loc>' . $product['location'] .'</loc>';
               $content .= '<lastmod>' . $product['lastmod'] .'</lastmod>';
               $content .= '<changefreq>' . $product['changefreq'] . '</changefreq>';
               $content .= '<image:image>';
               $content .= '<image:loc>' . $product['image_location'] .'</image:loc>';
               $content .= '<image:title>' . $product['image_title'] .'</image:title>';
               $content .= '</image:image>';
               $content .= '</url>';
           }
           $content .= '</urlset>';
           file_put_contents($filename, urldecode($content));
        }else {
           unlink($filename);
           sitemap_products($filename, $products);         
        }
    }
                      
?>