<?php
class AppSimpleJsonView extends View
{
    public function render($action = null)
    {
        header("Content-Type: application/json; charset=utf-8");
        $this->controller->output .= json_encode($this->vars['response']);
    }
}
