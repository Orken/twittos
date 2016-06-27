<?php
class Form{

	public $controller;

	public function __construct($controller){
		$this->controller = $controller;
	}

/*
	public function input($name,$label,$options = array()){

		if(!isset ($this->controller->request->data->$name)){
			$value = '';
		}else{
			$value = $this->controller->request->data->$name;
		}

		if($label == 'hidden'){
			return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
		}

		$html = '<div class="clearfix">
				<label for="input'.$name.'">'.$label.'</label>
				<div class="input">';

		$attr = ' ';
		foreach($options as $k=>$v){
			if($k != 'type'){
				$attr .= " $k=\"$v\"";
			}
		}

		if(!isset($options['type'])){
			$html .= '<input type="text" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';
		}elseif($options['type'] == 'textarea'){
			$html .= '<textarea id="input'.$name.'" name="'.$name.'"'.$attr.'>'.$value.'</textarea>';
		}

		$html .= '</div></div>';
		return $html;
	}

*/

 // Version 1 de la fonction (qui marche bien)

	public function input($name, $label, $option = array()){
		if(!isset ($this->controller->request->data->$name)){
			$value = '';
		}else{
			$value = $this->controller->request->data->$name;
		}
		if($label == 'hidden'){
			return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
		}

		$html = '<div class="clearfix">
				<label for="input'.$name.'">'.$label.'</label>
				<div class="input">';
		if(!isset($option['type'])){
			$html .= '<input type="text" id="input'.$name.'" name="'.$name.'" value="'.$value.'">';

		}elseif($option['type'] == 'textarea' && $option['class'] == 'wysiwyg'){
			$html .= '<textarea  id="wysiwyg" name="'.$name.'">'.$value.'</textarea>';

		}elseif($option['type'] == 'textarea'){
			$html .= '<textarea rows="12" cols="70" id="input'.$name.'" name="'.$name.'">'.$value.'</textarea>';
		}elseif($option['type'] == 'password'){
			$html .= '<input id="input'.$name.'" name="'.$name.'" type="password" value="'.$value.'"/>';
		}

		$html .= '</div></div>';
		return $html;
	}


	// public function link($label, $controller, $action, $id = null) {
	// 	$url = BASE_URL . '/' . $controller . '/' . $action;

	// 	if ( $id )
	// 		$url .= '/' . $id

	// 	return '<a href="'.$url.'">'.$label.'</a>'
	// }



}