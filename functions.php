<?php

function sort_nested_arrays($array, $args = []) {
	usort(
        $array, function($a, $b) use ($args) {
            $res = 0;

            $a = (object)$a;
            $b = (object)$b;

            foreach($args as $k => $v) {
                if($a->$k == $b->$k) {
                    continue;
                }

                $res = ($a->$k < $b->$k) ? -1 : 1;
                if($v == 'desc') {
                    $res = -$res;
                }
                break;
            }

            return $res;
        }
    );

	return $array;
}