<?
/* creates an html element, like in js */
class html_element
{
	/* vars */
	var $type;
	var $attrs;
	var $self_closers;
    
    var $classes   = array();
    var $styles;
      
    var $children  = array();
    
    var $innerHTML = '';
	
	/* constructor */
	function html_element($type = null, $self_closers = array('input', 'img', 'hr', 'br', 'meta', 'link'))
	{
        if (!is_null($type))
        {
            $this->type = strtolower($type);
            $this->self_closers = $self_closers;
        }
	}
	
	/* get */
	function get($attr)
	{
		return $this->attributes[(string) $attr];
	}
	
	/* set -- array or key, value */
	function set($attr, $value)
	{
		$this->attributes[(string) $attr] = (string) $value;
	}
	
	/* remove an attribute */
	function remove($attr)
	{
		unset($this->attributes[(string) $attr]);
	}
	
	/* clear */
	function clear()
	{
		$this->attributes = array();
	}
	
	/* append */
	function append($object)
	{
		if (@get_class($object) == __class__)
		{
			array_push($this->children, $object);
		}
        else
        {
            $text   = (string) $object;
            $object = new html_element();
            $object->text($text);
            array_push($this->children, $object);
        }
	}
    
    /* set text */
    function text($text)
    {
        $this->innerHTML = (string) $text;
    }
	
	/* build */
	function build()
	{
        $build = '';
        
        if (is_null($this->type))
        {
            return $this->innerHTML;
        }
        
		//start
		$build = '<' . $this->type;
        
        //build class
        $this->build_class();
        
        //build style
        $this->build_style();
		
		//add attributes
		if (count($this->attributes))
		{
			foreach($this->attributes as $key=>$value)
			{
				$build .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
			}
		}
		
		//closing
		if(!in_array($this->type, $this->self_closers))
		{
			$build .= '>' . $this->build_children() . '</' . $this->type .'>';
		}
		else
		{
			$build .= ' />';
		}
		
		//return it
		return $build;
	}
    
    function build_children()
    {
        $build = '';
        if (strlen($this->innerHTML))
        {
            return $this->innerHTML;
        }
        else 
        {
            foreach ($this->children as $k => $child)
            {
                $build .= $child->build();
            }
            return $build;
        }
    }
    
    /* build class */
    function build_class()
    {
        if (!empty($this->classes))
        {
            $this->classes = array_values($this->classes);
            $this->set('class', implode(' ', $this->classes));
        }
    }
    
    /* build style */
    function build_style()
    {
        if (is_array($this->styles))
        {
            $build = '';
            foreach ($this->styles as $style => $value)
            {
                if ($value == '') 
                {
                    continue;
                }
                $build .= $style . ':' . $value . ';';
            }
            if (strlen($build) != 0)
            {
                $this->set('style', $build);
            }
        }
    }
	
	/* spit it out */
	function output()
	{
		echo $this->build();
	}
    
    /* add class */
    function add_class($class)
    {
        if (!is_array($class)) 
        {
            array_push($this->classes, (string) $class);
        }
        else
        {
            $this->classes = array_merge($this->classes, $class);
        }
    }
    
    /* remove class */
    function remove_class($class)
    {
        if (!is_array($class)) 
        {
            $class = array((string) $class);
        }
        $this->classes = array_diff($this->classes, $class);
    }
    
    function css($attr, $value = '')
    {
        $this->styles[(string) $attr] = (string) $value;
    }
   
}

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
$div->output();
?>