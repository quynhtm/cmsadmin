<?php
/**
 * QuynhTM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{

    function getFieldTable()
    {
        $fields = Schema::getColumnListing($this->getTable());
        return $fields;
    }

    function checkFieldInTable($dataInput = [])
    {
        $dataDB = array();
        $field_table = $this->getFieldTable();
        if (empty($dataInput) && empty($field_table))
            return $dataDB;
        if (!empty($field_table)) {
            foreach ($field_table as $field) {
                if (isset($dataInput[trim($field)])) {
                    $dataDB[trim($field)] = ($dataInput[trim($field)] === 'NULL') ? NULL : $dataInput[trim($field)];
                }
            }
        }
        return $dataDB;
    }

    /**
     * Check field TOUPPER
     * @param array $dataInput
     * @return array
     */
    function checkToUpperFieldInTable($dataInput = [])
    {
        $dataDB = array();
        $field_table = $this->getFieldTable();
        if (empty($dataInput) && empty($field_table))
            return $dataDB;

        if (!empty($field_table)) {
            foreach ($field_table as $field) {
                $FIELD = strtoupper(trim($field));
                if (isset($dataInput[$FIELD])) {
                    $dataDB[$FIELD] = ($dataInput[$FIELD] === 'NULL') ? NULL : $dataInput[$FIELD];
                }
            }
        }
        return $dataDB;
    }

    public function getFieldsSearch($dataSearch = array())
    {
        $fields = array();
        if (isset($dataSearch['field_get'])) {
            if (is_array($dataSearch['field_get'])) {
                $fields = $dataSearch['field_get'];
            } else {
                $fields = (trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            }
        }
        return $fields;
    }

    /**
     * QuynhTM add insert multiple
     * @param $table
     * @param $dataInput
     * @return bool|int
     */
    public function insertMultiple($dataInput, $is_strtoupper = false)
    {
        $fieldInput = [];
        foreach ($dataInput as $k => $data_va) {
            $fieldInput[] = ($is_strtoupper) ? $this->checkToUpperFieldInTable($data_va) : $this->checkFieldInTable($data_va);
        }
        if (empty($fieldInput))
            return true;
        $str_sql = buildSqlInsertMultiple($this->table, $fieldInput);
        if (trim($str_sql) != '') {
            if (DB::statement($str_sql)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * @param $dataInput
     * @param bool $is_strtoupper
     * @return bool|string
     */
    public function buildStrSqlInsertMultiple($dataInput, $is_strtoupper = false)
    {
        $fieldInput = [];
        foreach ($dataInput as $k => $data_va) {
            $fieldInput[] = ($is_strtoupper) ? $this->checkToUpperFieldInTable($data_va) : $this->checkFieldInTable($data_va);
        }
        if (empty($fieldInput))
            return true;
        $str_sql = buildSqlInsertMultiple($this->table, $fieldInput);
        return $str_sql;
    }

    /**
     * @param $dataInput
     * @param bool $is_strtoupper
     * @return bool|string
     */
    public function buildStrSqlUpdate($dataInput, $condition = '', $is_strtoupper = false)
    {
        $fieldInput = [];
        foreach ($dataInput as $k => $data_va) {
            $fieldInput = ($is_strtoupper) ? $this->checkToUpperFieldInTable($data_va) : $this->checkFieldInTable($data_va);
        }
        if (empty($fieldInput))
            return true;
        $str_sql = buildSqlUpdate($this->table, $fieldInput,$condition);
        return $str_sql;
    }
}
