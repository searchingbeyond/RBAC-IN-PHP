<?php
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","root");
    $stmt = $pdo->prepare("select * from role");
    $stmt->execute();
    $role_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>角色管理</title>
</head>
<body>
    <div>
        <table>
            <caption>角色列表</caption>
            <tr>
                <td>角色名</td>
                <td>操作</td>
            </tr>
            <?php if( count($role_arr) ): ?>
                <?php foreach($role_arr as $role): ?>
                     <tr>
                        <td><?php echo $role['role_name']; ?></td>
                        <td>
                            <a href="EditRole.php?role_id=<?php echo $role['role_id']?>">权限设置</a>
                        </td>
                     </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>