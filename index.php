<?php
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;


include "vendor/autoload.php"; 

//Tạo và cấu hình resolver
$resolver = new Resolver\AggregateResolver();
$map = new Resolver\TemplateMapResolver([
    'hello1'      => __DIR__ . '/view/hello1.phtml',
    'hello2' => __DIR__ . '/view/index/hello2.phtml',
]);

$stack = new Resolver\TemplatePathStack([
    'script_paths' => [
        __DIR__ . '/viewfolder',
        __DIR__ . '/viewother',
    ],
]);


// Gom lại các Resolver
$resolver
    ->attach($map)    // PhpRenderer tìm các file từ map này trước, tìm thấy sẽ không tìm cái khác
    ->attach($stack)  // Cho phép tìm theo cấu trúc thư mục, bắt đầu với các thư mục khai báo tại script_paths
    ->attach(new Resolver\RelativeFallbackResolver($map)) //Cài đặt để tìm tên ngắn
    ->attach(new Resolver\RelativeFallbackResolver($stack));
	
	 
$renderer = new PhpRenderer();
$renderer->setResolver($resolver);

//Mẫu mảng dữ liệu chuyển đến HTML Scritp
$data = [
	'name' => 'NGUYEN VAN A',
	'age'  => '20',
	'class' => '40A'
];

//Render HTML
echo $renderer->render('hello1',$data);  //Tìm thấy hello1 từ $map, sẽ render script này
echo $renderer->render('hello2',$data);  //Tìm thấy hello2 từ $map, sẽ render script này
echo $renderer->render('hello3',$data);  //Không tìm thấy hello3 từ map, bắt đầu quét trong thư mục từ script_paths của $stack, thấy hello3.phtml trong viewfolder, sẽ nạp và render file này.
echo $renderer->render('folderother/hello4',$data);  //Tương tự hello3

