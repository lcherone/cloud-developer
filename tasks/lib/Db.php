<?php
namespace Tasks;

use RedBeanPHP\R;

class Db {

    public function __construct()
    {

    }

    /**
     * Create
     */
    public function create($data = array())
    {
        if (!isset($data[0])) {
            throw new \Exception(__CLASS__.'::create() - First element in $data array must be key 0 => \'tablename\'');
        }

        $table = $data[0];
        unset($data[0]);

        $row = R::dispense($table);
        $row->import($data);

        return $row;
    }        

    /**
     * findOrCreate
     */
    public function findOrCreate($data = array())
    {
        if (!isset($data[0])) {
            throw new \Exception(__CLASS__.'::create() - First element in $data array must be key 0 => \'tablename\'');
        }

        $table = $data[0];
        unset($data[0]);

        return R::findOrCreate($table, $data);
    }

    /**
     * Load (id)
     */
    public function load($table, $id)
    {
        return R::load($table, $id);
    }

    /**
     * Find
     */
    public function find($table = null, $where = null, $params = null)
    {
        if ($where !== null && $params !== null) {
            return R::find($table, $where, $params);
        } elseif ($where !== null && $params === null) {
            return R::find($table, $where);
        } else {
            return R::find($table);
        }
    } 

    /**
     * Find One
     */
    public function findOne($table = null, $where = null, $params = null)
    {
        if ($where !== null && $params !== null) {
            return R::findOne($table, $where, $params);
        } elseif ($where !== null && $params === null) {
            return R::findOne($table, $where);
        } else {
            return R::findOne($table);
        }
    }

    /**
     * Get
     */
    public function findAll($table, $where = null, $params = null)
    {
        if ($where !== null && $params !== null) {
            return R::findAll($table, $where, $params);
        } elseif ($where !== null && $params === null) {
            return R::findAll($table, $where);
        }else{
            return R::findAll($table);
        }
    }

    /**
     * Update
     */
    public function update(\RedBeanPHP\OODBBean $row, $data = array())
    {
        $row->import($data);
        
        return $row;
    }        

    /**
     * Store
     */
    public function store(\RedBeanPHP\OODBBean $row)
    {
        return R::store($row);
    }

    /**
     * Count
     */
    public function count($table, $where = null, $params = [])
    {
        return R::count($table, $where, $params);
    }

    /**
     * Export
     * Exports bean into an array
     */
    public function export(\RedBeanPHP\OODBBean $row)
    {
        return R::exportAll($row);
    }

    /**
     * Trash Row
     */
    public function trash(\RedBeanPHP\OODBBean $row)
    {
        return R::trash($row);
    }
    
    /**
     * Wipe Table
     */
    public function wipe($table)
    {
        return R::wipe($table);
    }

    /**
     * Nuke
     * Destroys database
     */
    public function nuke()
    {
        return R::nuke();
    }

}
