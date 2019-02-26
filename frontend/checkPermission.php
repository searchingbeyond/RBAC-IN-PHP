<?php
    //此处为了测试，不进行检查
    // 真正使用的时候，应该使用下面一个php代码
    $user_id="1";
    $user_name="abc";
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","root");
    $stmt = $pdo->prepare("select count(*) from user where user_id=:user_id and user_name=:user_name;");
    $stmt->execute(array(":user_id"=>$user_id,":user_name"=>$user_name));
    $flag = $stmt->fetch(PDO::FETCH_ASSOC);
 
    !$flag && die("无此用户");
 
    $stmt = $pdo->prepare("select * from user
                left join user_role on user.user_id = user_role.user_id
                right join role_access on user_role.role_id = role_access.role_id
                left join access on access.access_id = role_access.access_id
                where user.user_id = :user_id
                ");
    $stmt->execute(array(":user_id"=>$user_id));
 
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    //urls用来保存当前用户所拥有的权限url
    //可以保存在缓存中，提高效率
    $urls = array();
    foreach( $data as $v ){
        $urls[] = json_decode($v['urls'],true)[0];
    }
 
    //判断对当前url是否有权限
    if ( ! in_array( $_SERVER['SCRIPT_NAME'], $urls ) ){
        include "error.html";
        exit;
    }
 ?>
 
 
 <?php
 /*
 
    真正使用的时候，应该使用这个
 
    //因为重点不是验证登录，所以这里简单的验证登录
    if( $_SESSION['user_id'] && $_SESSION['user_name'] ){
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","root");
        $stmt = $pdo->prepare("select count(*) from user where user_id=:user_id and user_name=:user_name;");
        $stmt->execute(array(":user_id"=>$_SESSION['user_id'],":user_name"=>$_SESSION['user_name']));
        $flag = $stmt->fetch(PDO::FETCH_ASSOC);
        !$flag && die("无此用户");
        $stmt = $pdo->prepare("select * from user
                    left join user_role on user.user_id = user_role.user_id
                    right join role_access on user_role.role_id = role_access.role_id
                    left join access on access.access_id = role_access.access_id
                    where user.user_id = :user_id
                    ");
        $stmt->execute(array("user_id"=>$_SESSION['user_id']));
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $urls = array();
        foreach( $data as $v ){
            $urls[] = json_decode($v['urls'],true)[0];
        }
        if ( ! in_array( $_SERVER['SCRIPT_NAME'], $urls ) ){
            include "error.html";
            exit;
        }
 
    }
 
*/
 ?>