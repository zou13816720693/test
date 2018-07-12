<?php

namespace App\Library\Admin;


use App\Library\Admin\Consts\StyleTypeConst;
use App\Library\Admin\Widgets\Forms;
use App\Library\Admin\Widgets\NavBar;
use Auth;
use App\Bls\Auth\Model\Menu;

class Admin
{
    public $navbar;

    public $js = [StyleTypeConst::FILE => [], StyleTypeConst::CODE => []];

    public $css = [StyleTypeConst::FILE => [], StyleTypeConst::CODE => []];

    /**
     * Get navbar object.
     *
     * @return \app\Library\Admin\Widgets\NavBar
     */
    public function getNavbar()
    {
        if (is_null($this->navbar)) {
            $this->navbar = new Navbar();
        }
        return $this->navbar;
    }


    /**
     * Get current login user.
     *
     * @return mixed
     */
    public function user()
    {
        return Auth::guard('admin')->user();
    }

    /**
     * Left sider-bar menu.
     *
     * @return array
     */
    public function menu()
    {

        return (new Menu())->toTree();
    }

    public function getRouteName()
    {
        return \Request::route()->getName();
    }

    public function form(\Closure $callback, $open)
    {
        return (new Forms())->form($callback, $open);
    }

    public function setCss($type, $data)
    {
        switch($type) {
            case StyleTypeConst::FILE:

                $this->css[StyleTypeConst::FILE][] = '<link rel="stylesheet" href="' . assets_path($data) . '">';
                break;

            case StyleTypeConst::CODE:

                $this->css[StyleTypeConst::CODE][] = $data;
                break;

            default:
                break;
        }
    }

    public function setJs($type, $data)
    {
        switch($type) {
            case StyleTypeConst::FILE:

                $this->js[StyleTypeConst::FILE][] = '<script src="' . assets_path($data) . '"></script>';
                break;

            case StyleTypeConst::CODE:

                $this->js[StyleTypeConst::CODE][] = $data;
                break;

            default:
                break;
        }
    }

    public function getCss()
    {
        $file = array_unique($this->css[StyleTypeConst::FILE]);
        $css = '';
        $code = '';
        foreach ($file as $v) {
            $css .= $v;
        }

        foreach($this->css[StyleTypeConst::CODE] as $v) {
            $code .= $v;
        }

        $css .= <<<EOT
        <style>
            $code
        </style>

EOT;
        return $css;
    }

    public function getJs()
    {
        $file = array_unique($this->js[StyleTypeConst::FILE]);
        $js = '';
        $code = '';
        foreach ($file as $v) {
            $js .= $v;
        }

        foreach($this->js[StyleTypeConst::CODE] as $v) {
            $code .= $v;
        }

        $js .= <<<EOT

        <script>
            $(function () {
                $code
            });
        </script>
EOT;
        return $js;
    }

}