<?php

namespace App\Controllers\Builder;
use App\Controllers\BaseController;

class Beranda extends BaseController
{
    function __construct()
    {
        
    }
    public function index()
    {
        return view('builder/home');
    }

    public function generate_db()
    {
        
        $post = $this->request->getPost();
        $custom = [
            'DSN'      => '',
            'hostname' => $post['host_name'],
            'username' => $post['user_name'],
            'password' => $post['user_password'],
            'database' => '',
            'DBDriver' => 'MySQLi',
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => $post['port_db'],
        ];
        // $db->transBegin();
        $file = file_get_contents(WRITEPATH."builder/database/db_ci4.sql");
        //CREATE DATABASE
        $db = \Config\Database::forge();
        $db->createDatabase($post['db_name']);
        $custom['database'] = $post['db_name'];
        $db = \Config\Database::connect($custom);
        //CREATE TABLE MENU
        $db->query("
        CREATE TABLE `ms_menu` (
            `menu_id` int(11) NOT NULL AUTO_INCREMENT,
            `menu_code` char(10) NOT NULL,
            `menu_name` varchar(140) NOT NULL,
            `menu_url` longtext,
            `menu_parent_id` int(11) DEFAULT NULL,
            `menu_status` varchar(5) DEFAULT NULL,
            `menu_icon` varchar(30) DEFAULT NULL,
            `slug` varchar(140) DEFAULT NULL,
            PRIMARY KEY (`menu_id`) USING BTREE
          ) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
        ");
        
        $db->query("
        
        INSERT INTO `ms_menu` VALUES 
        (9, '01', 'BERANDA', 'builder/beranda', 0, 't', 'fa fa-dashboard', NULL),
        (10, '02', 'DOKUMENTASI', '#', 0, 't', 'fa fa-book', ''),
        (11, '02.01', 'FORM BASIC', 'documentation', 10, 't', '', ''),
        (13, '02.03', 'HTML HELPER', 'documentation/html_helper', 10, 't', '', ''),
         (14, '02.04', 'DATATA TABLE', 'documentation/datatable_helper', 10, 't', '', ''),
         (24, '02.02', 'FORM ADVANCE', 'documentation/form_advance', 10, 't', NULL, NULL),
        (25, '03', 'BUILDER CRUD', 'builder/builderform', 0, 't', 'fas fa-sync', NULL);
        ");

        //CREATE TABLE BUILDER
        $db->query("
        CREATE TABLE `table_builded` (
            `id_task` int(255) NOT NULL AUTO_INCREMENT,
            `table_name` varchar(255) NOT NULL,
            `controller` smallint(255) DEFAULT NULL,
            `model` smallint(255) DEFAULT NULL,
            `views` smallint(255) DEFAULT NULL,
            `user_created` int(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id_task`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");
        //CREATE TABLE USER DEVELOPER
        $db->query("
        CREATE TABLE `user_developer` (
            `user_id` int(11) NOT NULL AUTO_INCREMENT,
            `username_developer` varchar(255) NOT NULL,
            `password_developer` varchar(255) NOT NULL,
            `password_encrypted` varchar(255) NOT NULL,
            PRIMARY KEY (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        //CHANGE SETTING DB
        helper('filesystem');
        $file = file_get_contents(WRITEPATH."builder/database/Database.php");
        $file = str_replace("%HOSTNAME%", $post['host_name'],   $file);
        $file = str_replace("%USERNAME%", $post['user_name'],   $file);
        $file = str_replace("%USERPASSWORD%", $post['user_password'],   $file);
        $file = str_replace("%DBNAME%", $post['db_name'],   $file);
        $file = str_replace("%PORTDB%", $post['port_db'],   $file);
        write_file(APPPATH.'Config/Database.php',$file,"wa+");
        
        //developer
        $builder = $db->table('user_developer');
        $data = [
            "username_developer" => $post['user_dev'],
            "password_developer" => $post['password_dev'],
            "password_encrypted" => md5($post['password_dev']),
        ];
        $builder->insert($data);
        $session = session();
        $session->set($data);
        return redirect()->to('/builder/builderform');
    }
}
