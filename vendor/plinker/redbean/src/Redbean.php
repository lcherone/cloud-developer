<?php
namespace Plinker\Redbean {

    use RedBeanPHP\R;

    /**
     * Redbean Plinker class
     */
    class RedBean
    {
        public $config = array();
        
        /**
         * Construct
         *
         * @param array $config
         */
        public function __construct(array $config = array(
            'dsn' => 'sqlite:./database.db',
            'host' => '',
            'name' => '',
            'username' => '',
            'password' => '',
            'freeze' => false,
            'debug' => false,
        ))
        {
            $this->config = $config;
            
            // connect to redbean
            try {
                if (!R::testConnection()) {
                    if (!empty($this->config['host']) && !empty($this->config['name'])) {
                        R::setup(
                            'mysql:host='.$this->config['host'].';dbname='.$this->config['name'],
                            $this->config['username'],
                            $this->config['password']
                        );
                    } elseif (!empty($this->config['dsn'])) {
                        R::setup(
                            $this->config['dsn'],
                            $this->config['username'],
                            $this->config['password']
                        );
                    } else {
                        R::setup(
                            'mysql:host='.$this->config['host'].';dbname='.$this->config['name']
                        );
                    }
            
                    R::freeze(($this->config['freeze'] === true));
                    R::debug(($this->config['debug'] === true));
                }
            } catch (\RedBeanPHP\RedException $e) {
                exit($e->getMessage());
            }
        }

        /**
         * Inspect table
         *
         * json $plink->inspect([string]);
         *
         * @param array $params
         */
        public function inspect(array $params = array())
        {
            if (!empty($params[0])) {
                return R::inspect($params[0]);
            } else {
                return R::inspect();
            }
        }

        /**
         * Create bean
         *
         * json $plink->create(string, array);
         *
         * @param array $params
         */
        public function create(array $params = array())
        {
            $result = R::dispense($params[0]);
            $result->import($params[1]);
            R::store($result);

            return $result;
        }

        /**
         * Create bean
         *
         * json $plink->exec(string);
         *
         * @param array $params
         */
        public function exec(array $params = array())
        {
            return R::exec($params[0]);
        }

        /**
         * Find all
         *
         * json $plink->findAll(string, string, array);
         *
         * @link http://www.redbeanphp.com/index.php?p=/finding#find_all
         * @param array $params
         */
        public function findAll(array $params = array())
        {
            if (!empty($params[1]) && !empty($params[2])) {
                $result = R::findAll($params[0], $params[1], $params[2]);
            } elseif (!empty($params[1]) && empty($params[2])) {
                $result = R::findAll($params[0], $params[1]);
            } else {
                $result = R::findAll($params[0]);
            }

            return $result;
        }

        /**
         * Get all - multidimensional array
         *
         * json $plink->getAll(string, string, array);
         *
         * @link http://www.redbeanphp.com/index.php?p=/querying
         * @param array $params
         */
        public function getAll(array $params = array())
        {
            if (!empty($params[1])) {
                return R::getAll($params[0], $params[1]);
            } else {
                return R::getAll($params[0]);
            }
        }

        /**
         * Get row - fetch a single row
         *
         * json $plink->getRow(string, string, array);
         *
         * @link http://www.redbeanphp.com/index.php?p=/querying
         * @param array $params
         */
        public function getRow(array $params = array())
        {
            if (!empty($params[1])) {
                return R::getRow($params[0], $params[1]);
            } else {
                return R::getRow($params[0]);
            }
        }

        /**
         * Get col - fetch a single column
         *
         * json $plink->getRow(string, string, array);
         *
         * @link http://www.redbeanphp.com/index.php?p=/querying
         * @param array $params
         */
        public function getCol(array $params = array())
        {
            if (!empty($params[1])) {
                return R::getCol($params[0], $params[1]);
            } else {
                return R::getCol($params[0]);
            }
        }

        /**
         * Get cell - fetch a single cell
         *
         * json $plink->getRow(string, array);
         *
         * @link http://www.redbeanphp.com/index.php?p=/querying
         * @param array $params
         */
        public function getCell(array $params = array())
        {
            if (!empty($params[1])) {
                return R::getCell($params[0], $params[1]);
            } else {
                return R::getCell($params[0]);
            }
        }

        /**
         * Get associative col - fetch a associative array cell
         *
         * json $plink->getAssoc(string, array);
         *
         * @link http://www.redbeanphp.com/index.php?p=/querying
         * @param array $params
         */
        public function getAssoc(array $params = array())
        {
            if (!empty($params[1])) {
                return R::getCell($params[0], $params[1]);
            } else {
                return R::getCell($params[0]);
            }
        }

