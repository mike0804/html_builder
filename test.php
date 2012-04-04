<?

include 'html_element.php';

$div = new html_element('div');
$div->add_class('borderless');
$div->add_class('seemless');
$div->add_class('microphone');
$div->remove_class('microphone');
$div->attr('id'     , 'main');
$div->attr('fdata'  , '{"1":"77"}');
$div->attr('title'  , 'astitle');
$div->attr('title'  , '');
$div->attr('title'  , 'astitle');
$div->remove_attr('title'  , '');
$div->css ('display', 'none');
$div->css ('border' , '1px solid black');
$div->css ('height' , '80px');
$div->css ('height' , '');

$a = new html_element('a');
$a->attr('href', 'http://www.google.com');
$a->text('google');

$div->append('I always like to use ');
$div->append($a);
$div->append(', how about you?');

echo '1. ';
if ($div->build() != '<div id="main" fdata="{&quot;1&quot;:&quot;77&quot;}" class="borderless seemless" style="display:none;border:1px solid black;">I always like to use <a href="http://www.google.com">google</a>, how about you?</div>') {
    echo "Red\n";
} else {
    echo "Green\n";
}

$b =& $div->children(1);
$b->add_class('link');

echo '2. ';
if ($div->build() != '<div id="main" fdata="{&quot;1&quot;:&quot;77&quot;}" class="borderless seemless" style="display:none;border:1px solid black;">I always like to use <a href="http://www.google.com" class="link">google</a>, how about you?</div>') {
    echo "Red\n";
} else {
    echo "Green\n";
}

echo '3. ';
if ((string) $b   != '<a href="http://www.google.com" class="link">google</a>') {
    echo "Red\n";
} else {
    echo "Green\n";
}

echo '4. ';
$b->text('google</a>');
if ((string) $b   != '<a href="http://www.google.com" class="link">google&lt;/a&gt;</a>') {
    echo "Red\n";
} else {
    echo "Green\n";
}

?>
