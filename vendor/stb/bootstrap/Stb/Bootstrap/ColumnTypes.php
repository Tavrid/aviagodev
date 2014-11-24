<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.03.14
 * Time: 14:23
 */

namespace Stb\Bootstrap;

class ColumnTypes {

    const TYPE_BOOL = 'stb.boolean.column.manager';
    const TYPE_BOOL_EDITABLE = 'stb.editable.boolean.column.manager';
    const TYPE_BASE = 'stb.base.column.manager';
    const TYPE_EDITABLE_TEXT = 'stb.editable.text.column.manager';
    const TYPE_AJAX_IKON = 'stb.ajax.icon.column.manager';
    const TYPE_LINK_IKON = 'stb.link.icon.column.manager';
    const TYPE_MODAL_IKON = 'model.icon.column.manager';
    const TYPE_ICON = 'stb.model.icon.manager';
    const TYPE_CALLBACK = 'stb.model.callback.manager';

    static $columnTypes = array(
        self::TYPE_BASE => 'Stb\Bootstrap\Components\BaseColumn',
        self::TYPE_BOOL => 'Stb\Bootstrap\Components\BoolColumn',
        self::TYPE_BOOL_EDITABLE => 'Stb\Bootstrap\Components\BoolEditableColumn',
        self::TYPE_EDITABLE_TEXT => 'Stb\Bootstrap\Components\EditableTextColumn',
        self::TYPE_AJAX_IKON => 'Stb\Bootstrap\Components\AjaxIkonColumn',
        self::TYPE_LINK_IKON => 'Stb\Bootstrap\Components\LinkIkonColumn',
        self::TYPE_MODAL_IKON => 'Stb\Bootstrap\Components\ModalIkonColumn',
        self::TYPE_ICON => 'Stb\Bootstrap\Components\IconColumn',
        self::TYPE_CALLBACK => 'Stb\Bootstrap\Components\CallbackColumn'
    );

} 