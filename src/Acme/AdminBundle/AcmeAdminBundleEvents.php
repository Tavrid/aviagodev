<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.03.14
 * Time: 14:27
 */

namespace Acme\AdminBundle;


class AcmeAdminBundleEvents {
    /**
     *  Событие пред инициализацией всех переменных в методе редактированя
     *  Нужно добавить слушатель к этому событию и передать модель данных и модель загрузчик(если надо)
     *  Слушать для данного события являеться обязательным
     */
    const INITIALIZE_EDIT = 'admin.initialize.edit.event';

    const LOAD_ENTITY_EDIT = 'admin.load.entity.edit.event';
    /**
     * Событие срабатывает после успешной валидации формы
     *
     */
    const FORM_SUCCESS_VALIDATE_EDIT = 'admin.form.success.validate.edit.event';

    /**
     * Событие срабатывает после не удачной валидации формы
     *
     */
    const FORM_ERROR_VALIDATE_EDIT = 'admin.form.error.validate.edit.event';
    /**
     * Событие срабатывает после обновления сущьности в базе данных
     */
    const ENTITY_SUCCESS_EDIT = 'admin.entity.success.edit.event';
    /**
     *  События срабатывает самым последним в основном нужно для конфигурации основного ответа
     *
     */
    const FINAL_EDIT = 'admin.final.edit.event';

    /**
     *  Событие пред инициализацией всех переменных в методе сохранения
     *  Нужно добавить слушатель к этому событию и передать модель данных и модель загрузчик(если надо)
     *  Слушать для данного события являеться обязательным
     */
    const INITIALIZE_ADD = 'admin.initialize.add.event';

    /**
     * Событие срабатывает после успешной валидации формы
     */
    const FORM_SUCCESS_VALIDATE_ADD = 'admin.form.success.validate.add.event';

    /**
     * Событие срабатывает после неудачной валидации формы
     */
    const FORM_ERROR_VALIDATE_ADD = 'admin.form.error.validate.add.event';

    /**
     * Событие срабатывает после сохранения сущьности в базу данных
     */
    const ENTITY_SUCCESS_ADD = 'admin.entity.success.add.event';

    /**
     * События срабатывает самым последним в основном нужно для конфигурации основного ответа
     *
     */
    const FINAL_ADD = 'admin.final.add.event';

    /**
     *  Событие пред инициализацией всех переменных в методе удаление
     *  Нужно добавить слушатель к этому событию и передать модель данных и модель загрузчик(если надо)
     *  Слушать для данного события являеться обязательным
     */
    const INITIALIZE_DELETE = 'admin.initialize.delete.event';
    /**
     * Событие срабатывает после успешной валидации формы
     */
    const FORM_SUCCESS_VALIDATE_DELETE = 'admin.form.success.validate.delete.event';
    /**
     * Событие срабатывает после удаления сущности
     */
    const ENTITY_SUCCESS_DELETE = 'admin.entity.success.delete.event';
}