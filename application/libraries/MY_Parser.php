<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Overrides the CI Template Parser to allow for multiple occurrences of the
 * same variable pair
 *
 */
class MY_Parser extends CI_Parser {

	/**
	 * Parse a template
	 *
	 * Parses pseudo-variables contained in the specified template view,
	 * replacing them with the data in the second param
	 *
	 * @param	string
	 * @param	array
	 * @param	boolean
	 * @return	string
	 */
	public function parse($template, $data, $return = FALSE)
	{
		$template = $this->CI->load->view($template, $data, TRUE);
		$template = $this->_parse_double($template, $data);
		return $this->_parse($template, $data, $return);
	}
	
	/**
	 * Parse a template with attribute parser-repeat
	 *
	 * @param	string
	 * @param	array
	 * @param	boolean
	 * @return	string
	 */
	public function parse_repeat($template, $data, $return = FALSE)
	{
		$template = $this->CI->load->view($template, $data, TRUE);
		//$template = $this->_parse_double($template, $data);//ไม่ต้องใช้ Double แล้ว
		$template = $this->_parse_attribute($template, $data, $return);
		return $this->_parse($template, $data, $return);
	}
	
	/**
	 * Parse data to a double bracket key/value
	 *
	 * @param	string
	 * @param	array
	 * @return	string
	 */
	protected function _parse_double($template, $data)
	{
		$replace = array();
		preg_match_all("/\{\{(.*?)\}\}/si", $template, $matches);
		
		foreach ($matches[1] as $match)
		{
			$key = '{{'.$match.'}}';
			$replace[$key] = isset($data[$match]) ? $data[$match] : $key;
		}
		unset($data);
		return strtr($template, $replace);
	}
	
	/**
	 * Parse array data list with attribute
	 *
	 * @param	string
	 * @param	array
	 * @param	boolean
	 * @return	array
	 */	 
	protected function _parse_attribute($template, $data, $return = FALSE)
	{
		if ($template === '')
		{
			return FALSE;
		}

		$replace = array();
		foreach ($data as $key => $val)
		{
			$replace = array_merge(
				$replace,
				is_array($val)
					? $this->_parse_attribute_pair($key, $val, $template)
					: $this->_parse_single($key, (string) $val, $template)
			);
		}
		
		

		unset($data);
		$template = strtr($template, $replace);
		/* return only
		if ($return === FALSE)
		{
			$this->CI->output->append_output($template);
		}
		*/
		return $template;
	}
	
	/**
	 * Parse data to pseudo-variables between attribute parser-repeat
	 *
	 * @param	string
	 * @param	array
	 * @param	string
	 * @return	array
	 */
	protected function _parse_attribute_pair( $attr_value, $data, $string)
	{
		$replace = array();
		
		$matches = $this->_get_html_between('parser-repeat', $attr_value, $string);
		
		if(!empty($matches)){
			foreach ($matches as $match)
			{
				$str = '';
				foreach ($data as $row)
				{
					$temp = array();
					foreach ($row as $key => $val)
					{
						if (is_array($val))
						{
							$pair = $this->_parse_attribute_pair($key, $val, $match[0]);
							if ( ! empty($pair))
							{
								$temp = array_merge($temp, $pair);
							}
							continue;
						}
						$temp[$this->l_delim.$key.$this->r_delim] = $val;
					}
					//$temp[' parser-repeat="['.$attr_value.']"'] = '';//Clear repeat attribute
					$str .= strtr($match[0], $temp);
				}
				$replace[$match[0]] = $str;
			}
		}
		return $replace;
	}
	
	/**
	 * Match html element between attribute parser-repeat="[*]"
	 * 
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	array
	 */
	private function _get_html_between( $attr, $value, $xml, $tag=null ) 
	{
		if( is_null($tag) ){
			$tag = '\w+';
		}else{
			$tag = preg_quote($tag);
		}
		$attr = preg_quote($attr);
		$value = preg_quote($value);

		//SEARCH TAG TARGET (IT WILL BREAK WITH FIRST CLOSE TAG)
		$tag_regex = "/<(".$tag.")[^>]*".$attr."\s*=\s*(['\"])\[$value\]\\2[^>]*>(.*?)(<\/\\1>)/si";
		preg_match_all($tag_regex,
					 $xml,
					 $results,
					 PREG_SET_ORDER);
					 
		if(isset($results[0][1])){
			$check = count($results);	// IF HAS MORE THAN ONE TAG MUST USE \+w
			if($check == 1){
				$tag = $results[0][1];	// SET IF ONE TAG NAME
			}
			
			//GET CONTENT AGAIN WITH MULTI CLOSE TAG
			$multi_regex = '{<'.$tag.'[^>]*'.$attr.'="\['.$value.'\]"[^>]*>((?:(?:(?!<'.$tag.'[^>]*>|<\/'.$tag.'>).)++|<'.$tag.'[^>]*>(?1)<\/'.$tag.'>)*)<\/'.$tag.'>}si';
			preg_match_all($multi_regex,
						 $xml,
						 $matches_result,
						 PREG_SET_ORDER);
			/*
			// PREVIEW FOR TEST DATA NOT IN CONDITION
			if($check > 1){
				echo '<h1>CHECK > 1 : </h1><pre>', htmlentities(print_r($results, true)),'</pre>';
				echo '<h1>Result CHECK > 1 : TAG = '.$tag.'</h1>
					<pre>Pattern : <b>'.htmlentities($multi_regex).'</b><br/><br/>', htmlentities(print_r($matches_result, true)),'</pre>';
			}else{
				echo '<h1>CHECK (1) : </h1><pre>', htmlentities(print_r($results, true)),'</pre>';
				echo '<h1>Result CHECK (1) : TAG = '.$tag.'</h1>
					<pre>Pattern : <b>'.htmlentities($multi_regex).'</b><br/><br/>', htmlentities(print_r($matches_result, true)),'</pre>';
			}
			*/
			$results = $matches_result;
		}

		return $results;
	}
	
}

// END Parser Class

/* End of file MY_Parser.php */
/* Location: ./application/libraries/MY_Parser.php */