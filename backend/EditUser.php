<?php
    if( isset($_GET['user_id']) ){
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","root");
 
        //查询用户信息
        $stmt = $pdo->prepare("select * from user where user_id = :user_id");
        $stmt->execute(array("user_id" => $_GET['user_id']));
        $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
        //print_r($user_info);
 
        //查询用户的角色
        $stmt = $pdo->prepare("select * from user_role where user_id = :user_id");
        $stmt->execute(array(":user_id" => $_GET['user_id']));
        //这里只留下role_id
        $user_role_info = array_column( $stmt->fetchAll(PDO::FETCH_ASSOC),"role_id" );
        //print_r($user_role_info);
 
        //查询所有角色
        $stmt = $pdo->prepare("select * from role");
        $stmt->execute();
        $role_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($role_arr);
    }
 
    //用来判断复选框已选中
    function checked($i,$arr){
        if( in_array($i,$arr) ){
            echo "checked";
        }
    }
 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <div>
    <form action="" method='post'>
        <table>
            <caption>用户信息</caption>
            <tr>
                <td>用户名:</td>
                <td>
                    <input type="hidden" name="user_id" value="<?php echo $user_info['user_id'] ?>">
                    <?php echo $user_info['user_name']; ?>
                </td>
                 
            </tr>
            <tr>
                <td>角色:</td>
                <?php if( count($role_arr) ):?>
                    <?php foreach($role_arr as $role): ?>
                        <td>
                            <div>
            <input type="checkbox" <?php checked($role['role_id'],$user_role_info);?> name="role[]" value="<?php echo $role['role_id'];?>"><?php echo $role['role_name'] ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
            <tr>
                <td colspan="5">
                    <input type="submit" name="editUser">
                    <input type="button" value="返回主页" onclick="location.href='./index.php'">
                    <input type="button" value="返回用户列表" onclick="location.href='./UserList.php'">
                </td>
            </tr>
        </table>
    </form>  
    </div>
</body>
</html>
 
 
<?php
    if( isset($_POST['editUser'])){
        //获取传递的role复选框数组，当将全部角色都撤销时，传递的post数据中将不再有role，所以将其设为空数组。
        $edit_role = isset($_POST['role'])?$_POST['role']:array();
        $user_id = $_POST['user_id'];
 
        //增加的角色：
        $add_role = array_diff($edit_role,$user_role_info);
 
        //删除的角色
        $sub_role = array_diff($user_role_info,$edit_role);
 
        //执行删除角色
        $stmt = $pdo->prepare("delete from user_role where user_id = :user_id and role_id = :role_id");
        foreach($sub_role as $role_id){    
            $stmt->execute(array(":user_id"=>$user_id,":role_id"=>$role_id)); 
        }
 
        //执行增加角色
        $stmt = $pdo->prepare("insert into user_role (user_id,role_id) values(:user_id,:role_id)");
        foreach($add_role as $role_id){
            $stmt->execute(array(":user_id"=>$user_id,":role_id"=>$role_id));
        }
 
        // echo "<script>location.href='editUser.php?user_id=$user_id</script>";
        echo "<script>location.replace(location.href);</script>";
    }
 ?>