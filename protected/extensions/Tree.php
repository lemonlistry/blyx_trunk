<?php

/**
 * 树形数据辅助类
 *
 */
class Tree {

    /**
     * 根据二维数组生成多维的树形菜单数组
     * 用法：
     * <pre>
     * Tree::treeView(array(
     *   array('id'=>1,'text'='<a href="?id=1">','parent_id'=>0,'htmlOptions'=>array('date-id'=>1)),
     *   array('id'=>2,'text'='<a href="?id=2">','parent_id'=>1,'htmlOptions'=>array('date-id'=>2)),
     * ));
     * </pre>
     * @param array $data 要求格式：
     * <ul>
     * <li>id: id 本条记录编号</li>
     * <li>text: string 需要显示的内容，可以为HTML</li>
     * <li>parent_id: int 上级记录编号</li>
     * <li>htmlOptions: array 其他需要显示的HTML属性</li>
     * </ul>
     * @param int $parent_id 上级编号，默认为0，作为内部递归调用，一般不需要关心
     * @return array 返回符合TreeView要求的多维树形菜单数组
     */
    public static function treeView($data, $parent_id = 0) {
        $tree = array();
        foreach ($data as $v) {
            if ($v['parent_id'] === $parent_id) {
                $tmp = self::treeView($data, $v['id']);
                $tree[] = array(
                    'hasChildren' => empty($tmp) ? 0 : 1,
                    'htmlOptions' => $v['htmlOptions'],
                	'expanded' => isset($v['expanded']) ? $v['expanded'] : true,
                	'is_use' => isset($v['is_use']) ? $v['is_use'] : 0,
					'animated' => isset($v['animated']) ? $v['animated'] : 'normal',
                    'text' => $v['text'],
                    'children' => $tmp,
                );
            }
        }
        return $tree;
    }

    /**
     * 根据二维数组生成下拉菜单
     * 用法：
     * <pre>
     * Tree::DropdownList(array(
     *   array('id'=>1,'name'='name1','parent_id'=>0),
     *   array('id'=>2,'name'='name2','parent_id'=>1),
     * ));
     * </pre>
     * @param array $data 要求格式参见用法
     * @param int $skip_id 需要忽略的编号。比如编辑目录树时选择上级需要忽略自己。默认为null不忽略
     * @param int $parent_id 上级编号。默认为0，递归用，一般可以不填写
     * @param int $level 当前级别。递归用，一般不填写
     * @return array 返回的是DropdownList需要的数组格式
     */
    public static function DropdownList($data, $skip_id = null, $parent_id = 0, $level = 0, &$arr = array()) {
        foreach ($data as $v) {
            $v = (array) $v;
            if ($v['parent_id'] == $parent_id) {
                // 如果设置了skip_id且当前编号等于skip_id则跳过
                if (!empty($skip_id)) {
                    $skip_id = is_array($skip_id) ? $skip_id : array($skip_id);
                    if (in_array($v['id'], $skip_id)) {
                        continue;
                    }
                }
                $arr[$v['id']] = str_repeat('&nbsp;', $level * 3) . $v['name'];
                self::DropdownList($data, $skip_id, $v['id'], $level + 1, $arr);
            }
        }
        return $arr;
    }

}
