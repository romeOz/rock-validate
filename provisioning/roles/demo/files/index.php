<?php
use rock\validate\Validate;

include_once(__DIR__ . '/vendor/autoload.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Demo Rock validate</title>
    <link href="/assets/css/main.min.css" rel="stylesheet">
    <script src="/assets/js/main.min.js"></script>
</head>
<body>
<div class="container main" role="main">
    <div class="demo-header">
        <h1 class="demo-title">Demo Rock validate</h1>
        <p class="lead demo-description">The example.</p>
    </div>
    <div class="demo-main">
        <div class="demo-post-title">
            Base
        </div>
        <pre><code class="php"><!--
-->use rock\validate\Validate;

// Validation length from 10 to 20 characters inclusive + regexp pattern
$v = Validate::length(10, 20, true)->regex('/^[a-z]+$/i');
$v->validate('O’Reilly'); // output: false

$v->getErrors();<!--
--></code></pre>
<?php
// Validation length from 10 to 20 characters inclusive + regexp pattern
$v = Validate::length(10, 20, true)->regex('/^[a-z]+$/i');
$v->validate('O’Reilly'); // output: false
?>
        Errors:
        <pre><code class="html"><?=var_export($v->getErrors())?></code></pre>

        First error:
        <pre><code class="html"><?=var_export($v->getFirstError())?></code></pre>


        <div class="demo-post-title">
            Custom Placeholders
        </div>
        <pre><code class="php"><!--
-->use rock\validate\Validate;
$v = Validate::length(10, 20, true)
    ->regex('/^[a-z]+$/i')
    ->placeholders(['name' => 'username']);
$v->validate('O’Reilly'); // output: false

$v->getErrors();<!--
--></code></pre>
<?php
$v = Validate::length(10, 20, true)
    ->regex('/^[a-z]+$/i')
    ->placeholders(['name' => 'username']);
$v->validate('O’Reilly'); // output: false
?>
        Errors:
        <pre><code class="html"><?=var_export($v->getErrors())?></code></pre>
    </div>
</div>
<div class="demo-footer">
    <p>Demo template built on <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://github.com/romeOz">@romeo</a>.</p>
    <p>
        <a href="#">Back to top</a>
    </p>
</div>
</body>
</html>