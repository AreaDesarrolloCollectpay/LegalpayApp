<?php 
function buildTree(Array $data, $parent = 0) {
    $tree = array();
    foreach ($data as $d) {
        if ($d['parent'] == $parent) {
            $children = buildTree($data, $d['id']);
            // set a trivial key
            if (!empty($children)) {
                $d['_children'] = $children;
            }
            $tree[] = $d;
        }
    }
    return $tree;
}


$rows = array(
    array ('id' => 1, 'name' => 'Test 1', 'parent' => 0),
    array ('id' => 2, 'name' => 'Test 1.1', 'parent' => 1),
    array ('id' => 3, 'name' => 'Test 1.2', 'parent' => 1),
    array ('id' => 4, 'name' => 'Test 1.2.1', 'parent' => 3),
    array ('id' => 5, 'name' => 'Test 1.2.2', 'parent' => 3),
    array ('id' => 6, 'name' => 'Test 1.2.2.1', 'parent' => 5),
    array ('id' => 7, 'name' => 'Test 2', 'parent' => 0),
    array ('id' => 8, 'name' => 'Test 2.1', 'parent' => 7),
    array ('id' => 9, 'name' => 'Test 1.1.1', 'parent' => 2),
);

$tree = buildTree($rows);
// print_r($tree);

function printTree($tree, $r = 0, $p = null) {
    foreach ($tree as $i => $t) {
        $dash = ($t['parent'] == 0) ? '' : str_repeat('-', $r) .' ';
        printf("\t<option value='%d'  data-level='".$r."'>%s%s</option>\n", $t['id'], $dash, $t['name']);
        if ($t['parent'] == $p) {
            // reset $r
            $r = 0;
        }
        if (isset($t['_children'])) {
            printTree($t['_children'], $r+1, $t['parent']);
        }
    }
}


print("<select>\n");
printTree($tree);
print("</select>");