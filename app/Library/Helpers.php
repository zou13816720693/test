<?php

if (!function_exists('assets_path')) {

    /**
     * 后台资源
     * @param string $path
     * @return string
     */
    function assets_path($path)
    {
        return asset('assets'.$path, config('admin.secure'));
    }
}

if (!function_exists('admin_toastr')) {

    /**
     * Flash a toastr message bag to session.
     *
     * @param string $message
     * @param string $type
     * @param array  $options
     *
     * @return string
     */
    function admin_toastr($message = '', $type = 'success', $options = [])
    {
        $toastr = new \Illuminate\Support\MessageBag(get_defined_vars());

        \Illuminate\Support\Facades\Session::flash('toastr', $toastr);
    }
}