<?php
namespace Plinker\Tasks {

    use Plinker\Tasks\Lib;
    use Opis\Closure\SerializableClosure;

    class Manager
    {
        public $config = array();

        public function __construct(array $config = array())
        {
            $this->config = $config;

            // load model
            $this->model = new Model($this->config['database']);
        }

        /**
         *
         */
        public function create(array $params = array())
        {
            if (empty($params[0])) {
                return 'Error: missing first argument.';
            }

            if (empty($params[1])) {
                return 'Error: missing second argument.';
            }

            try {
                // find or create new task source
                $tasksource = $this->model->findOrCreate([
                    'tasksource',
                    'name' => $params[0]
                ]);
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            // update - source
            $tasksource->source = str_replace("\r", "", $params[1]);
            $tasksource->checksum = md5($params[1]);

            if (!empty($params[2])) {
                $tasksource->type = strtolower($params[2]);
            } else {
                $tasksource->type = '';
            }

            // description
            if (!empty($params[3])) {
                $tasksource->description = $params[3];
            } else {
                $tasksource->description = '';
            }

            // description
            if (!empty($params[4])) {
                $tasksource->params = $params[4];
            } else {
                $tasksource->params = '';
            }

            // update - Newd/updated date
            if (empty($tasksource->created)) {
                $tasksource->updated = date_create()->format('Y-m-d h:i:s');
                $tasksource->created = date_create()->format('Y-m-d h:i:s');
            } else {
                $tasksource->updated = date_create()->format('Y-m-d h:i:s');
            }

            // store
            $this->model->store($tasksource);

            //
            return $this->model->export($tasksource)[0];
        }

        /**
         *
         */
        public function update(array $params = array())
        {
            if (empty($params[0])) {
                return 'Error: missing first argument.';
            }

            if (!is_numeric($params[0])) {
                return 'Error: first argument must be the task id.';
            }

            if (empty($params[1])) {
                return 'Error: missing second argument.';
            }

            if (empty($params[2])) {
                return 'Error: missing third argument.';
            }

            // find or create new task source
            $tasksource = $this->model->load('tasksource', $params[0]);

            // update - source
            $tasksource->name = $params[1];
            $tasksource->source = str_replace("\r", "", $params[2]);
            $tasksource->checksum = md5($params[2]);

            // type
            if (!empty($params[3])) {
                $tasksource->type = strtolower($params[3]);
            } else {
                $tasksource->type = '';
            }

            // description
            if (!empty($params[4])) {
                $tasksource->description = $params[4];
            } else {
                $tasksource->description = '';
            }

            // params
            if (!empty($params[5])) {
                $tasksource->params = $params[5];
            } else {
                $tasksource->params = '';
            }

            // set updated/created date
            if (empty($tasksource->created)) {
                $tasksource->updated = date_create()->format('Y-m-d H:i:s');
                $tasksource->created = date_create()->format('Y-m-d H:i:s');
            } else {
                $tasksource->updated = date_create()->format('Y-m-d H:i:s');
            }

            // store
            $this->model->store($tasksource);

            //
            return $this->model->export($tasksource)[0];
        }

        /**
         *
         */
        public function get(array $params = array())
        {
            // get task
            return $this->model->findOne('tasksource', 'name = ?', [$params[0]]);
        }

        /**
         *
         */
        public function status(array $params = array())
        {
            // find or create new task source
            $task = $this->model->findOne('tasks', 'name = ?', [
                $params[0]
            ]);

            if (empty($task->id)) {
                return 'not found';
            }

            if (!empty($task->completed)) {
                return 'completed';
            }

            if (!empty($task->repeats) && empty($task->completed)) {
                return 'running';
            }

            return false;
        }

        /**
         *
         */
        public function runCount(array $params = array())
        {
            // find or create new task source
            $task = $this->model->findOne('tasks', 'name = ?', [
                $params[0]
            ]);

            if (empty($task->id)) {
                return 0;
            }

            if (!empty($task->run_count)) {
                return $task->run_count;
            }

            return 0;
        }

        /**
         *
         */
        public function getById(array $params = array())
        {
            return $this->model->load('tasksource', $params[0]);
        }

        /**
         *
         */
        public function removeById(array $params = array())
        {
            // get task
            $row = $this->model->load('tasksource', $params[0]);

            // remove all tasks
            foreach ($row->ownTasks as $tasks) {
                $this->model->trash($tasks);
            }

            // remove task
            $this->model->trash($row);

            return true;
        }

        /**
         *
         */
        public function getTaskSources(array $params = array())
        {
            // get task
            return $this->model->findAll('tasksource', 'LIMIT 1');
        }

        /**
         *
         */
        public function getTasksLog(array $params = array())
        {
            // get task
            if (!empty($params[0])) {
                return $this->model->findAll('tasks', 'tasksource_id = ? ORDER BY id DESC', [$params[0]]);
            } else {
                return $this->model->findAll('tasks');
            }
        }

        /**
         *
         */
        public function getTasks(array $params = array())
        {
            // get task
            if (!empty($params[0])) {
                return $this->model->findOne('tasks', 'id = ?', [$params[0]]);
            } else {
                return $this->model->findAll('tasks');
            }
        }

        /**
         *
         */
        public function getTasksLogCount(array $params = array())
        {
            // get task
            if (!empty($params[0])) {
                return $this->model->count('tasks', 'tasksource_id = ?', [$params[0]]);
            } else {
                return $this->model->count('tasks');
            }
        }

        /**
         *
         */
        public function removeTasksLog(array $params = array())
        {
            // get task
            $row = $this->model->load('tasks', $params[0]);
            $this->model->trash($row);

            return true;
        }

        /**
         * Run
         * Puts task in tasking table for deamon to run.
         */
        public function run(array $params = array())
        {
            // find or create new task source
            $task = $this->model->findOrCreate([
                'tasks',
                'name'   => $params[0],
                'params' => json_encode($params[1]),
                'repeats' => !empty($params[2]),
                'completed' => 0
            ]);

            $task->sleep = round((empty($params[2]) ? 1: $params[2]));

            // get task source id
            $task->tasksource = $this->model->findOne('tasksource', 'name = ?', [$params[0]]);

            if (empty($task->completed) && empty($task->result)) {
                // store task
                $this->model->store($task);
                return [];
            }

            // store task
            $this->model->store($task);

            return $this->model->export($task)[0];
        }

        /**
         * Run Now
         * Does not put task in tasking table for deamon to run.
         * note: will be run as apache user
         */
        public function runNow(array $params = array())
        {
            // get task
            $tasksource = $this->model->findOne('tasksource', 'name = ?', [$params[0]]);

            if (empty($tasksource)) {
                return ['error' => 'Task not found'];
            }

            if (empty($tasksource->source)) {
                $this->model->trash($tasksource);
                return ['error' => 'Task has no source, task has been removed'];
            }

            //
            if ($tasksource->type == 'php') {
                ob_start();
                eval('?>'.$tasksource->source);
                return ob_get_clean().$return;
            } elseif ($tasksource->type == 'bash') {
                file_put_contents('tmp/'.md5($task->tasksource->name).'.sh', $task->tasksource->source);
                ob_start();
                echo shell_exec('/bin/bash tmp/'.md5($task->tasksource->name).'.sh');
                return ob_get_clean();
            }

            return 'Invalid task type';
        }

        /**
         *
         */
        public function clear(array $params = array())
        {
            $this->model->exec('DELETE FROM tasks');

            return true;
        }

        /**
         *
         */
        public function reset(array $params = array())
        {
            $this->model->nuke();

            return true;
        }

        /**
         *
         */
        public function files(array $params = array())
        {

            // // This function scans the files folder recursively, and builds a large array
            // $scan = function ($dir, $initial) use ( &$scan ) {
            //     $files = array();
            //     // Is there actually such a folder/file
            //     if (file_exists($dir)) {
            //         $files[str_replace($initial, '/', $dir)][] = array(
            //             "name" => '..',
            //             "type" => "folder",
            //         );

            //         foreach(scandir($dir) as $f) {

            //             if(!$f || $f[0] == '.') {
            //                 continue;
            //             }

            //             if (is_dir($dir . '/' . $f)) {
            //                 // The path is a folder
            //                 $files[str_replace($initial, '/', $dir . '/' . $f)][] = array(
            //                     "name" => $f,
            //                     "type" => "folder",
            //                     //"path" => $dir . '/' . $f,
            //                     //"size" => filesize($dir . '/' . $f) // Gets the size of this file
            //                 );
            //                 $files[str_replace($initial, '/', $dir . '/' . $f)] = $scan($dir . '/' . $f, $initial);
            //             }
            //             else {
            //                 // It is a file
            //                 $files[str_replace($initial, '/', $dir )][] = array(
            //                     "name" => $f,
            //                     "type" => "file",
            //                     //"path" => $dir . '/' . $f,
            //                     //"size" => filesize($dir . '/' . $f) // Gets the size of this file
            //                 );
            //             }
            //         }

            //     }

            //     return $files;
            // };

            $dir = $params[0];

            // Create recursive dir iterator which skips dot folders
            $dir = new \RecursiveDirectoryIterator(
                $dir,
                \FilesystemIterator::SKIP_DOTS
            );

            // Flatten the recursive iterator, folders come before their files
            $it  = new \RecursiveIteratorIterator(
                $dir,
                \RecursiveIteratorIterator::SELF_FIRST
            );

            // Maximum depth is 1 level deeper than the base folder
            $it->setMaxDepth(100);

            // Basic loop displaying different messages based on file or folder
            foreach ($it as $fileinfo) {
                $curDir = (empty($it->getSubPath()) ? '' : $it->getSubPath());

                if ($fileinfo->isDir()) {
                    $return['/'.str_replace(['//', '/.'], ['/', '.'], $curDir)][] = array(
                        "name" => $fileinfo->getFilename(),
                        "type" => "folder",
                    );
                    //$return[str_replace(['//', '/.'], ['/', '.'], $curDir.'/'.$fileinfo->getFilename())] = array();
                } elseif ($fileinfo->isFile()) {
                    $return['/'.str_replace(['//', '/.'], ['/', '.'], $curDir)][] = array(
                        "name" => $fileinfo->getFilename(),
                        "type" => "file",
                    );
                }
            }

            // Run the recursive function

            //$response = $scan($dir, $dir);

            // Output the directory listing as JSON

            header('Content-type: application/json');

            return json_encode($return, JSON_NUMERIC_CHECK);
        }

        public function getFile(array $params = array())
        {
            if (file_exists($params[0])) {
                return base64_encode(file_get_contents($params[0]));
            } else {
                // create file
                file_put_contents($params[0], '');
                return base64_encode(file_get_contents($params[0]));
            }
        }

        public function deleteFile(array $params = array())
        {
            if (file_exists($params[0])) {
                unlink($params[0]);
                return base64_encode(true);
            } else {
                return base64_encode(true);
            }
        }

        public function saveFile(array $params = array())
        {
            if (file_exists($params[0])) {
                file_put_contents($params[0], base64_decode(@$params[1]));
                return base64_encode(true);
            } else {
                return base64_encode(true);
            }
        }
    }

}
