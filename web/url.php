<?php 


try{
 
    $uri    = parse_url($_SERVER['PATH_INFO']);
    $query  = $uri['path'];
    $pathInfo = array_values(array_filter(explode('/',$query)));
    $className = ucfirst(isset($pathInfo[0])?$pathInfo[0]:'');
    $methodName = isset($pathInfo[1])?$pathInfo[1]:'';
    if(!$className||!$methodName){
        throw new \Exception();
    }
    $methodNameArr = explode('_',$methodName);
    $method = '';
    foreach ($methodNameArr as $key=>$value){
        if($key!=0){
            $method.=ucfirst($value);
        }else{
            $method=$value;
        }
    }

    $params = $_GET;
    $fileDir = $className.'.php';
    include_once $fileDir;
    $classObj = new $className();
    $data = $classObj->$method($params);
    exit($data);
}catch (\Exception $e){
    Header("HTTP/1.0 404 Not Found");
}




 ?>