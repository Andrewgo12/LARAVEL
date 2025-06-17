<?php
/* Smarty version 3.1.40, created on 2021-11-21 20:21:37
  from '/var/www/html/application/views/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_619af0a15fc957_71224008',
  'has_nocache_code' => false,
  'file_dependency' =>
  array (
    '42ea37467697179fd8c8cc54d0cbd5298a220730' =>
    array (
      0 => '/var/www/html/application/views/index.tpl',
      1 => 1637543725,
      2 => 'file',
    ),
  ),
  'includes' =>
  array (
  ),
),false)) {
function content_619af0a15fc957_71224008 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
$_smarty_tpl->compiled->nocache_hash = '304232335619af0a15f3f81_57125120';
?>


<?php
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1922141414619af0a15fae55_75785327', 'title');
?>

<?php
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2104149873619af0a15fc183_04914146', 'body');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'layouts/main.tpl');
}
/* {block 'title'} */
class Block_1922141414619af0a15fae55_75785327 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'title' =>
  array (
    0 => 'Block_1922141414619af0a15fae55_75785327',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    This is a new feature
<?php
}
}
/* {/block 'title'} */
/* {block 'body'} */
class Block_2104149873619af0a15fc183_04914146 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' =>
  array (
    0 => 'Block_2104149873619af0a15fc183_04914146',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <main class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5">Sticky footer with fixed navbar</h1>
            <p class="lead">Pin a footer to the bottom of the viewport in desktop browsers with this custom HTML and
                CSS. A fixed navbar has been added with <code class="small">padding-top: 60px;</code> on the <code
                    class="small">main &gt; .container</code>.</p>
            <p>Back to <a href="/docs/5.1/examples/sticky-footer/">the default sticky footer</a> minus the navbar.</p>
        </div>
    </main>
<?php
}
}
/* {/block 'body'} */
}
