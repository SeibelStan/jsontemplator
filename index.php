<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require('functions.php');

$scheme_name = isset($_REQUEST['scheme']) ? $_REQUEST['scheme'] : 'pets';

$scheme = file_get_contents('schemes/index.json');
$scheme = json_decode($scheme);

$data = file_get_contents('schemes/' . $scheme_name . '.json');
$data = json_decode($data);

$fields = [];
$fields_descr = [];
foreach($scheme->$scheme_name as $key => $value) {
    array_push($fields, $key);
    array_push($fields_descr, $value);
}

foreach($data as $row) {
    foreach($fields as $field) {
        $row->$field = isset($row->$field) ? $row->$field : '';
    }
}

$keys = $fields;
if(isset($_REQUEST['keys'])) {
    $keys = explode(',', $_REQUEST['keys']);
}

$values = [];
if(isset($_REQUEST['values'])) {
    $values = explode(',', $_REQUEST['values']);
}

$mode = 'sum';
if(isset($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

if($values) {
    $tmp_data = [];
    foreach($data as $row) {
        $i = 0;
        if($mode == 'sum') {
            $compare = false;
            foreach($fields as $field) {
                if(in_array($row->$field, $values)) {
                    $compare = true;
                }
            }
        }
        else {
            $compare = true;
            foreach($fields as $field) {
                if(isset($values[$i])) {
                    if($values[$i] && $row->$field != $values[$i]) {
                        $compare = false;
                    }
                }
                $i++;
            }
        }
        if($compare) {
            array_push($tmp_data, $row);
        }
    }
    $data = $tmp_data;
}

$sort = (object)[];
if(isset($_REQUEST['sort'])) {
    $raw_sort = explode(',', $_REQUEST['sort']);
    foreach($raw_sort as $sort_part) {
        $sort_part = explode(':', $sort_part);
        $sort_field = $sort_part[0];
        $sort->$sort_field = $sort_part[1];
    }
}

$data = sort_nested_arrays($data, $sort);

$head_row = (object)[];
for($i = 0; $i < count($fields); $i++) {
    $field = $fields[$i];
    $head_row->$field = $fields_descr[$i];
}
array_unshift($data, $head_row);

$view_name = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'json';
include('views/' . $view_name . '.php');