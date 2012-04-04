<?
/* creates an html element, like in js */
class html_element
{
	private $self_closers;
    
    private $innerHTML = '';
	private $type;
	private $attributes;
    
    private $classes   = array();
    private $styles;
      
    private $children  = array();    
	
	/* constructor */
	function __construct($type = null, $self_closers = array('input', 'img', 'hr', 'br', 'meta', 'link'))
	{
        if (!is_null($type))
        {
            $this->type = strtolower($type);
            $this->self_closers = $self_closers;
        }
	}
	
	/* set -- array or key, value */
	function attr($attribute, $value = null)
	{   
        if (is_null($value))
        {
            return $this->attributes[$attribute];
        }
        else
        {
            $this->attributes[$attribute] = $value;
        }
	}
    
    /* remove attribute */
    function remove_attr($attribute)
    {
        unset($this->attributes[$attribute]);
    }
    
    /* get child node */
    function children($id)
    {
        return $this->children[$id];
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
			foreach($this->attributes as $key => $value)
			{
                $value = (string) $value;
                if (strlen($value))
                {
                    $build .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
                }
			}
		}
		
		//closing
		if(!in_array($this->type, $this->self_closers))
		{
			$build .= '>' . $this->build_innerHTML() . '</' . $this->type .'>';
		}
		else
		{
			$build .= ' />';
		}
		
		//return it
		return $build;
	}
    
    /* build child nodes */
    private function build_innerHTML()
    {
        $build = '';
        if (strlen($this->innerHTML))
        {
            return htmlspecialchars($this->innerHTML);
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
    
    /* set text */
    function text($text)
    {
        $this->innerHTML = (string) $text;
    }
    
    /* build class */
    private function build_class()
    {
        if (!empty($this->classes))
        {
            $this->classes = array_values($this->classes);
            $this->attr('class', implode(' ', $this->classes));
        }
    }
    
    /* add class */
    function add_class($class)
    {
        if (!is_array($class)) 
        {
            array_push($this->classes, $class);
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
            $class = array($class);
        }
        $this->classes = array_diff($this->classes, $class);
    }
    
    /* build style */
    private function build_style()
    {
        if (is_array($this->styles))
        {
            $build = '';
            foreach ($this->styles as $style => $value)
            {
                $value = (string) $value;
                if (strlen($value))
                {
                    $build .= $style . ':' . $value . ';';
                }
            }
            if (strlen($build))
            {
                $this->attr('style', $build);
            }
        }
    }
    
    /* set css style */
    function css($attribute, $value = null)
    {
        if (is_null($value))
        {
            return $this->styles[$attribute];
        }
        else
        {
            $this->styles[$attribute] = $value;
        }
        
    }
    
    /* spit it out */
	function output()
	{
		echo $this->build();
	}
    
    function __toString()
    {
        return $this->build();
    }
   
}

?>