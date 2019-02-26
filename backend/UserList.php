<?php
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=rbac","root","root");
    $stmt = $pdo->prepare("select * from user");
    $stmt->execute();
    $user_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户管理</title>
</head>
<body>
    <div>
        <table>
            <caption>用户列表</caption>
            <tr>
                <td>用户名</td>
                <td>状态</td>
                <td>操作</td>
            </tr>
            <?php if( count($user_arr) ): ?>
                <?php foreach($user_arr as $user): ?>
                     <tr>
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $user['user_status']?"正常":"禁用"; ?></td>
                        <td>
                            <a href="EditUser.php?user_id=<?php echo $user['user_id']?>">角色设置</a>
                        </td>
                     </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>