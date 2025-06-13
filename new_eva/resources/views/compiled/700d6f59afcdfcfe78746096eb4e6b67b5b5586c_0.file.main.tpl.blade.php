<?php
/* Smarty version 3.1.40, created on 2021-11-21 20:15:27
  from '/var/www/html/application/views/layouts/main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_619aef2f98d5e6_72214470',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '700d6f59afcdfcfe78746096eb4e6b67b5b5586c' => 
    array (
      0 => '/var/www/html/application/views/layouts/main.tpl',
      1 => 1637543710,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_619aef2f98d5e6_72214470 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1112071647619aef2f98a0f1_49769451', 'title');
?>
</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ base_url('assets/css/bootstrap.min.css') }}
" rel="stylesheet">
    <link href="{{ base_url('assets/css/custom.css') }}
" rel="stylesheet">
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_748535204619aef2f98b7e8_30505406', 'css');
?>


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body class="d-flex flex-column h-100">

    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Fixed navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Begin page content -->
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_541618236619aef2f98c316_80937510', 'body');
?>



    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">Place sticky footer content here.</span>
        </div>
    </footer>


    {{ '<script' }}
 src="{{ base_url('assets/js/bootstrap.js') }}
">{{ '</script' }}
>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1667418341619aef2f98ce45_55482690', 'scripts');
?>


</body>

</html><?php }
/* {block 'title'} */
class Block_1112071647619aef2f98a0f1_49769451 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' => 
  array (
    0 => 'Block_1112071647619aef2f98a0f1_49769451',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Default<?php
}
}
/* {/block 'title'} */
/* {block 'css'} */
class Block_748535204619aef2f98b7e8_30505406 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'css' => 
  array (
    0 => 'Block_748535204619aef2f98b7e8_30505406',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'css'} */
/* {block 'body'} */
class Block_541618236619aef2f98c316_80937510 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_541618236619aef2f98c316_80937510',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'body'} */
/* {block 'scripts'} */
class Block_1667418341619aef2f98ce45_55482690 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'scripts' => 
  array (
    0 => 'Block_1667418341619aef2f98ce45_55482690',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'scripts'} */
}
