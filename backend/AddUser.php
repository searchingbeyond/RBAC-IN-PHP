<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>创建用户</title>
</head>
<body>
    <div>
        <table>
            <form action="" method="post">
            <caption>用户信息</caption>
            <tr>
                <td>用户ID:</td>
                <td><input type="text" name="user_id" style="width:400px"></td>
            </tr>
            <tr>
                <td>用户名:</td>
                <td><input type="text" name="user_name" style="width:400px"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="adduser" value="添加">
                    <input type="button" value="返回首页" onclick="location.href='./index.php'">
                </td>
            </tr>
            </form>
        </table>
    </div>
</body>
</html>
 
<?php
    if( isset($_POST['adduser']) ){
        $user_id = $_POST['user_id'];
        $user_name = $_POST['user_name'];
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","root");
        $stmt = $pdo->prepare("insert into user (user_id,user_name) values ( :user_id, :user_name )");
        $stmt->execute(array(":user_id"=>$user_id,":user_name"=>$user_name));
    }
?>