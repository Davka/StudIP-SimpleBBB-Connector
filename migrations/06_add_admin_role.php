<?php

final class AddAdminRole extends Migration
{
    public function __construct($verbose = false)
    {
        parent::__construct($verbose);

        require_once __DIR__ . '/../SimpleBBBConnector.class.php';
    }

    public function up()
    {
        $role = new Role();
        $role->setRolename(SimpleBBBConnector::BBB_ADMIN_ROLE);
        $role_id = RolePersistence::saveRole($role);

        $query = "INSERT IGNORE INTO `roles_studipperms` (`roleid`, `permname`)
                      VALUES (:role_id, :status)";
        DBManager::get()->execute($query, [
            ':role_id' => $role_id,
            ':status'  => 'root',
        ]);
        RolePersistence::expireRolesCache();

        $users = User::findBySQL("perms = 'root'");
        foreach($users as $user) {
            RolePersistence::expireUserCache($user->id);
        }
    }

    public function down()
    {
        $roles = RolePersistence::getAllRoles();
        foreach ($roles as $role) {
            if ($role->getRoleName() !== SimpleBBBConnector::BBB_ADMIN_ROLE) {
                continue;
            }

            RolePersistence::deleteRole($role);
        }
        RolePersistence::expireRolesCache();

        $users = User::findBySQL("perms = 'root'");
        foreach($users as $user) {
            RolePersistence::expireUserCache($user->id);
        }
    }
}
