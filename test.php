<?

include 'html_element.php';

$div = new html_element('div');
$div->add_class('borderless');
$div->add_class('seemless');
$div->add_class('microphone');
$div->remove_class('microphone');
$div->set('id'     , 'main');
$div->set('fdata'  , '{"1":"77"}');
$div->set('title'  , 'astitle');
$div->remove('title'  , 'astitle');
$div->css('display', 'none');
$div->css('border' , '1px solid black');
$div->css('height' , '80px');
$div->css('height' , '');

$a = new html_element('a');
$a->set('href', 'http://www.google.com');
$a->text('google');

$div->append('I always like to use ');
$div->append($a);
$div->append(', how about you?');

if ($div->build() != '<div id="main" fdata="{&quot;1&quot;:&quot;77&quot;}" class="borderless seemless" style="display:none;border:1px solid black;">I always like to use <a href="http://www.google.com">google</a>, how about you?</div>') {
    echo "Red\n";
} else {
    echo "Green\n";
}


?>
