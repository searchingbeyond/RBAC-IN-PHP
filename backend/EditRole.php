<?php
    if( isset($_GET['role_id']) ){
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","root");
 
        //查询角色信息
        $stmt = $pdo->prepare("select * from role where role_id = :role_id");
        $stmt->execute(array("role_id" => $_GET['role_id']));
        $role_info = $stmt->fetch(PDO::FETCH_ASSOC);
        //print_r($user_info);
 
        //查询当前角色拥有的权限
        $stmt = $pdo->prepare("select * from role_access where role_id = :role_id");
        $stmt->execute(array(":role_id" => $_GET['role_id']));
        //这里只留下access_id
        $role_access_info = array_column( $stmt->fetchAll(PDO::FETCH_ASSOC),"access_id" );
        //print_r($user_role_info);
 
        //查询所有的资源信息
        $stmt = $pdo->prepare("select * from access");
        $stmt->execute();
        $access_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>编辑角色</title>
</head>
<body>
    <div style="width:400px;margin:0 auto">
    <form action="" method='post'>
        <table>
            <caption>角色信息</caption>
            <tr>
                <td>角色名:</td>
                <td>
                    <input type="hidden" name="role_id" value="<?php echo $role_info['role_id'] ?>">
                    <?php echo $role_info['role_name']; ?>
                </td>
                 
            </tr>
            <tr>
                <td>权限:</td>
                <?php if( count($access_arr) ):?>
                        <td>
                    <?php foreach($access_arr as $access): ?>
                            <div>
            <input type="checkbox" <?php checked($access['access_id'],$role_access_info);?> name="access[]" value="<?php echo $access['access_id']?>"><?php echo $access['title'] ?>
                            </div>
                    <?php endforeach; ?>
                        </td>
                <?php endif; ?>
            </tr>
            <tr>
                <td colspan="5">
                    <input type="submit" name="editRole">
                    <input type="button" value="返回主页" onclick="location.href='./index.php'">
                    <input type="button" value="返回角色列表" onclick="location.href='./RoleList.php'">
                </td>
            </tr>
        </table>
    </form>  
    </div>
</body>
</html>
 
 
<?php
    if( isset($_POST['editRole'])){
        //获取传递的role复选框数组，当将全部角色都撤销时，传递的post数据中将不再有role，所以将其设为空数组。
        $access = isset($_POST['access'])?$_POST['access']:array();
        $role_id = $_POST['role_id'];
 
        //增加的角色：
        $add_access = array_diff($access,$role_access_info);
 
        //删除的角色
        $sub_access = array_diff($role_access_info,$access);
 
        //执行删除角色
        $stmt = $pdo->prepare("delete from role_access where role_id = :role_id and access_id = :access_id");
        foreach($sub_access as $access_id){    
            $stmt->execute(array(":role_id"=>$role_id,":access_id"=>$access_id ));
        }
 
        //执行增加角色
        $stmt = $pdo->prepare("insert into role_access (role_id,access_id) values(:role_id,:access_id)");
        foreach($add_access as $access_id){
            $stmt->execute(array(":role_id"=>$role_id,":access_id"=>$access_id ));
        }
 
        echo "<script>location.replace(location.href);</script>";
    }
 ?> 