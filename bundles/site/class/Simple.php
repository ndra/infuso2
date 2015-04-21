<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 21.04.2015
 * Time: 10:37
 */

namespace Infuso\Site\Model;
use Infuso\Core;


class Simple extends \Infuso\ActiveRecord\Record {

    const SECTION_REVIEWS = 0;
    const SECTION_CLUB = 1;

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ),array (
                    'name' => 'priority',
                    'type' => 'bigint',
                    'label' => 'приоритет',
                    "editable" => false,
                ),array (
                    'name' => 'date',
                    'type' => 'date',
                    'label' => 'Дата создания',
                    "editable" => true,
                    'default' => 'now()'
                ),array (
                    'name' => 'photo',
                    'type' => 'file',
                    'label' => 'Фото',
                    "editable" => true,
                ),array (
                    'name' => 'name',
                    'type' => 'textfield',
                    'label' => 'Имя и Отчество',
                    "editable" => true,
                ),array (
                    'name' => 'salon',
                    'type' => 'textfield',
                    'label' => 'Салон',
                    "editable" => true,
                ),array (
                    'name' => 'email',
                    'type' => 'textarea',
                    'label' => 'Почта',
                    "editable" => true,
                ),array (
                    'name' => 'comments',
                    'type' => 'tinymce',
                    'label' => 'Комментарий',
                    "editable" => true,
                ),array (
                    'name' => 'section',
                    'type' => 'select',
                    'label' => 'Раздел',
                    "editable" => true,
                    "method" => "enumStatuses",
                ), array (
                    'name' => 'published',
                    'type' => 'checkbox',
                    'label' => 'Опубликовать',
                    "editable" => true,
                ),
            ),
        );
    }

    public static function indexTest() {
        return true;
    }


    public function enumStatuses() {
        return array (
            self::SECTION_REVIEWS => "Раздел отзывы",
            self::SECTION_CLUB => "Клуб Брелил",
        );
    }

    public static function all() {
        return service("ar")
            ->collection(get_class())->desc("date");
    }

    public static function get($id) {
        return service("ar")->get(get_class(), $id);
    }

}
