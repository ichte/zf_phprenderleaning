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
    ->attach($map)    // this will be consulted first, and is the fastest lookup
    ->attach($stack)  // filesystem-based lookup
    ->attach(new Resolver\RelativeFallbackResolver($map)) // allow short template names
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
echo $renderer->render('hello1',$data);
echo $renderer->render('hello2',$data);  
echo $renderer->render('hello3',$data);  
echo $renderer->render('folderother/hello4',$data);  

