<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\Auth\Model\AdministratorModel;
use App\Consts\Admin\Role\RoleSlugConst;
use App\Admin\Bls\Auth\Model\RoleModel;
use App\Admin\Bls\Auth\MenuBls;
use App\Admin\Bls\Auth\Model\MenuModel;
use App\Consts\Common\WhetherConst;
use App\Admin\Bls\Auth\Requests\MenuRequest;
use App\Admin\Bls\Auth\Model\PermissionModel;

class AdminAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建管理员
        AdministratorModel::truncate();
        $administrator = AdministratorModel::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name'     => '超级管理员',
        ]);

        //创建角色
        RoleModel::truncate();
        $role =  RoleModel::create([
            'name' => '超级管理员',
            'slug' => RoleSlugConst::ROLE_SUPER,
        ]);

        //给超级管理员关联角色
        $administrator->roles()->sync($role);

        //清空权限
        PermissionModel::truncate();


        //创建后台菜单以及权限
        $menuRequest = new MenuRequest();
        MenuModel::truncate();

        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '首页',
            'icon' => 'fa-bar-chart',
            'route' => 'm.home',
            'slug' => '',
            'permissions' => WhetherConst::NO
        ]);

        MenuBls::storeMenu($menuRequest);
        $this->admin(); //后台管理
        $this->canteen(); //食堂管理
        $this->other(); //其它管理
        $this->system(); //系统管理
        $this->customer(); //用户管理
        $this->report(); //数据报表
    }

    /**
     * 后台管理
     */
    public function admin()
    {
        $menuRequest = new MenuRequest();
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '后台管理',
            'icon' => 'fa-tasks',
            'route' => '',
            'slug' => 'm_auth',
            'permissions' => WhetherConst::YES
        ]);
        $menu = MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '管理员',
            'icon' => 'fa-users',
            'route' => 'm.user.list',
            'slug' => 'm_auth_users',
            'permissions' => WhetherConst::YES
        ]);

        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '角色',
            'icon' => 'fa-user',
            'route' => 'm.role.list',
            'slug' => 'm_auth_role',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '权限',
            'icon' => 'fa-ban',
            'route' => 'm.permissions.list',
            'slug' => 'm_auth_permissions',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '菜单',
            'icon' => 'fa-bars',
            'route' => 'm.menu.list',
            'slug' => 'm_auth_menu',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);
    }


    /**
     *  其他管理
     */
    public function other()
    {
        $menuRequest = new MenuRequest();
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '其它管理',
            'icon' => 'fa-paperclip',
            'route' => '',
            'slug' => 'm_other',
            'permissions' => WhetherConst::YES
        ]);
        $menu = MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '客户反馈',
            'icon' => 'fa-comments-o',
            'route' => 'm.other.feedback.list',
            'slug' => 'm_other_feedback',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

       /* $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '广告',
            'icon' => 'fa-image',
            'route' => 'm.other.advert.list',
            'slug' => 'm_other_advert',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);*/
    }

    /**
     * 系统管理
     */
    public function system()
    {
        $menuRequest = new MenuRequest();
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '系统管理',
            'icon' => 'fa-cogs',
            'route' => '',
            'slug' => 'm_system',
            'permissions' => WhetherConst::YES
        ]);
        $menu = MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '配置管理',
            'icon' => 'fa-cog',
            'route' => 'm.system.config.set',
            'slug' => 'm_system_config',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '分组',
            'icon' => 'fa-tags',
            'route' => 'm.system.tags.list',
            'slug' => 'm_system_tags',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '系统日志',
            'icon' => 'fa-database',
            'route' => 'm.system.log.list',
            'slug' => 'm_system_log',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '数据备份',
            'icon' => 'fa-copy',
            'route' => 'm.system.backup.list',
            'slug' => 'm_system_backup',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

    }

    /**
     * 食堂管理
     */
    public function canteen()
    {
        $menuRequest = new MenuRequest();
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '食堂管理',
            'icon' => 'fa-cutlery',
            'route' => '',
            'slug' => 'm_canteen',
            'permissions' => WhetherConst::YES
        ]);
        $menu = MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '外卖',
            'icon' => 'fa-truck',
            'route' => 'm.canteen.takeout.list',
            'slug' => 'm_canteen_takeout',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '食谱',
            'icon' => 'fa-spoon',
            'route' => 'm.canteen.recipes.list',
            'slug' => 'm_canteen_recipes',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);
    }

    /**
     * 用户管理
     */
    public function customer()
    {
        $menuRequest = new MenuRequest();
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '用户管理',
            'icon' => 'fa-users',
            'route' => '',
            'slug' => 'm_customer',
            'permissions' => WhetherConst::YES
        ]);
        $menu = MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '用户',
            'icon' => 'fa-user-secret',
            'route' => 'm.customer.users.list',
            'slug' => 'm_customer_users',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);


        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '账户流水',
            'icon' => 'fa-money',
            'route' => 'm.customer.flow.list',
            'slug' => 'm_customer_flow',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '用户订单',
            'icon' => 'fa-reorder',
            'route' => 'm.customer.order.list',
            'slug' => 'm_customer_order',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '充值',
            'icon' => 'fa-credit-card',
            'route' => 'm.customer.recharge.list',
            'slug' => 'm_customer_recharge',
            'permissions' => WhetherConst::YES
        ]);
        MenuBls::storeMenu($menuRequest);
    }

    /**
     * 数据报表
     */
    public function report()
    {
        $menuRequest = new MenuRequest();
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '数据报表',
            'icon' => 'fa-database',
            'route' => '',
            'slug' => 'm_report',
            'permissions' => WhetherConst::YES
        ]);
        $menu = MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '就餐预约统计',
            'icon' => 'fa-list-alt',
            'route' => 'm.report.meal',
            'slug' => 'm_report',
            'permissions' => WhetherConst::NO
        ]);
        MenuBls::storeMenu($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '本周外卖统计',
            'icon' => 'fa-list-alt',
            'route' => 'm.report.takeout',
            'slug' => 'm_report',
            'permissions' => WhetherConst::NO
        ]);
        MenuBls::storeMenu($menuRequest);
    }

}