        /**
         * Get associative row - fetch a associative array row
         *
         * json $plink->getAssocRow(string, array);
         *
         * @link http://www.redbeanphp.com/index.php?p=/querying
         * @param array $params
         */
        public function getAssocRow(array $params = array())
        {
            if (!empty($params[1])) {
                return R::getAssocRow($params[0], $params[1]);
            } else {
                return R::getAssocRow($params[0]);
            }
        }

        /**
         * Find one
         *
         * json $plink->findAll(string, string, array);
         *
         * @link http://www.redbeanphp.com/index.php?p=/finding#find_one
         * @param array $params
         */
        public function findOne(array $params = array())
        {
            if (!empty($params[1]) && !empty($params[2])) {
                $result = R::findOne($params[0], $params[1], $params[2]);
            } elseif (!empty($params[1]) && empty($params[2])) {
                $result = R::findOne($params[0], $params[1]);
            } else {
                $result = R::findOne($params[0]);
            }

            return $result;
        }

        /**
         * Find Like
         *
         * json $plink->findAll(string, array, string);
         *
         * @link http://www.redbeanphp.com/index.php?p=/finding#find_like
         * @param array $params
         */
        public function findLike(array $params = array())
        {
            return R::findLike($params[0], $params[1], $params[2]);
        }

        /**
         * Find Or Create
         *
         * json $plink->findOrCreate(string, array, string);
         *
         * @link http://www.redbeanphp.com/index.php?p=/finding#find_create
         * @param array $params
         */
        public function findOrCreate(array $params = array())
        {
            return R::findOrCreate($params[0], $params[1]);
        }

        /**
         * Most recent row
         *
         * json $plink->mostRecentRow(string);
         *
         * @param array $params
         */
        public function mostRecentRow(array $params = array())
        {
            return R::findOne($params[0], ' ORDER BY id DESC LIMIT 1 ');
        }

        /**
         * Update bean by id
         * json $plink->update(string, id, array);
         *
         * @param array $params
         */
        public function update(array $params = array())
        {
            $result = R::load($params[0], $params[1]);
            $result->import($params[2]);

            R::store($result);
            return $result;
        }
        
        /**
         * Update bean by where query
         * json $plink->updateWhere(string, string, array);
         *
         * @param array $params
         */
        public function updateWhere(array $params = array())
        {
            $result = R::findOne($params[0], $params[1]);
            $result->import($params[2]);

            R::store($result);
            return $result;
        }

        /**
         * Count beans
         * json $plink->count(string [, array]);
         *
         * @param array $params
         */
        public function count(array $params = array())
        {
            if (!empty($params[1]) && !empty($params[2])) {
                $result = R::count($params[0], $params[1], $params[2]);
            } elseif (!empty($params[1]) && empty($params[2])) {
                $result = R::count($params[0], $params[1]);
            } else {
                $result = R::count($params[0]);
            }

            return $result;
        }

        /**
         * Save bean - alias of update()
         * json $plink->save(string, string, array);
         *
         * @param array $params
         */
        public function save(array $params = array())
        {
            return $this->update($params);
        }

        /**
         * Save bean by where - alias of updateWhere()
         * json $plink->saveWhere(string, string, array);
         *
         * @param array $params
         */
        public function saveWhere(array $params = array())
        {
            return $this->updateWhere($params);
        }

        /**
         * Delete bean by id
         *
         * json $plink->delete(string, int);
         *
         * @param array $params
         */
        public function delete(array $params = array())
        {
            $result = R::load($params[0], $params[1]);
            return R::trash($result);
        }
        
        /**
         * Delete bean by where query
         *
         * json $plink->delete(string, string);
         *
         * @param array $params
         */
        public function deleteWhere(array $params = array())
        {
            $result = R::findOne($params[0], $params[1]);
            return R::trash($result);
        }
        
        /**
         * Store bean
         * json $plink->store(object);
         *
         * @param array $params
         */
        public function store($bean)
        {
            return R::store($bean);
        }
                
        /**
         * Trash bean
         * json $plink->trash(object);
         *
         * @param array $params
         */
        public function trash($bean)
        {
            return R::trash($bean);
        }
        
        /**
         * Export
         * Exports bean into an array
         */
        public function export(\RedBeanPHP\OODBBean $row)
        {
            return R::exportAll($row);
        }
    }
}
