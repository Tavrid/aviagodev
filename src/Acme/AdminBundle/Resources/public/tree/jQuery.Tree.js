
(function($) {

    var CLASS_JQUERY_TREE = 'jquery-tree';
    var CLASS_JQUERY_TREE_CONTROLS = 'jquery-tree-controls';
    var CLASS_JQUERY_TREE_COLLAPSE_ALL = 'jquery-tree-collapseall';
    var CLASS_JQUERY_TREE_EXPAND_ALL = 'jquery-tree-expandall';
    var CLASS_JQUERY_TREE_COLLAPSED = 'jquery-tree-collapsed';
    var CLASS_JQUERY_TREE_HANDLE = 'jquery-tree-handle';
    var CLASS_JQUERY_TREE_TITLE = 'jquery-tree-title';
    var CLASS_JQUERY_TREE_NODE = 'jquery-tree-node';
    var CLASS_JQUERY_TREE_LEAF = 'jquery-tree-leaf';
    var CLASS_JQUERY_TREE_CHECKED = 'jquery-tree-checked';
    var CLASS_JQUERY_TREE_UNCHECKED = 'jquery-tree-unchecked';
    var CLASS_JQUERY_TREE_CHECKED_PARTIAL = 'jquery-tree-checked-partial';

    var COLLAPSE_ALL_CODE = '<span class="' + CLASS_JQUERY_TREE_COLLAPSE_ALL + ' label label-important">Свернуть все</span>';
    var EXPAND_ALL_CODE = '<span class="' + CLASS_JQUERY_TREE_EXPAND_ALL + ' label label-success">Развернуть все</span>';
    var TREE_CONTROLS_CODE = '<div class="' + CLASS_JQUERY_TREE_CONTROLS + '">' +
            COLLAPSE_ALL_CODE +
            EXPAND_ALL_CODE +
            '</div>';

    var TREE_NODE_HANDLE_CODE = '<span class="' + CLASS_JQUERY_TREE_HANDLE + '">+</span>';
    var TREE_NODE_HANDLE_COLLAPSED = "+";
    var TREE_NODE_HANDLE_EXPANDED = "&minus;";

    $.fn.extend({
        Tree: function() {
            // Добавим контролы для всего дерева (все свернуть, развернуть и т.д.), и добавим класс

            $(this).addClass(CLASS_JQUERY_TREE)
                    .before(TREE_CONTROLS_CODE)
                    .prev('.' + CLASS_JQUERY_TREE_CONTROLS)
                    .find('.' + CLASS_JQUERY_TREE_COLLAPSE_ALL).on('click', function() {
                $(this).parent().next('.' + CLASS_JQUERY_TREE)
                        .find('li:has(ul)')
                        .addClass(CLASS_JQUERY_TREE_COLLAPSED)
                        .find('.' + CLASS_JQUERY_TREE_HANDLE)
                        .html(TREE_NODE_HANDLE_COLLAPSED);
            }).parent('.' + CLASS_JQUERY_TREE_CONTROLS).find('.' + CLASS_JQUERY_TREE_EXPAND_ALL)
                    .on('click', function() {
                $(this).parent().next('.' + CLASS_JQUERY_TREE)
                        .find('li:has(ul)')
                        .removeClass(CLASS_JQUERY_TREE_COLLAPSED)
                        .find('.' + CLASS_JQUERY_TREE_HANDLE)
                        .html(TREE_NODE_HANDLE_EXPANDED);
            });

            $('li', this).find(':first').addClass(CLASS_JQUERY_TREE_TITLE)
                    .closest('li').addClass(CLASS_JQUERY_TREE_LEAF);

            // Для всех элементов, являющихся узлами (имеющих дочерние элементы)...
            $(this).find('li:has(ul:has(li))').find(':first')
                    // ... добавим элемент, открывающий/закрывающий узел
                    .before(TREE_NODE_HANDLE_CODE)
                    // ... добавим к контейнеру класс "узел дерева" и "свернем".
                    .closest('li')
                    .addClass(CLASS_JQUERY_TREE_NODE)
                    .addClass(CLASS_JQUERY_TREE_COLLAPSED)
                    .removeClass(CLASS_JQUERY_TREE_LEAF);

            // ... повесим обработчик клика
            $('.' + CLASS_JQUERY_TREE_HANDLE).on('click', function() {
                var leafContainer = $(this).parent('li');
                var leafHandle = leafContainer.find('>.' + CLASS_JQUERY_TREE_HANDLE);

                leafContainer.toggleClass(CLASS_JQUERY_TREE_COLLAPSED);

                if (leafContainer.hasClass(CLASS_JQUERY_TREE_COLLAPSED))
                    leafHandle.html(TREE_NODE_HANDLE_COLLAPSED);
                else
                    leafHandle.html(TREE_NODE_HANDLE_EXPANDED);
            });

            // Добавляем обработку клика по чекбоксам
            $('input:checkbox').on('click', function() {
                setLabelClass(this);
                checkCheckbox(this);
            })
                    // Выставляем чекбоксам изначальные классы
                    .each(function() {
                setLabelClass(this);
//                if ($(this).is('checked'))
//                    checkParentCheckboxes(this);
            });
        }

    });

    /**
     * Рекурсивно проверяет, все ли чекбоксы в поддереве родительского узла выбраны.
     * Если ни один чекбокс не выбран - снимает чек с родительского чекбокса
     * Если хотя бы один, но не все - выставляет класс CLASS_JQUERY_TREE_CHECKED_PARTIAL родительскому чекбоксу
     * Если все - ставит чек на родительский чекбокс
     *
     * @param {Object} checkboxElement текущий чекбокс
     */
    function checkParentCheckboxes(checkboxElement) {
        if (typeof checkboxElement == 'undefined' || !checkboxElement)
            return;

        // проверим, все ли чекбоксы выделены/частично выделены на вышележащем уровне
        var closestNode = $(checkboxElement).closest('ul');
        var allCheckboxes = closestNode.find('input:checkbox');
        var checkedCheckboxes = closestNode.find('input:checkbox:checked');

        var allChecked = allCheckboxes.length === checkedCheckboxes.length;

        var parentCheckbox = closestNode.closest('li').find('>.' + CLASS_JQUERY_TREE_TITLE + ' input:checkbox');

        if (parentCheckbox.length > 0) {
            parentCheckbox.get(0).checked = allChecked;

            if (!allChecked && checkedCheckboxes.length > 0)
                parentCheckbox.closest('label')
                        .addClass(CLASS_JQUERY_TREE_CHECKED_PARTIAL)
                        .removeClass(CLASS_JQUERY_TREE_CHECKED)
                        .removeClass(CLASS_JQUERY_TREE_UNCHECKED);
            else
            if (allChecked)
                parentCheckbox.closest('label')
                        .removeClass(CLASS_JQUERY_TREE_CHECKED_PARTIAL)
                        .removeClass(CLASS_JQUERY_TREE_UNCHECKED)
                        .addClass(CLASS_JQUERY_TREE_CHECKED);
            else
                parentCheckbox.closest('label')
                        .removeClass(CLASS_JQUERY_TREE_CHECKED_PARTIAL)
                        .removeClass(CLASS_JQUERY_TREE_CHECKED)
                        .addClass(CLASS_JQUERY_TREE_UNCHECKED);

//            checkParentCheckboxes(parentCheckbox.get(0));
        }
    }

    /**
     * Если у текущего чекбокса есть дочерние узлы - меняет их состояние
     * на состояние текущего чекбокса
     *
     * @param {Object} checkboxElement текущий чекбокс
     */
    function checkCheckbox(checkboxElement) {
        // чекнем/анчекнем нижележащие чекбоксы
        $(checkboxElement).parent('li').find('input:checkbox').each(function() {
            console.log(this);
            this.checked = $(checkboxElement).attr('checked', true);
            setLabelClass(this);
        });
//        checkParentCheckboxes(checkboxElement);
    }
    ;

    /**
     * Выставляет класс лейблу в зависимости от состояния чекбокса
     *
     * @param {Object} checkboxElement чекбокс
     */
    function setLabelClass(checkboxElement) {
        isChecked = $(checkboxElement).is(':checked');
        if (isChecked) {
            $(checkboxElement).parent('label')
                    .addClass(CLASS_JQUERY_TREE_CHECKED)
                    .removeClass(CLASS_JQUERY_TREE_UNCHECKED)
                    .removeClass(CLASS_JQUERY_TREE_CHECKED_PARTIAL).attr('checked', true);
        } else {
            $(checkboxElement).parent('label')
                    .addClass(CLASS_JQUERY_TREE_UNCHECKED)
                    .removeClass(CLASS_JQUERY_TREE_CHECKED)
                    .removeClass(CLASS_JQUERY_TREE_CHECKED_PARTIAL).attr('checked', false);
        }
    }


//    /**
//     * Обрабатывает клик по лейблу (для IE6)
//     */
//    function labelClick(labelElement) {
//        var checkbox = $('input:checkbox', labelElement);
//        var checked = checkbox.attr('checked');
//        checkbox.attr('checked', !checked);
//        setLabelClass(checkbox);
//    }

})(jQuery);
