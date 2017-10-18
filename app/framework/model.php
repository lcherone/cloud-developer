<?php
namespace Framework {

    use RedBeanPHP\R;

    class Model
    {
        protected $table;

        /**
         *
         */
        public function __construct($table = null)
        {
            // set table
            $this->table = $table;

            // connect to redbean
            if (!R::testConnection()) {
                
                // get framework
                $f3 = \Base::instance();
                
                $db = $f3->get('db');
                
                R::addDatabase(
                    'connection',
                    'mysql:host='.$db['host'].';dbname='.$db['name'],
                    $db['username'],
                    $db['password']
                );
                
                R::selectDatabase('connection');
                R::freeze($db['freeze']);
                R::debug($db['debug'], 2);
            }
        }
        
        /**
    	 * New
    	 */
        public function create($data = [])
        {
            if ($this->table === null) {
                return null;
            }
            
            $row = R::dispense($this->table);
            $row->import($data);
    
            return $row;
        }
        
            
        /**
    	 * Find
    	 */
        public function find($where = null, $params = null)
        {
            if ($this->table === null) {
                return null;
            }
            
            if ($where !== null && $params !== null) {
                return R::find($this->table, $where, $params);
            } elseif ($where !== null && $params === null) {
                return R::find($this->table, $where);
            } else {
                return R::find($this->table);
            }
        }
    
        /**
         * Find All
         */
        public function findAll($where = null, $params = null)
        {
            if ($this->table === null) {
                return null;
            }
            
            if ($where !== null && $params !== null) {
                return R::findAll($this->table, $where, $params);
            } elseif ($where !== null && $params === null) {
                return R::findAll($this->table, $where);
            } else {
                return R::findAll($this->table);
            }
        }

        /**
    	 * Find One
    	 */
        public function findOne($where = null, $params = null)
        {
            if ($this->table === null) {
                return null;
            }
            
            if ($where !== null && $params !== null) {
                return R::findOne($this->table, $where, $params);
            } elseif ($where !== null && $params === null) {
                return R::findOne($this->table, $where);
            } else {
                return R::findOne($this->table);
            }
        }
        
        /**
    	 * Get all
    	 */
        public function getAll($where = null, $params = null)
        {
            if ($where !== null && $params !== null) {
                return R::getAll($where, $params);
            } elseif ($where !== null && $params === null) {
                return R::getAll($where);
            } else {
                return [];
            }
        }
        
        /**
    	 * Get row
    	 */
        public function getRow($where = null, $params = null)
        {
            if ($where !== null && $params !== null) {
                return R::getRow($where, $params);
            } elseif ($where !== null && $params === null) {
                return R::getRow($where);
            } else {
                return [];
            }
        }
        
        /**
    	 * Get col
    	 */
        public function getCol($where = null, $params = null)
        {
            if ($where !== null && $params !== null) {
                return R::getCol($where, $params);
            } elseif ($where !== null && $params === null) {
                return R::getCol($where);
            } else {
                return null;
            }
        }
            
        /**
    	 * Get cell
    	 */
        public function getCell($where = null, $params = null)
        {
            if ($where !== null && $params !== null) {
                return R::getCell($where, $params);
            } elseif ($where !== null && $params === null) {
                return R::getCell($where);
            } else {
                return null;
            }
        }
                
        /**
    	 * findOrCreate
    	 */
        public function findOrCreate($params = [])
        {
            return R::findOrCreate($this->table, $params);
        }
    
        /**
    	 * Count
    	 */
        public function count($where = null, $params = null)
        {
            if ($this->table === null) {
                return null;
            }
            
            if ($where !== null && $params !== null) {
                return R::count($this->table, $where, $params);
            } elseif ($where !== null && $params === null) {
                return R::count($this->table, $where);
            } else {
                return R::count($this->table);
            }
        }
    
        /**
         * Load - by id
         */
        public function load($id)
        {
            if ($this->table === null) {
                return null;
            }
            
            return R::load($this->table, $id);
        }
    
        /**
    	 * Export
    	 */
        public function export(\RedBeanPHP\OODBBean $row, $parents = false)
        {
            $return = R::exportAll($row, $parents);
    
            // if single then export first
            if (!isset($return[1])) {
                return $return[0];
            }
    
            // return multi row export
            return $return;
        }
    
        /**
    	 * Store
    	 */
        public function store(\RedBeanPHP\OODBBean $row)
        {
            return R::store($row);
        }
        
        /**
    	 * Store
    	 */
        public function exec($query, $params = [])
        {
            return R::exec($query, $params);
        }
    
        /**
         * Trash bean
         */
        public function trash(\RedBeanPHP\OODBBean $row)
        {
            return R::trash($row);
        }
    }
}
